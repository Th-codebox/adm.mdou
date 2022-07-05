<?php
class RbacCommand extends CConsoleCommand
{
	private $_authManager;
	public function getHelp()
	{
		return <<<EOD
USAGE
	rbac
DESCRIPTION
	This command generates an initial RBAC authorization hierarchy.
EOD;
	}
	/**
	* Execute the action.
	* @param array command line parameters specific for this command
	*/
	public function run($args)
	{
		//ensure that an authManager is defined as this is mandatory for creating an auth heirarchy
		if(($this->_authManager=Yii::app()->authManager)===null)
		{
			echo "Error: an authorization manager, named 'authManager' must be configured to use this command.\n";
			echo "If you already added 'authManager' component in application configuration,\n";
			echo "please quit and re-enter the yiic shell.\n";
			return;
		}
		//provide the oportunity for the use to abort the request
		echo "This command will create five roles: Applicant, ContentManager, QueueManager, SysAdmin, and QueueAdmin and the following premissions:\n";
		echo "create, read, update and delete user\n";
		echo "create, read, update and delete request\n";
		echo "create, read, update and delete references\n";
		echo "create, read, update and delete nurseries\n";
		echo "create, read, update and delete site items\n";
		echo "Would you like to continue? [Yes|No] ";
		//check the input from the user and continue if they indicated yes to the above question
		if(!strncasecmp(trim(fgets(STDIN)),'y',1))
		{
			//first we need to remove all operations, roles, child relationship and assignments
			$this->_authManager->clearAll();
			
			$this->_authManager->createOperation("accessBackend", "Доступ в админскую часть");
			
			$this->_authManager->createOperation("accessFrontendRequest", "Возможность подать заявление в клиентской части");

			//create the lowest level operations for users
			$this->_authManager->createOperation("createUser","create new user");
			$this->_authManager->createOperation("readUser","read user profile information");
			$this->_authManager->createOperation("updateUser","update a users information");
			$this->_authManager->createOperation("deleteUser","remove a user from a project");

			//create the lowest level operations for log
			$this->_authManager->createOperation("readLog","чтение журнала операций");

			//create the lowest level operations for references
			$this->_authManager->createOperation("createReference","create a new reference");
			$this->_authManager->createOperation("readReference","read reference information");
			$this->_authManager->createOperation("updateReference","update reference information");
			$this->_authManager->createOperation("deleteReference","delete a reference");

			//create the lowest level operations for nurseries
			$this->_authManager->createOperation("createNursery","create a new nursery");
			$this->_authManager->createOperation("readNursery","read nursery information");
			$this->_authManager->createOperation("updateNursery","update nursery information");
			$this->_authManager->createOperation("deleteNursery","delete a nursery");
			
			//create the lowest level operations for requests
			$this->_authManager->createOperation("createRequest","create a new request");
			$this->_authManager->createOperation("readRequest","read request information");
			$this->_authManager->createOperation("updateRequest","update request information");
			$this->_authManager->createOperation("deleteRequest","delete a request");

			//create the lowest level operations for site
			$this->_authManager->createOperation("createSite","create a new site item");
			$this->_authManager->createOperation("readSite","read site item information");
			$this->_authManager->createOperation("updateSite","update site item information");
			$this->_authManager->createOperation("deleteSite","delete a site item");			

			//create the  role and add the appropriate permissions as children to this role
			$role=$this->_authManager->createRole("contentManager", "Оператор сайта");
			$role->addChild("accessBackend");
			$role->addChild("createSite");
			$role->addChild("readSite");
			$role->addChild("updateSite");
			$role->addChild("deleteSite");
			$role->addChild("readNursery");

			//create the  role and add the appropriate permissions as children to this role
			$role=$this->_authManager->createRole("queueManager", "Оператор очереди");
			$role->addChild("accessBackend");
			$role->addChild("createRequest");
			$role->addChild("readRequest");
			$role->addChild("updateRequest");
			$role->addChild("deleteRequest");
			$role->addChild("createNursery");
			$role->addChild("readNursery");
			$role->addChild("updateNursery");
			$role->addChild("deleteNursery");
			$role->addChild("readReference");

			//create the owner role, and add the appropriate permissions  as children to this role
			$role=$this->_authManager->createRole("sysAdmin", "Администратор системы");
			$role->addChild("accessBackend");
			$role->addChild("readLog");
			$role->addChild("createUser");
			$role->addChild("readUser");
			$role->addChild("updateUser");
			$role->addChild("deleteUser");
			$role->addChild("createReference");
			$role->addChild("readReference");
			$role->addChild("updateReference");
			$role->addChild("deleteReference");
			$role->addChild("createNursery");
			$role->addChild("readNursery");
			$role->addChild("updateNursery");
			$role->addChild("deleteNursery");			

			//create the role and add the appropriate permissions as children to this role
			$role=$this->_authManager->createRole("applicant", "Заявитель");
			$role->addChild("accessFrontendRequest");

			//assign roles
			$auth=Yii::app()->authManager;
			$auth->assign('sysAdmin', 1);
			$auth->assign('queueManager', 1);
			$auth->assign('contentManager', 1);

			$auth->assign('sysAdmin', 2);
			
			//provide a message indicating success
			echo "Authorization hierarchy successfully generated.";
		}
	}
}
