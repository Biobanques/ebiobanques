<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

echo "$user->prenom $user->nom s'est inscrit sur le site ebiobanques.fr.<br>

	Vous pouvez valider cet utilisateur en cliquant sur ce lien :<br>" . CHtml::link('Valider l\'utilisateur', Yii::app()->createAbsoluteUrl('user/validate', array('id' => $user->_id))) . "<br>ou le retrouver dans la " . CHtml::link('Liste des utilisateurs', Yii::app()->createAbsoluteUrl('user/admin'));
