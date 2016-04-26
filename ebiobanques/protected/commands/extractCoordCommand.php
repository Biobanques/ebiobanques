






<?php

/**
 * Command to mass extract biobanks adress and get lat/long from google API
 */
class extractCoordCommand extends CConsoleCommand
{

    public function run() {
        echo 'Extract coordinates from biobank address :' . "\n";

        $biobanks = Biobank::model()->findAll();
        foreach ($biobanks as $biobank) {

            CommonTools::getLatLong($biobank);

//            if (isset($biobank->address->street) && isset($biobank->address->city) && isset($biobank->address->zip) && isset($biobank->address->country)) {
//                //  print_r($biobank->address->attributes);
//                $requestAddress = str_ireplace(' ', '+', $biobank->address->street) . '+' . $biobank->address->zip . '+' . str_ireplace(' ', '+', $biobank->address->city) . '+' . $biobank->address->country;
//// $requestAddress = iconv('UTF-8', 'ASCII//TRANSLIT', $requestAddress);
//                $requestAddress = $this->url($requestAddress);
//                //  echo "formated address : $requestAddress";
//                $completeAddress = 'https://maps.googleapis.com/maps/api/geocode/json?address=' . $requestAddress;
//                $request = new EHttpClient($completeAddress);
////            $modifier = new EMongoModifier();
////            $modifier->addModifier('biobank_id', 'set', (string) $biobank->_id);
////            $criteria = new EMongoCriteria();
////            $criteria->biobank_id = $biobank->id;
////            $status = Sample::model()->updateAll($modifier, $criteria);
////            $criteriaAfter = new EMongoCriteria();
////            $criteriaAfter->biobank_id = (string) $biobank->_id;
////
////            $count = Sample::model()->count($criteriaAfter);
//                $response = $request->request('GET');
//                $var = json_decode($response->getBody());
//                $response = $request->request('GET');
//                $var = json_decode($response->getBody());
//                if ($var->status != "ZERO_RESULTS") {
//                    echo "formated address : $requestAddress";
//                    print_r($var->results[0]->geometry->location);
//                    $biobank->latitude = $var->results[0]->geometry->location->lat;
//                    $biobank->longitude = $var->results[0]->geometry->location->lng;
//                    $biobank->initSoftAttribute('location');
//                    $biobank->location = array('type' => 'Point', 'coordinates' => array($biobank->longitude, $biobank->latitude));
//                    $biobank->save();
//                }
//
//
////            print_r($var->results[0]);
//                //echo $completeAddress;
//                // if (!isset($var->results[0]))
////                    print_r($var->results[0]->geometry->location);
////                else
////                    print_r($var->results);
//                //  print_r($response->getBody());
//            } else {
//                echo "$biobank->name \n";
//                print_r($biobank->address);
//            }
        }
    }

}