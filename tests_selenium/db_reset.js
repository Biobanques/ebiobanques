//Remove datas from previous tests
db.biobank.remove({_id:{$in:["000"]}});
db.user.remove({_id: {$in: ["001", "002", "003", "004", "005", "006"]}});
db.Demande.remove({_id: {$in: ["001"]}});