<?php

/**
 * Queue status widget/
 * Displays login form if current user is not logged in, or
 * regnumber and queue number if is logged in. 
 *
 * @author ftc
 */
class QueueStatus extends CWidget 
{
	public function run() 
	{
		$model = new LoginForm;
		$request = new Request;
		$user = User::model()->findByPk(Yii::app()->user->id);
		if ($user != null)
		{
			$request = Request::model()->find("reg_number='".$user->username."'");
		}
		$this->render("queueStatus", array(
								'model' => $model,
								'request' => $request,
								'user' => $user,
							));
    }
}
?>
