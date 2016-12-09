<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

$fname = $user->prenom;
$lname = $user->nom;
$login = $user->login;
$password = $user->password;
echo "Cher (Chère) $fname $lname,<br><br>
		Suite à votre demande effectuée sur le site ebiobanques.fr, nous vous rappelons vos codes d'accès :<br>
                Identifiant : $login<br>
                Password : $password <br>
                Vous pouvez dès à présent vous connecter avec ces identifiants.
A bientôt sur ebiobanques.fr";
