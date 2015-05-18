//Add datas for selenium tests
db.biobank.insert([{
        "id": "000", 
        "identifier": "Test BioBank",
        "name": "0000_AAA_Biobank for Test",
        "collection_name": "Test collection",
        "collection_id": "", 
        "date_entry": "",
        "folder_reception": "/folder/reception/",
        "folder_done": "/folder/inclusion/",
        "passphrase": "Test",
        "contact_id": "",
        "ville":"TestVille"}
]);

db.user.insert([
    {"id": "1", "nom": "AAASimpleUser", "prenom": "SimpleUser", "login": "user", "password": "user", "email": "matthieu.penicaud@inserm.fr", "telephone": "", "gsm": "", "profil": "0", "inactif": "0"},
    {"id": "2", "nom": "AAASystemAdmin", "prenom": "SystemAdmin", "login": "admin", "password": "admin", "email": "matthieu.penicaud@inserm.fr", "telephone": "", "gsm": "", "profil": "1", "inactif": "0"},
    {"id": "3", "nom": "AAABiobankAdmin", "prenom": "BiobankAdmin", "login": "bbadmin", "password": "bbadmin", "email": "matthieu.penicaud@inserm.fr", "telephone": "", "gsm": "", "profil": "0", "inactif": "0", "biobank_id": "000"},
    {"id": "4", "nom": "AAAInactiveUser", "prenom": "InactiveUser", "login": "inuser", "password": "inuser", "email": "matthieu.penicaud@inserm.fr", "telephone": "", "gsm": "", "profil": "0", "inactif": "1"},
    {"id": "5", "nom": "AAAInactiveSysAdmin", "prenom": "InactiveSysAdmin", "login": "inadmin", "password": "inadmin", "email": "matthieu.penicaud@inserm.fr", "telephone": "", "gsm": "", "profil": "1", "inactif": "1"},
    {"id": "6", "nom": "AAAInactiveBioAdmin", "prenom": "InactiveBioAdmin", "login": "inbbadmin", "password": "inbbadmin", "email": "matthieu.penicaud@inserm.fr", "telephone": "", "gsm": "", "profil": "0", "inactif": "1", "biobank_id": "000"}
]);
db.Demande.insert([
    {"id_user": "1", "date_demande": "2014-01-22 15:38:36", "detail": null, "titre": null, "envoi": 0, "sampleList": []},
]);
db.contact.insert([
    {

    "id" : "001",
    "first_name" : "AAAContactTest",
    "last_name" : "AAACONTACTTEST",
    "email" : "AAAContactTest@ebiobanques.fr",
    "phone" : "0102030405",
    "adresse" : "Hôpital",
    "ville" : "Capitale",
    "pays" : "FR",
    "code_postal" : "99999",
    "inactive" : "0",

}
])

