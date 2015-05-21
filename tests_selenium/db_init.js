//Add datas for selenium tests
db.biobank.insert([{
        "_id":ObjectId("bb0000000000000000000001"),
        "id": "000", 
        "identifier": "Test BioBank",
        "name": "0000_AAA_Biobank for Test",
        "collection_name": "Test collection",
        "collection_id": "", 
        "date_entry": "",
        "folder_reception": "/folder/reception/",
        "folder_done": "/folder/inclusion/",
        "passphrase": "Test",
        "contact_id": "cc0000000000000000000001",
        "ville":"TestVille"}
]);

db.user.insert([
    {"_id":ObjectId("aa0000000000000000000001"),"id": "1", "nom": "AAASimpleUser", "prenom": "SimpleUser", "login": "user", "password": "user", "email": "matthieu.penicaud@inserm.fr", "telephone": "", "gsm": "", "profil": "0", "inactif": "0"},
    {"id": "2", "nom": "AAASystemAdmin", "prenom": "SystemAdmin", "login": "admin", "password": "admin", "email": "matthieu.penicaud@inserm.fr", "telephone": "", "gsm": "", "profil": "1", "inactif": "0"},
    {"id": "3", "nom": "AAABiobankAdmin", "prenom": "BiobankAdmin", "login": "bbadmin", "password": "bbadmin", "email": "matthieu.penicaud@inserm.fr", "telephone": "", "gsm": "", "profil": "0", "inactif": "0", "biobank_id": "000"},
    {"id": "4", "nom": "AAAInactiveUser", "prenom": "InactiveUser", "login": "inuser", "password": "inuser", "email": "matthieu.penicaud@inserm.fr", "telephone": "", "gsm": "", "profil": "0", "inactif": "1"},
    {"id": "5", "nom": "AAAInactiveSysAdmin", "prenom": "InactiveSysAdmin", "login": "inadmin", "password": "inadmin", "email": "matthieu.penicaud@inserm.fr", "telephone": "", "gsm": "", "profil": "1", "inactif": "1"},
    {"id": "6", "nom": "AAAInactiveBioAdmin", "prenom": "InactiveBioAdmin", "login": "inbbadmin", "password": "inbbadmin", "email": "matthieu.penicaud@inserm.fr", "telephone": "", "gsm": "", "profil": "0", "inactif": "1", "biobank_id": "000"}
]);

db.contact.insert([
    {
"_id":ObjectId("cc0000000000000000000001"),
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
]);
db.echantillon.insert([{
        "biobank_id":"bb0000000000000000000001",    
    "_id" : ObjectId("ec0000000000000000000001"),
    "collect_date" : "2007-10-09 00:00:00.0",
    "consent" : "Y",
    "consent_ethical" : "Y",
    "disease_diagnosis" : "mÃ©tastase pulmonaire",
    "gender" : "F",
    "id" : "14993",
    "id_depositor" : "LB07-0567",
    "id_donor" : "1496811",
    "id_sample" : "LB07-0567",
    "nature_sample_cells" : "T",
    "nature_sample_dna" : "A",
    "nature_sample_tissue" : "T",
    "notes" : [],
    "origin" : "thorax",
    "patient_birth_date" : "1955-02-16",
    "processing_method" : "Freezing preservation",
    "quantity" : "0",
    "related_biological_material" : "tissue",
    "status_sample" : "A",
    "storage_conditions" : "80",
    "supply" : "Type de tissu congelÃ©"

}]);
db.Demande.insert([
    {
        
    "_id" : ObjectId("dde000000000000000000001"),
    "id_user" : "aa0000000000000000000001",
    "date_demande" : "2015-01-01 00:00:00",
    "detail" : "",
    "titre" : "",
    "envoi" : NumberLong(0),
    "sampleList" : [ 
        {
            "id_sample" : "ec0000000000000000000001",
            "quantity" : null
        }
    ]
}
    ])

