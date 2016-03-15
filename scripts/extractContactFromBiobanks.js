var result = db.getCollection("biobank").aggregate([
{"$match":{"responsable_qual.civility":{"$ne":null}}}, 
{"$project":{
    _id:1,
    "adresse":"$address.street",
    "city":"$address.city",
    "zip":"$address.zip",
     "country":"$address.country",
   "responsable_op":1,
   "responsable_qual":1,
   "responsable_adj":1,
    "type": { "$literal": ["responsable_op","responsable_qual","responsable_adj"] },
    
    }},
       { "$unwind": "$type" },
      { "$group": {
        "_id": "$_id",
          "city":{ "$first": "$city" },
           "country":{ "$first": "$country" },
            "zip":{ "$first": "$zip" },
             "adresse":{ "$first": "$adresse" },

        "responsable_op": { "$first": "$responsable_op" },
        "responsable_adj": { "$first": "$responsable_adj" },
        "responsable_qual": { "$first": "$responsable_qual" },
        "responsables": {
                        "$push": {
                "$cond": [
                    { "$eq": [ "$type", "responsable_op" ] },
                    "$responsable_op",
                    {"$cond": [
                    { "$eq": [ "$type", "responsable_qual" ] },
                    "$responsable_qual",
                                       {"$cond": [
                    { "$eq": [ "$type", "responsable_adj" ] },
                    "$responsable_adj",
                    false
                ]}
                ]}
                ]
            }
        }
    }},
    {"$project":{
    _id:1,
        
            "adresse":1,
     "zip":1,
                    "city":1,
     "country":1,
   "responsables":1}},
      { "$unwind": "$responsables" },
     {"$project":{
    "biobank_id":"$_id",
         
            "adresse":1,
     "zip":1,
                    "city":1,
     "country":1,
         //"responsables":1,
   "civility":"$responsables.civility",
            "firstName":"$responsables.firstName",
            "lastName":"$responsables.lastName",
          "email":"$responsables.email",
          "direct_phone":"$responsables.direct_phone",
         
         }},
 ]);
printjson(result);
         