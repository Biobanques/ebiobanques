db.getCollection('biobank').aggregate([
{  $group:
    { '_id':"$_id",
       
        'responsables':{'$push':{'name':'$responsable_op.lastName',
        'fullName':
            {'$concat':[{'$toUpper':'$responsable_op.lastName'}," ","$responsable_op.firstName"]}}
        },
 'responsables1':{'$push':{'name':'$responsable_adj.lastName',
        'fullName':
            {'$concat':[{'$toUpper':'$responsable_adj.lastName'}," ","$responsable_adj.firstName"]}}
        },'responsables2':{'$push':{'name':'$responsable_qual.lastName',
        'fullName':
            {'$concat':[{'$toUpper':'$responsable_qual.lastName'}," ","$responsable_qual.firstName"]}}
        },
    
  
    }
        }
         ,{'$match':{$or:[
             {'responsables':{$nin:[[],'',null]}},
         {'responsables1':{$nin:[[],'',null]}},
         {'responsables2':{$nin:[[],'',null]}}
         ]}}

        ,{ 
            "$project": {
                "name": "$_id",    
               
                "resps": { "$setUnion": [ "$responsables","$responsables1","$responsables2",] }, 
                "_id": 0,
             
            }
        },{'$unwind':"$resps"},{'$group':{'_id':"$resps"}},
         {$match:{'_id':{$nin:[null,""," "]}}}

])