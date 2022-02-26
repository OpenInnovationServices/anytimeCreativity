const router = require('express').Router();
const keys = require('../config/keys');
const MongoClient = require('mongodb').MongoClient;
const challengeModel = require('../models/dynamicChallengesDataModel');
var mongodb = require('mongodb');


router.get('/', (req, res) => {
    res.status(200).send("Dead End!!");
    // MongoClient.connect(keys.mongodb.dbURI, { useUnifiedTopology: true, useNewUrlParser: true }, function(err, db) {
    //     if (err) throw err;
    //     var dbo = db.db(keys.mongodb.dbName);
    //     dbo.collection("dynamicChallengeDataCollection").find({}).toArray(function(err, result) {
    //         if (err) res.status(400).json("Error Connecting DB");
    //         res.status(200).json(result);
    //         db.close();
    //     });
    // });
});


//create home route
// router.get('/view',(req,res)=>{
//     MongoClient.connect(keys.mongodb.dbURI,{useNewUrlParser:true}, function(err, db) {
//         if (err) throw err;
//         var dbo = db.db("PROD");
//         dbo.collection("dynamicChallengeDataCollection").find({}).toArray(function(err, result) {
//           if (err) res.status(400).json("Error Connecting DB");
//           //console.log(result);
//           res.status(200).render('pages/cc-view.ejs',{data:result,length:result.length});
//           db.close();
//         });
//     }); 
// });

router.post('/', (req, res) => {
    console.log(req.body);
    const idea = new challengeModel({
        mix: req.body.mix,
        match: req.body.match,
        mix_text: req.body.mix_text,
        match_text: req.body.match_text,
        idea: req.body.idea,
        penName: req.body.penName,
        teamName: req.body.teamName,
        ideaName: req.body.ideaName,
        gameId: req.body.gameId,
        gameCode: req.body.gameCode,
        code: req.body.code,
        count: 0
    });
    console.log(idea);
    // console.log('-------------------------');
    // return false;

    MongoClient.connect(keys.mongodb.dbURI, { useNewUrlParser: true }, function(err, db) {
        if (err) throw err;
        var dbo = db.db(keys.mongodb.dbName);
        dbo.collection("dynamicChallengeDataCollection").insertOne(idea, function(err, result) {
            if (err) res.status(400).json("Error Connecting DB");
            res.status(201).redirect('/api/dynamicChallenge');
            db.close();
        });
    });
})

router.post('/delete', (req, res) => {
    MongoClient.connect(keys.mongodb.dbURI, { useNewUrlParser: true }, function(err, db) {
        if (err) throw err;
        var dbo = db.db(keys.mongodb.dbName);
        dbo.collection('dynamicChallengeDataCollection', {}, function(err, solution) {
            solution.deleteMany({}, function(err, result) {
                if (err) {
                    console.log(err);
                }
                res.status(200).redirect('/challenge');
                db.close();
            });
        });
    });
});

router.post('/delete/id', (req, res) => {
    MongoClient.connect(keys.mongodb.dbURI, { useNewUrlParser: true }, function(err, db) {
        if (err) throw err;
        var dbo = db.db(keys.mongodb.dbName);
        var myquery = { _id: new mongodb.ObjectID(req.body.id) };
        dbo.collection("dynamicChallengeDataCollection").deleteOne(myquery, function(err, obj) {
            if (err) throw err;
            console.log("1 document deleted");
            res.status(200).redirect('back');
            db.close();
        });
    });
});

router.get('/:code', (req, res) => {
    //res.status(200).render('pages/index.ejs');
    console.log(req.params.code);
    MongoClient.connect(keys.mongodb.dbURI, { useUnifiedTopology: true, useNewUrlParser: true }, function(err, db) {
        if (err) throw err;
        var dbo = db.db(keys.mongodb.dbName);
        dbo.collection("dynamicChallengeDataCollection").find({ "code": req.params.code }).toArray(function(err, result) {
            if (err) res.status(400).json("Error Connecting DB");
            res.status(200).json(result);
            db.close();
        });
    });

});

router.post('/vote', (req, res) => {

    console.log(req.body);
    MongoClient.connect(keys.mongodb.dbURI, { useNewUrlParser: true }, function(err, db) {
        if (err) throw err;
        for (let i = 0; i < Object.keys(req.body).length; i++) {
            console.log(Object.keys(req.body)[i])
            var dbo = db.db(keys.mongodb.dbName);
            var myquery = { _id: new mongodb.ObjectID(Object.keys(req.body)[i]) };
            dbo.collection("dynamicChallengeDataCollection").find(myquery).toArray(function(err, result) {
                if (err) res.status(400).json("Error Connecting DB");
                if (isNaN(result[0].count)) {
                    result[0].count = 0;
                    result[0].count = result[0].count + 1;
                } else {
                    result[0].count = result[0].count + 1;
                }
                console.log(result[0]);
                var myquery = { _id: new mongodb.ObjectID(result[0]._id) };
                dbo.collection("dynamicChallengeDataCollection").updateOne(myquery, { $set: result[0] }, function(err, res) {
                    if (err) throw err;
                    console.log("1 document updated");
                    db.close();
                });
            });
        }
    });
    res.status(201).redirect('back');
})

module.exports = router;