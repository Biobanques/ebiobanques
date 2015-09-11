db.createCollection("user");
db.user.insert({
    "prenom" : "Camille",
    "nom" : "BOIN",
    "login" : "admin",
    "password" : "adm_BCApp",
    "email" : "camille.boin@inserm.fr",
    "telephone" : "01 45 59 50 45",
    "gsm" : null,
    "profil" : "1",
    "inactif" : "0",
    "biobank_id" : null,
    "verifyCode" : null
});


// Pour démo seulement
db.user.insert({
    "prenom" : "user",
    "nom" : "Test",
    "login" : "user",
    "password" : "user",
    "email" : "test@monmail.com",
    "telephone" : "01 02 03 04 05",
    "gsm" : null,
    "profil" : "0",
    "inactif" : "0",
    "biobank_id" : null,
    "verifyCode" : null
});/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


