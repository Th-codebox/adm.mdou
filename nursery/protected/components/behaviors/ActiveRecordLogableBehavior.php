<?php
class ActiveRecordLogableBehavior extends CActiveRecordBehavior
{
    private $_oldattributes = array();
 
    public function afterSave($event)
    {
        if (!$this->Owner->isNewRecord) {
 
            // new attributes
            $newattributes = $this->Owner->getAttributes();
            $oldattributes = $this->getOldAttributes();
 
            // compare old and new
            foreach ($newattributes as $name => $value) {
            	if ($name === "update_time" || $name === "update_user")
            		continue;
                if (!empty($oldattributes)) {
                    $old = $oldattributes[$name];
                } else {
                    $old = '';
                }
 
                if ($value != $old) {
                    //$changes = $name . ' ('.$old.') => ('.$value.'), ';
 
                    $log=new ActiveRecordLog;
                    $log->description = "Пользователь " . Yii::app()->user->Name 
                                       ." изменил поле '" . $this->Owner->getAttributeLabel($name) . "' у объекта "
                                       . get_class($this->Owner) 
                                       . "[" . $this->Owner->getPrimaryKey() ."].";
                    $log->action = 'ИЗМЕНЕНИЕ';
                    $log->model = get_class($this->Owner);
                    $log->model_id = $this->Owner->getPrimaryKey();
                    $attr = $this->Owner->getAttributes();
                    $log->field = $this->Owner->getAttributeLabel($name);
                    $log->create_time = new CDbExpression('NOW()');
                    $log->create_user_id = 1; //Yii::app()->user->id;
                    $log->save();
/*					if (!$log->save()) {
						foreach ($log->getErrors() as $error) {
							foreach ($error as $e)
								print $e."<br>";
						}
					}*/
                }
            }
        } else {
            $log=new ActiveRecordLog;
            $log->description=  'Пользователь ' . Yii::app()->user->Name 
                                    . ' создал объект ' . get_class($this->Owner) 
                                    . '[' . $this->Owner->getPrimaryKey() .'].';
            $log->action = 'СОЗДАНИЕ';
            $log->model = get_class($this->Owner);
            $log->model_id = $this->Owner->getPrimaryKey();
            $log->field = '';
            $log->create_time = new CDbExpression('NOW()');
            $log->create_user_id = 1; //Yii::app()->user->id;
//            $log->save();
			if (!$log->save()) {
				foreach ($log->getErrors() as $error) {
					foreach ($error as $e)
						print $e."<br>";
				}
			}
        }
    }
 
    public function afterDelete($event)
    {
        $log=new ActiveRecordLog;
        $log->description=  'Пользователь ' . Yii::app()->user->Name . ' удалил объект ' 
                                . get_class($this->Owner) 
                                . '[' . $this->Owner->getPrimaryKey() .'].';
        $log->action = 'УДАЛЕНИЕ';
        $log->model = get_class($this->Owner);
        $log->model_id = $this->Owner->getPrimaryKey();
        $log->field = '';
        $log->create_time = new CDbExpression('NOW()');
        $log->create_user_id = 1; //Yii::app()->user->id;
        $log->save();
/*			if (!$log->save()) {
				foreach ($log->getErrors() as $error) {
					foreach ($error as $e)
						print $e."<br>";
				}
			}*/

    }
 
    public function afterFind($event)
    {
        // Save old values
        $this->setOldAttributes($this->Owner->getAttributes());
    }
 
    public function getOldAttributes()
    {
        return $this->_oldattributes;
    }
 
    public function setOldAttributes($value)
    {
        $this->_oldattributes=$value;
    }
}
