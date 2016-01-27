/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * To execute this file within mongo, please refer to mongodb documentation
 */

db = db.getSiblingDB('interop');
var listBadValues = [0,NumberLong(0),null,""]
for (var badValue in listBadValues){
    print('repair datas for value : ' +listBadValues[badValue]);
    db.user.update({'profil':listBadValues[badValue]},{'$set':{'profil':'0'}},{'multi':true});
}
db.user.update({'profil':1},{'$set':{'profil':'1'}},{'multi':true});
db.user.update({'profil':2},{'$set':{'profil':'2'}},{'multi':true});
