<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

echo "Welcome  $user->prenom  $user->nom on ebiobanques.fr.
Your account is waiting for a validation by the administrator of ebiobanques.<br>
If you have any problem during your experience with ebiobanques.fr feel free to send an email to " . Yii::app()->params['managerEmail'] . "<br>
                            Best regards";
