<?php

class NodeController extends BackEndController
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column1';

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		if (!Yii::app()->user->checkAccess('createSite'))
			throw new CHttpException(403,'Недостаточно прав для выполнения операции');

		$model=new Node;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);
		if (isset($_GET['parent_id']))
		$model->parent_id = $_GET['parent_id'];

		
		if(isset($_POST['Node']))
		{
			$model->attributes=$_POST['Node'];
			
			$model->setPriority();
			
			if($model->save())
				$this->redirect(array('index','id'=>$model->parent_id));
		}

		$this->render('create',array(
			'model'=>$model,
		));
	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id)
	{
		if (!Yii::app()->user->checkAccess('updateSite'))
			throw new CHttpException(403,'Недостаточно прав для выполнения операции');

		$model=$this->loadModel($id);

		$oldPriority = $model->priority;
		$oldParentId = $model->parent_id;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);
		
		if(isset($_POST['Node']))
		{
			$model->attributes = $_POST['Node'];
			if($model->save()) {
				if ($model->parent_id != $oldParentId) {
					$model->setPriority();
					Node::decreaseSiblingsPriorities($oldParentId, $oldPriority);
				}
			    $this->redirect(array('index','id'=>$model->parent_id));
			}
		}

		$this->render('update',array(
			'model'=>$model,
		));
	}

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'index' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete($id)
	{
		if(Yii::app()->request->isPostRequest && Yii::app()->user->checkAccess('deleteSite'))
		{
		    $node = $this->loadModel($id);

			if (count($node->children) == 0) {
					$parentId = $node->parent_id;
					$priority = $node->priority;

					$node->delete();
					Node::decreaseSiblingsPriorities($parentId, $priority);

					// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
					if(!isset($_GET['ajax']))
						$this->redirect(array('index', 'id'=>$parentId));
				}
		}
		else
			throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
	}
	
	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		if (!Yii::app()->user->checkAccess('readSite'))
			throw new CHttpException(403,'Недостаточно прав для выполнения операции');

		if (isset($_GET['id']) && $_GET['id'] > 0)
			$node = $this->loadModel($_GET['id']);
		else
			$node = Node::model()->findByPk(Node::$ROOT_ID);

//		if ($node == null)
//			throw new Exception(400, "Root section not found");

		$openedNodes = $node->getOpenedNodes();

		$tree = Node::model()->buildTree(0, (isset($_GET['id']) ? false : true),
			$openedNodes);

	    $childrenDataProvider=new CActiveDataProvider('Node', array(
		    'criteria'=>array(
			    'condition'=>'parent_id=:parent_id',
			    'params'=>array(':parent_id'=>$node->id),
			    'order'=>'priority ASC, name ASC',
		    ),
			'pagination'=> false,
	    ));

	    $this->render('index', array(
		    'tree' => $tree,
		    'childrenDataProvider' => $childrenDataProvider,
		    'node' => $node,
		));
	}

    /**
     * Decrease priority of a section moving it up.
     * the browser will be redirected to the 'index' page.
     */
    public function actionUp($id)
    {
		if (!Yii::app()->user->checkAccess('updateSite'))
			throw new CHttpException(403,'Недостаточно прав для выполнения операции');

	    $node=$this->loadModel($id);

	    if (isset($node)) {
		    if ($node->priority > 1) {
			    // find the row with the previous priority
			    $prevNodes=Node::model()->findAll(array(
					'condition'=>'parent_id=:parent_id and priority < :priority',
					'params'=>array(
						':parent_id'=>$node->parent_id,
						':priority'=>$node->priority,
					),
					'order'=>'priority DESC',
					'limit'=>1,
				));

			    if (count($prevNodes) == 1) {
					$prevNode = $prevNodes[0];
					$prevPriority = $prevNode->priority;
				    $prevNode->priority = $node->priority;
				    $prevNode->save();

				    $node->priority = $prevPriority;
				    $node->save();
			    }
		    }

		    $this->redirect(array('index','id'=>$node->parent_id));
	    }

	    // Uncomment the following line if AJAX validation is needed
	    // $this->performAjaxValidation($model);
    }

    /**
     * Decrease priority of a section moving it up.
     * the browser will be redirected to the 'index' page.
     */
    public function actionDown($id)
    {
		if (!Yii::app()->user->checkAccess('updateSite'))
			throw new CHttpException(403,'Недостаточно прав для выполнения операции');

	    $node=$this->loadModel($id);

	    if (isset($node)) {
			// find the row with the previous priority

			$nextNodes=Node::model()->findAll(array(
				'condition'=>'parent_id=:parent_id and priority > :priority',
				'params'=>array(
					':parent_id'=>$node->parent_id,
					':priority'=>$node->priority,
				),
				'order'=>'priority ASC',
				'limit'=>1,
			));

			if (count($nextNodes) == 1) {
				$nextNode = $nextNodes[0];

				$nextPriority = $nextNode->priority;
				$nextNode->priority = $node->priority;
				$nextNode->save();

				$node->priority = $nextPriority;
				$node->save();
			}

		    $this->redirect(array('index','id'=>$node->parent_id));
	    }

	    // Uncomment the following line if AJAX validation is needed
	    // $this->performAjaxValidation($model);
    }

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer the ID of the model to be loaded
	 */
	public function loadModel($id)
	{
		$model=Node::model()->findByPk((int)$id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}
	
	public function actionSetOrderAlphabet()
	{
		if (!Yii::app()->user->checkAccess('updateSite'))
			throw new CHttpException(403,'Недостаточно прав для выполнения операции');

		$node = $this->loadModel();
		$node->setOrder("alphabet");

		$this->redirect(array('index','id'=>$node->id));
	}

	public function actionSetOrderId()
	{
		if (!Yii::app()->user->checkAccess('updateSite'))
			throw new CHttpException(403,'Недостаточно прав для выполнения операции');

		$node = $this->loadModel();
		$node->setOrder("id");

		$this->redirect(array('index','id'=>$node->id));
	}

	/**
	 * Performs the AJAX validation.
	 * @param CModel the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='node-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
