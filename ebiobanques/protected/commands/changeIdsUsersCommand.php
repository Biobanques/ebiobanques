<?php

class changeIdsUsersCommand extends CConsoleCommand
{

    public function run() {

        $users = User::model()->findAll();
        foreach ($users as $user) {

            $criteria = new EMongoCriteria;
            $criteria->id = $user->biobank_id;
            $biobank = Biobank::model()->find($criteria);

            if ($user->biobank_id === "") {
                $user->unsetAttributes(array('biobank_id'));
                $user->biobank_id = null;
                $user->update();
            }
            if (!isset($user->biobank_id)) {
                $user->biobank_id = null;
                $user->update();
            } else if (is_a($user->biobank_id, 'MongoId')) {

                $user->biobank_id = (string) $user->biobank_id;
                $user->update();
            } else {
                $biobank = Biobank::model()->findByAttributes(array('id' => $user->biobank_id));
                if ($biobank != null) {
                    $user->biobank_id = (string) $biobank->_id;
                    $user->update();
                }
            }
        }
    }

}