<?php

class LoggableBehavior extends CActiveRecordBehavior
{
    private $_oldattributes = array();

    public function afterSave($event) {
        try {
            $username = Yii::app()->user->Name;
            $userid = Yii::app()->user->id;
        } catch (Exception $e) { //If we have no user object, this must be a command line program
            $username = 'NO_USER';
            $userid = null;
        }

        if (empty($username)) {
            $username = 'NO_USER';
        }

        if (empty($userid)) {
            $userid = null;
        }

        $newattributes = $this->Owner->getAttributes();
        $oldattributes = $this->getOldAttributes();

        if (!$this->Owner->isNewRecord) {
            // compare old and new
            foreach ($newattributes as $name => $value) {
                if (!empty($oldattributes) && isset($oldattributes[$name])) {
                    $old = $oldattributes[$name];
                } elseif (!empty($oldattributes) && !isset($oldattributes[$name])) {
                    $old = 'Undefined : new attribute';
                } else {
                    $old = '';
                }

                if ($value != $old) {
//                if (is_string($value) && ($value != $old)) {
                    $log = new AuditTrail();

                    $log->old_value = $old;

                    if (is_string($value))
                        $log->new_value = $value;
                    else {

                        $log->new_value = json_decode(json_encode($value));
                    }
                    $log->action = 'CHANGE';
                    $log->model = get_class($this->Owner);
                    $log->model_id = $this->Owner->getPrimaryKey();
                    $log->field = $name;
                    $log->stamp = date('Y-m-d H:i:s');
                    $log->user_id = $userid;

                    $log->save();
                }
            }
        } else {
            $log = new AuditTrail();
            $log->old_value = '';
            $log->new_value = '';
            $log->action = 'CREATE';
            $log->model = get_class($this->Owner);
            $log->model_id = $this->Owner->getPrimaryKey();
            $log->field = 'N/A';
            $log->stamp = date('Y-m-d H:i:s');
            $log->user_id = $userid;

            $log->save();


            foreach ($newattributes as $name => $value) {
                $log = new AuditTrail();
                $log->old_value = '';
                if (is_string($value))
                    $log->new_value = $value;
                else {

                    $log->new_value = json_decode(json_encode($value));
                }
                $log->action = 'SET';
                $log->model = get_class($this->Owner);
                $log->model_id = $this->Owner->getPrimaryKey();
                $log->field = $name;
                $log->stamp = date('Y-m-d H:i:s');
                $log->user_id = $userid;
                $log->save();
            }
        }
        return parent::afterSave($event);
    }

    public function afterDelete($event) {

        try {
            $username = Yii::app()->user->Name;
            $userid = Yii::app()->user->id;
        } catch (Exception $e) {
            $username = 'NO_USER';
            $userid = null;
        }

        if (empty($username)) {
            $username = 'NO_USER';
        }

        if (empty($userid)) {
            $userid = null;
        }

        $log = new AuditTrail();
        $log->old_value = '';
        $log->new_value = '';
        $log->action = 'DELETE';
        $log->model = get_class($this->Owner);
        $log->model_id = $this->Owner->getPrimaryKey();
        $log->field = 'N/A';
        $log->stamp = date('Y-m-d H:i:s');
        $log->user_id = $userid;
        $log->save();
        return parent::afterDelete($event);
    }

    public function afterFind($event) {
        // Save old values
        $this->setOldAttributes($this->Owner->getAttributes());

        return parent::afterFind($event);
    }

    public function getOldAttributes() {
        return $this->_oldattributes;
    }

    public function setOldAttributes($value) {
        $this->_oldattributes = $value;
    }

}
?>