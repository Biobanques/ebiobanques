<?php

/**
 * class of Requests tools .
 * use to define different use cases for querying database
 * @author Matthieu PENICAUD
 * @since version 0.1
 */
class RequestTools
{

    public function getRequestCriteria($mode_request, $diagCriteria, $patCriteria, $prelCriteria, $echTCriteria, $echNTCriteria, $consCriteria) {
        $result = new EMongoCriteria;
        switch ($mode_request) {
            case '2':
                $echCriteria = new EMongoCriteria;
                $echCriteria->setConditions(array('$or' => array(array_merge($echTCriteria->getConditions(), array('Echant_tumoral' => "Oui")), array_merge($echNTCriteria->getConditions(), array('Echant_tumoral' => "Non")))));
//                $result->setConditions(array_merge($diagCriteria->getConditions(), $patCriteria->getConditions(), $prelCriteria->getConditions(), $consCriteria->getConditions(), $echCriteria->getConditions()));
                $and = array();
                if ($diagCriteria->getConditions() != array())
                    $and[] = $diagCriteria->getConditions();
                if ($patCriteria->getConditions() != array())
                    $and[] = $patCriteria->getConditions();
                if ($prelCriteria->getConditions() != array())
                    $and[] = $prelCriteria->getConditions();
                if ($consCriteria->getConditions() != array())
                    $and[] = $consCriteria->getConditions();
                if ($echCriteria->getConditions() != array())
                    $and[] = $echCriteria->getConditions();


                if ($and != array())
                    $result->setConditions(array('$and' => $and));

                break;

            case '1':
            default :
                $echCriteria = new EMongoCriteria;
                if (count($echTCriteria->getConditions()) > 0 && count($echNTCriteria->getConditions()) > 0)
                    $echCriteria->setConditions(array('$or' => array($echTCriteria->getConditions(), $echNTCriteria->getConditions())));
                else if (count($echTCriteria->getConditions()) > 0 && count($echNTCriteria->getConditions()) == 0)
                    $echCriteria = $echTCriteria;
                else if (count($echTCriteria->getConditions()) == 0 && count($echNTCriteria->getConditions()) > 0)
                    $echCriteria = $echNTCriteria;
                $and = array();
                if ($diagCriteria->getConditions() != array())
                    $and[] = $diagCriteria->getConditions();
                if ($patCriteria->getConditions() != array())
                    $and[] = $patCriteria->getConditions();
                if ($prelCriteria->getConditions() != array())
                    $and[] = $prelCriteria->getConditions();
                if ($consCriteria->getConditions() != array())
                    $and[] = $consCriteria->getConditions();
                if ($echCriteria->getConditions() != array())
                    $and[] = $echCriteria->getConditions();


                if ($and != array())
                    $result->setConditions(array('$and' => $and));

                break;
        }
        return $result;
    }

    public function getRequest($mode_request) {
        $result = array();

        $result['map'] = RequestTools::getMapRequest($mode_request);
        $result['reduce'] = RequestTools::getReduceRequest($mode_request);
        $result['finalize'] = RequestTools::getFinalizeRequest($mode_request);

        return $result;
    }

    public function getMapRequest($mode_request) {
        $result = new MongoCode("");
        switch ($mode_request) {
            case "2":
            case "1":
            default:
                $result = new MongoCode('function(){
          var pat ={};
          pat.patients=[];
          var patient = {};
          patient.id = this.ident_tum_biocap;

          patient.samples=[];
          patient.samples.push(this);
          pat.patients.push(patient);

           emit(
   {       RNCE_Lib3_GroupeICCC:this.RNCE_Lib3_GroupeICCC!=""?this.RNCE_Lib3_GroupeICCC:"Inconnu",
       RNCE_Lib3_SousGroupeICCC:this.RNCE_Lib3_SousGroupeICCC!=""?this.RNCE_Lib3_SousGroupeICCC:"Inconnu"
       },
     pat
     ) }');
                break;
        }
        return $result;
    }

    public function getReduceRequest($mode_request) {
        $result = new MongoCode("");
        switch ($mode_request) {
            case "2":
            case "1":
            default:
                $result = new MongoCode('function(key, vals){
          var result =  {};

          result.patients=[];

          for(var val in vals){
          pats = vals[val].patients;
          for(pat in pats){
          result.patients.push(pats[pat]);
          }}
          return result;
          }');
                break;
        }
        return $result;
    }

    public function getFinalizeRequest($mode_request) {
        $result = new MongoCode("");
        switch ($mode_request) {


            case "2":
                $result = new MongoCode("function(key,value){
            var partialResult = {};
            partialResult.patients={};
            var pats = value.patients;

        for(pat in pats){
        var idPat = pats[pat].id;
            var samps = pats[pat].samples;
             if(typeof partialResult.patients[idPat] == 'undefined'){
        partialResult.patients[idPat]=[];
             }
         for(samp in samps){

            partialResult.patients[idPat].push(samps[samp]);
            }
            }

            var partialResult2={};
            partialResult2.patients=[];
            for(partPat in partialResult.patients){
            var patient={};
            patient.id=partPat;
            patient.samples=partialResult.patients[partPat];
            patient.consentement=0;
            patient.inclusion=0;
            patient.hasTumo=false;
            patient.hasNonTumo=false;
            patient.hasUndefinedTumo=false;

  var listSamples=[];
            for(var sample in patient.samples){
if(patient.samples[sample].Echant_tumoral=='Non'){
                    patient.hasNonTumo=true;
                }
                                if(patient.samples[sample].Echant_tumoral=='Oui'){
                    patient.hasTumo=true;
                }
                                if(patient.samples[sample].Echant_tumoral=='Inconnu'){
                    patient.hasUndefinedTumo=true;
                }

                if(patient.samples[sample].Statut_juridique=='Refus'){
                    patient.consentement=2;
                }else if(patient.samples[sample].Statut_juridique=='Obtenu'&&patient.consentement!=2){
                patient.consentement=1;
                }
               if(patient.samples[sample].Inclusion_protoc_rech=='oui'){
                patient.inclusion=1;
                                }
                                listSamples.push(patient.samples[sample]._id);
                }
               
                 patient.samples=listSamples;
if(patient.hasTumo==true&&patient.hasNonTumo==true){
             partialResult2.patients.push(patient);
}
        }
            var result={};
            result.patientPartialTotal=partialResult2.patients.length;
            result.patients=partialResult2.patients;
            result.CR=0;
            result.IE=0;
            for(finalPats in partialResult2.patients){
               if(partialResult2.patients[finalPats].consentement==1){
                   result.CR++;
               }
                              if(partialResult2.patients[finalPats].inclusion==1){
                   result.IE++;
               }
            }
            return result;
        }");
                break;
            case "1":
            default:
                $result = new MongoCode("function(key,value){
            var partialResult = {};
            partialResult.patients={};
            var pats = value.patients;

        for(pat in pats){
        var idPat = pats[pat].id;
            var samps = pats[pat].samples;
             if(typeof partialResult.patients[idPat] == 'undefined'){
        partialResult.patients[idPat]=[];
             }
         for(samp in samps){

            partialResult.patients[idPat].push(samps[samp]);
            }
            }

            var partialResult2={};
            partialResult2.patients=[];
            for(partPat in partialResult.patients){
            var patient={};
            patient.id=partPat;
            patient.samples=partialResult.patients[partPat];
            patient.consentement=0;
            patient.inclusion=0;
  var listSamples=[];
            for(var sample in patient.samples){

                if(patient.samples[sample].Statut_juridique=='Refus'){
                    patient.consentement=2;
                }else if(patient.samples[sample].Statut_juridique=='Obtenu'&&patient.consentement!=2){
                patient.consentement=1;
                }
               if(patient.samples[sample].Inclusion_protoc_rech=='oui'){
                patient.inclusion=1;
                                }
                                listSamples.push(patient.samples[sample]._id);
                }
                patient.samples=listSamples;
             partialResult2.patients.push(patient);
        }
            var result={};
            result.patientPartialTotal=partialResult2.patients.length;
            result.patients=partialResult2.patients;
            result.CR=0;
            result.IE=0;
            for(finalPats in partialResult2.patients){
               if(partialResult2.patients[finalPats].consentement==1){
                   result.CR++;
               }
                              if(partialResult2.patients[finalPats].inclusion==1){
                   result.IE++;
               }
            }
            return result;
        }");
                break;
        }
        return $result;
    }

    /*
     * Default ccase : remove all empty group. Needed for case 2
     */

    public function filterResult($mode_request, $queryResult) {
        $result = array();

        switch ($mode_request) {

            case "2":

            case "1":
            default:
                $totalFound = 0;

                while ($queryResult['results']->hasNext()) {
                    $current = $queryResult['results']->getNext();
                    $toAdd = array();

                    if ($current['value']['patientPartialTotal'] != 0) {
                        $toAdd['_id'] = $current['_id'];
                        $toAdd['value'] = array();
                        $toAdd['value']['CR'] = $current['value']['CR'];
                        $toAdd['value']['IE'] = $current['value']['IE'];
                        $toAdd['value']['patientPartialTotal'] = $current['value']['patientPartialTotal'];
                        foreach ($current['value']['patients'] as $patient) {
                            $patAdded = array();
                            $patAdded['id'] = $patient['id'];

                            $patAdded['samples'] = $patient['samples'];
//                            $patAdded['samples'] = array();
//                            foreach ($patient['samples'] as $sample) {
//                                $patAdded['samples'][] = array('_id' => $sample['_id']);
//                            }
                            $toAdd['value']['patients'][] = $patAdded;
//                            $toAdd['value']['patients'][] = array('id' => $patient['id']);
                        }
                        $totalFound+=$current['value']['patientPartialTotal'];
                        $result['results'][] = $toAdd;
                    }
                }
                $result['total'] = $totalFound;
                break;
        }
        return $result;
    }

    public function getModesList() {
        $result = array();
        $result[1] = "Patients qui ont des échantillons tumoraux OU non tumoraux";
        $result[2] = "Patients qui ont des échantillons tumoraux ET non tumoraux";

        return $result;
    }

}