<?php

/**
 * Command to move biobank_id from old format to new MongoId
 */
class changeIdSampleCommand extends CConsoleCommand
{

    public function run() {
        echo 'Massive Run for samples';
        $biobanks = Biobank::model()->findAll();
        foreach ($biobanks as $biobank) {
            $modifier = new EMongoModifier();
            $modifier->addModifier('biobank_id', 'set', (string) $biobank->_id);
            $criteria = new EMongoCriteria();
            $criteria->biobank_id = $biobank->id;
            $status = Sample::model()->updateAll($modifier, $criteria);
            $criteriaAfter = new EMongoCriteria();
            $criteriaAfter->biobank_id = (string) $biobank->_id;

            $count = Sample::model()->count($criteriaAfter);
            echo "Done for biobank $biobank->_id - $biobank->name : $count\n";
        }
    }

}