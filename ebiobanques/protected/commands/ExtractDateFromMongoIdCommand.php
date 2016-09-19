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
            $this->extractDate($user);
        }
    }

    /**
     * Extract user inscription date from mongoId, if inscription_date is not already set,and save user
     *
     * @param User $model
     */
    public function extractDate(User $model) {
        if (!isset($model->inscription_date) || $model->inscription_date == "") {
            $date = $model->_id->getTimestamp();
            $model->inscription_date = new MongoDate($date);
            try {
                $model->save(false);
            } catch (Exception $ex) {
                Yii::log('Cannot extract date from mongoId : ' . $ex->getTraceAsString(), CLogger::LEVEL_ERROR);
            }
        }
    }

//    public function actionTest() {
//        include_once dirname(dirname(dirname(__FILE__))) . DIRECTORY_SEPARATOR . 'StatTools.php';
//        $date = new DateTime;
//        $searchDate = $date->format('Y-m-d');
//        $criteria = new EMongoCriteria;
//        $criteria->biobank_id = "0";
//        $criteria->date = new MongoRegex('/' . $searchDate . '.*/i');
//        $criteria->date = new MongoRegex("/$searchDate.*/i");
//        $globalStats = !empty(BiobankStats::model()->find($criteria)) && BiobankStats::model()->find($criteria) != null ?
//                BiobankStats::model()->find($criteria) : new BiobankStats();
//        echo "$globalStats->date\n$globalStats->biobank_id\n";
//    }
}
?>