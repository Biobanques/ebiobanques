<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

echo "Cher (Chère) $user->prenom $user->nom,<br><br>
		Merci de vous être inscrit sur le site <a href=\"http://www.ebiobanques.fr/index.php\">ebiobanques.fr</a>.<br>
		Vous pouvez vous connecter dès à présent sur le site avec vos identifiants : <br>
		<ul><li>Nom d'utilisateur : $user->login </li>
		<li>Mot de passe : $user->password </li></ul>";
