<?php

class SiteController extends Controller
{
	/**
	 * Declares class-based actions.
	 */
	public function actions()
	{
		return array(
			// captcha action renders the CAPTCHA image displayed on the contact page
			'captcha'=>array(
				'class'=>'CCaptchaAction',
				'backColor'=>0xFFFFFF,
			),
			// page action renders "static" pages stored under 'protected/views/site/pages'
			// They can be accessed via: index.php?r=site/page&view=FileName
			'page'=>array(
				'class'=>'CViewAction',
			),
		);
	}

	/**
	 * This is the default 'index' action that is invoked
	 * when an action is not explicitly requested by users.
	 */
	public function actionIndex()
	{
		// we will render as we called section with id=1 (root section)
		$_GET['id'] = 1;
		// change layout as front page looks different
		$this->layout = 'front';
		$this->actionSection();
	}

	/**
	 * This is the action to handle external exceptions.
	 */
	public function actionError()
	{
	    if($error=Yii::app()->errorHandler->error)
	    {
	    	if(Yii::app()->request->isAjaxRequest)
	    		echo $error['message'];
	    	else
	        	$this->render('error', $error);
	    }
	}

	/**
	 * Displays the contact page
	 */
	public function actionContact()
	{
		$model=new ContactForm;
		if(isset($_POST['ContactForm']))
		{
			$model->attributes=$_POST['ContactForm'];
			if($model->validate())
			{
				$headers="From: {$model->email}\r\nReply-To: {$model->email}";
				mail(Yii::app()->params['adminEmail'],$model->subject,$model->body,$headers);
				Yii::app()->user->setFlash('contact','Thank you for contacting us. We will respond to you as soon as possible.');
				$this->refresh();
			}
		}
		$this->render('contact',array('model'=>$model));
	}

	/**
	 * Displays the login page
	 */
	public function actionLogin()
	{
		$model = new LoginForm;

		// if it is ajax validation request
		if(isset($_POST['ajax']) && $_POST['ajax']==='login-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}

		// collect user input data
		if(isset($_POST['LoginForm']))
		{
			$model->attributes=$_POST['LoginForm'];
			// validate user input and redirect to the previous page if valid
			if($model->validate() && $model->login())
			{
				// redirect to "my queue page"
				$this->redirect(array('site/status', ));
			}
		}
		// display the login form
		$this->render('login',array('model'=>$model));
	}

	/**
	 * Logs out the current user and redirect to homepage.
	 */
	public function actionLogout()
	{
		Yii::app()->user->logout();
		$this->redirect(Yii::app()->homeUrl);
	}
	
	public function actionSection()
	{
		$node = null;
		if(isset($_GET['id']))
			$node=Node::model()->findbyPk($_GET['id']);
		else
			$node = $node=Node::model()->findbyPk(Node::$ROOT_ID);
		if($node===null || !$node->status_id)
			throw new CHttpException(404,'The requested page does not exist.');

		Photo::enableLightBox();
		
		$files = $node->getRelated('files', false, array());
		/*$gallery = array();
		foreach($node->photos as $photo) {
			if ($photo->id == $node->photoId || !$photo->isGallery)
				continue;

			array_push($gallery, $photo);
		}
		*/
		if (isset($_GET['preview']) && $_GET['preview'] == 'on')
			$this->renderPartial('sectionPreview',
				array(
					'node'=>$node,
					'files'=>$files,
//					'gallery'=>$gallery,
				)
			);
		else
			$this->render('section',
				array(
					'node'=>$node,
					'files'=>$files,
//					'gallery'=>$gallery,
				)
			);
	}

	public function actionNurseries()
	{
		$nurseries = new CActiveDataProvider('Nursery', array(
			'sort'=>array(
				'defaultOrder'=>'short_number, name ASC, id ASC'
			),
			'pagination'=>array(
				'pageSize'=> 12,
			),
		));
		$this->layout = 'main_wide';
		$this->render('nurseries',
				array(
					'nurseries' => $nurseries,
					'pagination' => $nurseries->pagination,
				)
			);
	}
	
	public function actionRequest()
	{
		$step = isset($_POST['step']) ? $_POST['step'] : (isset($_GET['step']) ? $_GET['step'] : 1);
		$id = isset($_POST['id']) ? $_POST['id'] : (isset($_GET['id']) ? $_GET['id'] : -1);
		$motherinfochecked = isset($_POST['motherinfochecked']) ? $_POST['motherinfochecked'] : "";
		$fatherinfochecked = isset($_POST['fatherinfochecked']) ? $_POST['fatherinfochecked'] : "";
		$privilege0infochecked = isset($_POST['privilege0infochecked']) ? $_POST['privilege0infochecked'] : "";
		$privilege1infochecked = isset($_POST['privilege1infochecked']) ? $_POST['privilege1infochecked'] : "";
		$fromform = isset($_POST['fromform']) ? $_POST['fromform'] : -1;
		if ($id == "") { $id = -1; }
		if ($id == -1) { $step = 1; }
		// here we are to create a new blank request with some default fields
		// or extract our request from database
		if ($id != -1)
		{
			$request = Request::model()->findByPk($id);
			if ($request == null)
			{
				$step = 0;
				$request = new Request;
			}
			else if ($request->status != Request::STATUS_NOTCOMPLETED)
			{
				$step = 0;
				$request = new Request;
			}
		}
		else
		{
			$request = new Request;
		}
		// for every step fill needed database table fields, and try to save
		// if validation succeeds, proceed to next step, otherwise continue
		// to render this step (until all errors corrected)
		$requester = new Person;
		if ($request->getApplicant()) $requester = $request->getApplicant();
		$requester->setScenario('requester');
		$mother = new Person;
		if ($request->getMother()) $mother = $request->getMother();
		$father = new Person;
		if ($request->getFather()) $father = $request->getFather();
		$user = new User;
		if ($step == 1)
		{
			if ($fromform == 1) 
			{
				$request->attributes = $_POST['Request'];
				$request->setScenario('clientCreate');
				$request->verify_code = isset($_POST['Request']['verify_code']) ? $_POST['Request']['verify_code'] : "";
				$request->agreement = isset($_POST['Request']['agreement']) ? $_POST['Request']['agreement'] : 0;
				if ($request->save(true, array('surname', 'name', 'patronymic', 'birth_date', 'document_series', 'document_number', 'document_date', 'create_time', 'create_user_id', 'update_time', 'update_user_id', 'full_name', 'verify_code', 'agreement')))
				{
					$request->reg_number = 0;
					$maxQueueNumber = $request->getDbConnection()->createCommand("SELECT MAX(`queue_number`) FROM {$request->tableName()}")->queryScalar();
					$request->queue_number = $maxQueueNumber + 1;
					$request->is_internet = 1;
					$request->status = Request::STATUS_NOTCOMPLETED;
					$request->filing_date = new CDbExpression('NOW()');
					if ($request->save(false)) 
					{
						$request->generateRegNumber();
						$request->saveAttributes(array('reg_number' => $request->reg_number, 'status' => Request::STATUS_NOTCOMPLETED));
						if (isset($_FILES['birth_document']))
						{
							$cuf = CUploadedFile::getInstanceByName("birth_document");
							if ($cuf != null)
							{
								$ourfile = new File;
								$ourfile->file = $cuf;
								$ourfile->fill($request);
								$request->saveBirthDocument($ourfile);
							}
						}
						$step++;
					}
				}
			}
		}
		else if ($step == 2)
		{
			$requester = new Person;
			if ($request->hasApplicant()) { $requester = $request->getApplicant(); }
			if ($fromform == 2)
			{
				$requester->setScenario('requester');
				$requester->attributes = $_POST['Person'];
				$requester->is_applicant = 1;
				$requester->request_id = $id;
				if ($requester->save())
				{
					$step++;
				}
			}
		}
		else if ($step == 3)
		{
			if ($fromform == 3) 
			{
				$request->attributes = $_POST['Request'];
				if ($request->save(true, array('address_other', 'town_id', 'microdistrict_id', 'street_id', 'house', 'building', 'flat', 'phone', 'email', 'is_email_confirm')))
				{
					$step++;
					if ($request->getMother()) $motherinfochecked = "on";
					if ($request->getFather()) $fatherinfochecked = "on";
				}
			}
		}
		else if ($step == 4)
		{
			if ($fromform == 4)
			{
				if (isset($_POST['Person']['mother']))
					$mother->attributes = $_POST['Person']['mother'];
				if (isset($_POST['Person']['father']))
					$father->attributes = $_POST['Person']['father'];
				$ok = 1;
				if ($motherinfochecked == "on")
				{
					if (!$mother->validate())
					{
						$ok = 0;
					}
				}
				else
				{
					$request->deleteMother();
				}
				if ($fatherinfochecked == "on")
				{
					if (!$father->validate())
					{
						$ok = 0;
					}
				}
				else
				{
					$request->deleteFather();
				}
				if ($ok)
				{
					$mother->request_id = $id;
					$mother->applicant_type_id = Person::TYPE_MOTHER;
					if ($motherinfochecked == "on")
					{
						$mother->save();
					}
					$father->request_id = $id;
					$father->applicant_type_id = Person::TYPE_FATHER;
					if ($fatherinfochecked == "on")
					{
						$father->save();
					}
					$step++;
					if (count($request->privilegeDocuments) > 0) $privilege0infochecked = "on";
					if (count($request->privilegeDocuments) > 1) $privilege1infochecked = "on";
				}
			}
			else
			{
				if ($request->getMother()) $motherinfochecked = "on";
				if ($request->getFather()) $fatherinfochecked = "on";
			}
		}
		else if ($step == 5)
		{
			if ($fromform == 5)
			{
				$addprivilege = isset($_POST['addprivilege']) ? $_POST['addprivilege'] : "no";
				// load privilege information from form
				$pdocs = array();
				if (isset($_POST['PrivilegeDocument']))
				{
					foreach ($_POST['PrivilegeDocument'] as $i=>$pdocinfo)
					{
						if ($i == 0 && $privilege0infochecked != "on") continue;
						if ($i == 1 && $privilege1infochecked != "on") continue;
						$pdoc = new PrivilegeDocument;
						$pdoc->attributes = $pdocinfo;
						$pdfiles = array();
						if (isset($_FILES["File_$i"]))
						{
							$cufs = CUploadedFile::getInstancesByName("File_$i");
							foreach ($cufs as $cuf)
							{
								$ourfile = new File;
								$ourfile->file = $cuf;
								$ourfile->fill($pdoc);
								array_push($pdfiles, $ourfile);
							}
						}
						$pdoc->files = $pdfiles;
						array_push($pdocs, $pdoc);
					}
				}
				$request->privilegeDocuments = $pdocs;
				if ($addprivilege == "yes")
				{
					// do nothing except adding one more blank privilegedocument into model privileges
					$pdocs = $request->privilegeDocuments;
					if (count($pdocs) >= 2)
					{
						$request->addError('privilegeDocuments', 'Льгот не может быть больше двух');
					}
					else
					{
						$pdoc = new PrivilegeDocument;
						array_push($pdocs, $pdoc);
						$request->privilegeDocuments = $pdocs;
					}
				}
				else
				{
					// here we are to store privilegeDocuments data in the database
					// let us validate all of them
					$ok = 1;
					foreach ($request->privilegeDocuments as $pdoc)
					{
						$pdoc->request_id = $id;
						if (!$pdoc->validate())
						{
							$ok = 0;
						}
					}
					if ($ok == 1)
					{
						if ($request->savePrivilegeDocuments())
						{
							$step++;
						}
					}
				}
			}
			else
			{
				if (count($request->privilegeDocuments) > 0) $privilege0infochecked = "on";
				if (count($request->privilegeDocuments) > 1) $privilege1infochecked = "on";
			}
		}
		else if ($step == 6)
		{
			if ($fromform == 6)
			{
				$disease_id = isset($_POST['Request']['disease_id']) ? $_POST['Request']['disease_id'] : 0;
				$request->disease_id = $disease_id;
				$nurseries = isset($_POST['Request']['nurseries']) ? $_POST['Request']['nurseries'] : array();
				$cnt = 0;
				$ok = 1;
				if (!$request->save(true, array('disease_id')))
				{
					$ok = 0;
				}
				foreach ($nurseries as $nid)
				{
					if (Nursery::model()->findByPk($nid) === null)
					{
						$ok = 0;
					}
					$cnt++;
				}
				if ($ok == 1 && $cnt <= 3)
				{
					$request->nurseries = $nurseries;
					$request->saveNurseries();
					if ($request->createUser())
					{
						$user = $request->user;
						// login newly created user
						$lf = new LoginForm;
						$lf->username = $user->username;
						$lf->password = $user->password_unencrypted;
						$lf->login();
						//
						$request->status = Request::STATUS_UNPROCESSED;
						if ($request->save(false, array('status')))
						{
							$request->logQueueNumber(QueueLog::TYPE_ENQUEUE);
							$request->DeleteApplyOperations();
							$oplog = new OperationLog;
							$oper = Operation::model()->findByPk(Operation::OPERATION_APPLY);
							$oplog->new_status = $oper->new_request_status;
							$oplog->request_id = $request->id;
							$oplog->operation_id = $oper->id;
							$oplog->save(false);
							$step++;
						}
					}
				}
				if ($cnt > 3)
				{
					$request->addError('nurseries', 'Можно выбрать не более трех МДОУ.');
				}
			}
		}
		else $step = 1;
		$this->render('request_step'.$step,
					array(
						'model' => $request,
						'requester' => $requester,
						'mother' => $mother,
						'father' => $father,
						'motherinfochecked' => $motherinfochecked,
						'fatherinfochecked' => $fatherinfochecked,
						'privilege0infochecked' => $privilege0infochecked,
						'privilege1infochecked' => $privilege1infochecked,
						'user' => $user
					)
				);
	}
	
	public function actionStatus()
	{
		$user = User::model()->findByPk(Yii::app()->user->id);
		if ($user == null)
		{
			$this->redirect(array(
					'site/login',
			));
		}
		$fromform = isset($_POST['fromform']) ? $_POST['fromform'] : "";
		$saved = "";
		if ($fromform == "yes")
		{
			$request = Request::model()->find("reg_number='".$user->username."'");
			//$request->status = Request::STATUS_MODIFIED;
			$request->attributes = isset($_POST['Request']) ? $_POST['Request'] : array();
			$nurseries = isset($_POST['Request']['nurseries']) ? $_POST['Request']['nurseries'] : array();
			$cnt = 0;
			$ok = 1;
			if (!$request->save(true, array('disease_id', 'address_other', 'town_id', 'microdistrict_id', 'street_id', 'house', 'building', 'flat', 'phone', 'email', 'is_email_confirm')))
			{
				$ok = 0;
			}
			foreach ($nurseries as $nid)
			{
				if (Nursery::model()->findByPk($nid) === null)
				{
					$ok = 0;
				}
				$cnt++;
			}
			if ($ok == 1 && $cnt <= 3)
			{
				$request->nurseries = $nurseries;
				$request->saveNurseries();
			}
			if ($cnt > 3)
			{
				$request->addError('nurseries', 'Можно выбрать не более трех МДОУ.');
			}
			$saved = "yes";
		}
		$request = Request::model()->find("reg_number='".$user->username."'");
		$this->render("status", array(
								'request' => $request,
								'user' => $user,
								'saved' => $saved,
							));
	}
	
	public function actionStatistics()
	{
		$this->layout = 'main_wide';
		$model = new Statistics;
		$this->render("statistics", array(
								'model' => $model,
							));
	}
	
	
	public function actionAjaxNurseries()
	{
		$diseaseId = isset($_POST['disease_id']) ? $_POST['disease_id'] : 0;
		$microdistrictId = isset($_POST['microdistrict_id']) ? $_POST['microdistrict_id'] : 0;
		
		$data = array();
		
		if ($diseaseId == 0 && $microdistrictId == 0) {
			$data = Nursery::model()->findAll(array(
				'order' => 'short_number ASC',
			));
		}
		else {
            $criteria = new CDbCriteria;
            
            if ($microdistrictId != 0) {
				$criteria->addCondition('microdistrict_id=:microdistrict_id');
				$criteria->params[':microdistrict_id'] = $microdistrictId;
			}
			if ($diseaseId != 0) {
				$criteria->join = "LEFT JOIN tbl_nursery_disease_assignment ON t.id=tbl_nursery_disease_assignment.nursery_id";
				$criteria->addCondition('tbl_nursery_disease_assignment.disease_id=:disease_id');
				$criteria->params[':disease_id'] = $diseaseId;
			}
			$criteria->order = "short_number ASC";

            $data = Nursery::model()->findAll($criteria);
		}

		$data=CHtml::listData($data, 'id', 'Name');

		foreach($data as $value=>$name)
		{
			echo CHtml::tag('option',
			   array('value'=>$value),CHtml::encode($name), true);
		}
	}

	public function actionReportRequest()
	{
		$user = User::model()->findByPk(Yii::app()->user->id);
		if ($user == null)
		{
			$this->redirect(array(
					'site/login',
			));
		}
		$request = Request::model()->find("reg_number='".$user->username."'");
		$this->renderFile("./protected/views/back/request/reports/reportRequest.php", array(
									'model' => $request,
								));
	}
	
	// returns menu array for SMenu widget
	public function getMainMenu()
	{
		$result = $this->getMenu(Node::$ROOT_ID, 1);
		return $result;
	}
	
	public function getMenu($id, $first)
	{
		$curnode = Node::model()->findByPk($id);
		$label = "";
		if ($curnode->parent_id == Node::$ROOT_ID && !$first)
		{
			$label .= "<img style=\"padding-top:0px;padding-bottom:2px;padding-right:8px;padding-left:1px;\" border=0 src=\"".Yii::app()->request->baseUrl."/images/front/menu_marker.gif\" width=\"4\" height=\"7\" alt=\"\"/>";
		}
		$label .= $curnode->getName();
		$result = array('url'=>array(
							'link' => $curnode->getFrontLink(array('class' => "menu")),
							),
							'label' => $label,
							);
		$children = Node::model()->findAll(
			array(
				'condition' => 'parent_id=:parent_id',
				'params' => array(':parent_id'=>$id),
				'order' => 'priority',
			)
		);
		$first = 1;
		foreach ($children as $child)
		{
			if ($child->status_id && $child->is_show_front)
			{
				array_push($result, $this->getMenu($child->id, $first));
				$first = 0;
			}
		}
		return $result;
	}
}