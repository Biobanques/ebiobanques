<?php

/**
  Extract date from a mongoId
 *
 */
class ExtractDateFromMongoIdCommand extends CConsoleCommand
{

    /**
     *
     * @codeCoverageIgnore
     * @param type $args
     */
    public function run($args) {
        $users = User::model()->findAll();

        foreach ($users as $user) {
            CommonTools::extractDate($user);
            try {
                $user->save(false);
            } catch (Exception $ex) {
                Yii::log('Cannot extract date from mongoId : ' . $ex->getTraceAsString(), CLogger::LEVEL_ERROR);
            }
        }
    }

}
?>