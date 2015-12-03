<?php

/**
 * classe de statistiques utiles.
 */
class BiobankCompletionTools
{

    /**
     * Get array of all fields in biobank collection
     * @return Array
     */
    public function getAllFieldsArray() {
        $result = array();
        $db = Biobank::model()->getDb();
        // $biobankCollection = Biobank::model()->getCollection();
        $mr = $db->command(array(
            "mapreduce" => "biobank",
            //   "query" => array('id' => '11'),
            "map" => "function() {
    for (var key in this) { emit(key,null); }
  }",
            "reduce" => "function(key, stuff) { return key; }",
            "out" => Array("inline" => TRUE)
        ));
        foreach ($mr['results'] as $mrResult) {
            $result[] = $mrResult['_id'];
        }


        return $result;
    }

    public function getBiobankCompletudeRate($id_biobank, $fields = null) {
        $result = array();
        $result['fieldsPresent'] = array();
        $result['fieldsPresent']['fields'] = array();
        $result['fieldsMissing'] = array();
        $result['fieldsMissing'] ['fields'] = array();
        //    $biobank = Biobank::model()->findByAttributes(array('id' => $id_biobank));
        $biobank = Biobank::model()->findByPk($id_biobank);
        if ($fields == null)
            $fields = BiobankCompletionTools::getAllFieldsArray();
        foreach ($fields as $field) {
            if (isset($biobank->$field) && $biobank->$field != null && $biobank->$field != 'null' && $biobank->$field != '') {
                $result['fieldsPresent']['fields'][] = $field;
            } else {
                $result['fieldsMissing']['fields'][] = $field;
            }
        }
        $result['fieldsPresent']['total'] = count($result['fieldsPresent']['fields']);
        $result['fieldsMissing']['total'] = count($result['fieldsMissing']['fields']);
        $nbFields = count($fields);
        $result['fieldsMissing']['totalRate'] = $result['fieldsMissing']['total'] / $nbFields;

        $result['fieldsPresent']['totalRate'] = $result['fieldsPresent']['total'] / $nbFields;
        return $result;
    }

    public function getBiobankAttributesGlobalCompletudeRate() {
        $result = array();
        $db = Biobank::model()->getDb();
        // $biobankCollection = Biobank::model()->getCollection();
        $mr = $db->command(array(
            "mapreduce" => "biobank",
            "map" => "function() {
                var result={};

    for(var key in this) {result.ids=[];

    if(this[key]!=null&&this[key]!='null'&&this[key]!=''&&this[key]!='/'){
var emitObj = {};
+
result.ids.push( this._id.toString());
}
    emit(key,result);
    }
  }",
            "reduce" => "function(key, ids) { "
            . "var result = {};"
            . "result.ids=[];"
            . "for (var i=0;i<ids.length;i++ ){"
            . "var id = ids[i].ids[0];"
            . "if(id!=null){"
            . "result.ids.push(id);"
            . "}"
            . "}"
            . "return result; "
            . "}",
            "finalize" => "function(key,value){"
            . "return value;"
            . "}",
            "out" => Array("inline" => TRUE),
//            "out" => 'testStats',
        ));
        $totalGCR = 0;
        foreach ($mr['results'] as $mrResult) {
            $mrResult['value']['GCR'] = count($mrResult['value']['ids']) / $mr['counts']['input'];
            $mrResult['value']['nbIds'] = count($mrResult['value']['ids']);

            $result[$mrResult['_id']] = $mrResult['value'];
            $totalGCR += $mrResult['value']['GCR'];
        }
        $result['avgGCR'] = $totalGCR / $mr['counts']['output'];
        $result['nbBiobanks'] = $mr['counts']['input'];
        $result['nbFields'] = $mr['counts']['output'];

        return $result;
    }

}