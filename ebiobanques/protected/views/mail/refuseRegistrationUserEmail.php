<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

echo "Cher (Chère) $user->prenom $user->nom,<br><br>
		Merci de vous être intéressé à la plate-forme <a href=\"http://www.ebiobanques.fr/index.php\">ebiobanques.fr</a>.<br>
		Malheureusement, nous ne pouvons donner suite à votre inscription.<br>
                Pour toute question, merci de contacter l'administrateur de la plate-forme.<br>" . Yii::app()->params['managerEmail'] . "<br>
                Cordialement<br>
                L'équipe ebiobanques";
