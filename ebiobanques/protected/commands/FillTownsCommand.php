<?php

/**
 * command to fill data into contat with towns.
 * ste postal code
 * @author nicolas
 */
class FillTownsCommand extends CConsoleCommand {

    public function run($args) {
        //uppar case for each last name of contact
        $criteria = new EMongoCriteria;
        $criteria->sort('last_name', EMongoCriteria::SORT_ASC);
        $contacts = Contact::model()->findAll($criteria);
        foreach ($contacts as $model) {
            $town = $model->ville;
            $postalCode = $this->getPostalCode($town);
            if ($postalCode != null) {
                try {
                    $model->code_postal = $postalCode;
                    $model->update();
                } catch (Exception $e) {
                    echo 'Exception reçue pour le model: ' . $model->ville, $e->getMessage(), "\n";
                }
            }
        }
    }

    /**
     * call an api to get a postal code with the town.
     */
    public function getPostalCode($town) {
        $cp = null;
        try {
            $response = file_get_contents('http://geobot.malservet.eu/index.php/api/getCP?ville=' . urlencode($town));
            //response est un array de parametres dont CP ou "No result"
            $obj = json_decode($response);
            if ($obj != null && $obj != "No result") {
                $cp = $obj->{'CP'};
            }
        } catch (Exception $e) {
            Yii::log("Exception reçue la ville" . $town, CLogger::LEVEL_WARNING, "application");
            echo 'Exception reçue la ville: ' . $town, $e->getMessage(), "\n";
        }

        return $cp;
    }

}
