<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class ExtractContactCommand extends CConsoleCommand
{

    public function run($args) {
        //include_once dirname(dirname(dirname(__FILE__))) . DIRECTORY_SEPARATOR . 'CommonTools.php';
        $biobankList = Biobank::model()->findAll();
        foreach ($biobankList as $biobank) {
            if (isset($biobank->contact_id)) {
               $contact = Contact::model()->findByPk(new MongoId($biobank->contact_id));
               if (isset($contact)){
                   $biobank->contact_resp->first_name = $contact->first_name;
                   $biobank->contact_resp->last_name = $contact->last_name;
                   $biobank->contact_resp->email= $contact->email;
                   $biobank->contact_resp->phone= $contact->phone;

               // unset($biobank->contact_id);
                   
                   
                   }
                $biobank->save();
               }
              
            }
            
            

           // $biobank->save(false);
        }
    }

