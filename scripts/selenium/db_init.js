//Remove datas from previous tests
db.biobank.remove({_id:{$in:["000"]}});
db.user.remove({_id: {$in: ["001", "002", "003", "004", "005", "006"]}});
db.Demande.remove({_id: {$in: ["001"]}});

//Init datas for selenium tests
db.biobank.insert([{
        "_id": "000", 
        "id": "000", 
        "identifier": "Test BioBank",
        "name": "Biobank for Test",
        "collection_name": "Test collection",
        "collection_id": "", 
        "date_entry": "",
        "folder_reception": "/folder/reception/",
        "folder_done": "/folder/inclusion/",
        "passphrase": "Test",
        "contact_id": ""}
]);

db.user.insert([
    {"_id": "001", "id": "1", "nom": "SimpleUser", "prenom": "SimpleUser", "login": "user", "password": "user", "email": "matthieu.penicaud@inserm.fr", "telephone": "", "gsm": "", "profil": "0", "inactif": "0"},
    {"_id": "002", "id": "2", "nom": "SystemAdmin", "prenom": "SystemAdmin", "login": "admin", "password": "admin", "email": "matthieu.penicaud@inserm.fr", "telephone": "", "gsm": "", "profil": "1", "inactif": "0"},
    {"_id": "003", "id": "3", "nom": "BiobankAdmin", "prenom": "BiobankAdmin", "login": "bbadmin", "password": "bbadmin", "email": "matthieu.penicaud@inserm.fr", "telephone": "", "gsm": "", "profil": "0", "inactif": "0", "biobank_id": "000"},
    {"_id": "004", "id": "4", "nom": "InactiveUser", "prenom": "InactiveUser", "login": "inuser", "password": "inuser", "email": "matthieu.penicaud@inserm.fr", "telephone": "", "gsm": "", "profil": "0", "inactif": "1"},
    {"_id": "005", "id": "5", "nom": "InactiveSysAdmin", "prenom": "InactiveSysAdmin", "login": "inadmin", "password": "inadmin", "email": "matthieu.penicaud@inserm.fr", "telephone": "", "gsm": "", "profil": "1", "inactif": "1"},
    {"_id": "006", "id": "6", "nom": "InactiveBioAdmin", "prenom": "InactiveBioAdmin", "login": "inbbadmin", "password": "inbbadmin", "email": "matthieu.penicaud@inserm.fr", "telephone": "", "gsm": "", "profil": "0", "inactif": "1", "biobank_id": "000"}
]);
db.Demande.insert([
    {"_id": "001", "id_user": "1", "date_demande": "2014-01-22 15:38:36", "detail": null, "titre": null, "envoi": 0, "sampleList": []},
]);

