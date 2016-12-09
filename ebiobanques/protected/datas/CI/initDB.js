/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


db = db.getSiblingDB('interop');
db.createUser({user:'circleUser',pwd:'circlePwd',roles:['readWrite']})


