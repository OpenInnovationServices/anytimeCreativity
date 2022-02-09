const router = require('express').Router();
const keys = require('../config/keys');
const MongoClient = require('mongodb').MongoClient;
const lookSideways = require('../models/lookSideWaysModel');
var mongodb = require('mongodb');
const fs = require('fs');
var multer = require('multer')
var upload = multer({ dest: 'appUploads/' })

router.get('/', (req, res) => {
    res.render('look-sideways/index', {
        pageTitle: 'Look Sideways',
    });
});

//create home route
router.get('/dashboard', (req, res) => {
    MongoClient.connect(keys.mongodb.dbURI, { useNewUrlParser: true, useUnifiedTopology: true }, function (err, db) {
        if (err) throw err;
        var dbo = db.db(keys.mongodb.dbName);
        dbo.collection("lookSidewaysSolutions").find({}).toArray(function (err, result) {
            if (err) res.status(400).json("Error Connecting DB");
            //console.log(result);
            res.render('look-sideways/dashboard', {
                pageTitle: 'Look Sideways Dashboard',
                data: result
            });
            db.close();
        });
    });

});

router.post('/', upload.single('appFile'), (req, res) => {
    // console.log(req.body);
    // if (typeof(req.file) !== "undefined"){
    //     var img = fs.readFileSync(req.file.path);
    //     var encode_image = img.toString('base64');
    //     var finalImg = {
    //         contentType: req.file.mimetype,
    //         data: Buffer.from(encode_image, 'base64')
    //     }
    // }else{
    //     var finalImg = { }
    // }
    const lookSidewaysObj = new lookSideways({
        // appFile: finalImg,
        team: req.body.team,
        playerNames: req.body.playerNames,
        ideaName: req.body.ideaName,
        idea: req.body.idea,
        count: 0
    });
    MongoClient.connect(keys.mongodb.dbURI, { useNewUrlParser: true, useUnifiedTopology: true }, function (err, db) {
        if (err) throw err;
        var dbo = db.db(keys.mongodb.dbName);
        dbo.collection("lookSidewaysSolutions").insertOne(lookSidewaysObj, function (err, result) {
            if (err) res.status(400).json("Error Connecting DB");
            res.status(201).redirect('back');
            db.close();
        });
    });
});

router.get('/img/:imgId', (req, res) => {
    MongoClient.connect(keys.mongodb.dbURI, { useNewUrlParser: true, useUnifiedTopology: true }, function (err, db) {
        if (err) throw err;
        var dbo = db.db(keys.mongodb.dbName);
        var myquery = { _id: new mongodb.ObjectID(req.params.imgId) };
        dbo.collection("lookSidewaysSolutions").findOne(myquery, function (err, result) {
            if (err) throw err;
            db.close();
            res.contentType('image/jpg');
            res.send(result.appFile.data.buffer);
           
            
        });
    });
})

router.post('/delete', (req, res) => {
    MongoClient.connect(keys.mongodb.dbURI, { useNewUrlParser: true, useUnifiedTopology: true }, function (err, db) {
        if (err) throw err;
        var dbo = db.db(keys.mongodb.dbName);
        dbo.collection('lookSidewaysSolutions', {}, function (err, solution) {
            solution.deleteMany({}, function (err, result) {
                if (err) {
                    console.log(err);
                }
                res.status(200).redirect('back');
                db.close();
            });
        });
    });
});

router.post('/delete/id', (req, res) => {
    MongoClient.connect(keys.mongodb.dbURI, { useNewUrlParser: true, useUnifiedTopology: true }, function (err, db) {
        if (err) throw err;
        var dbo = db.db(keys.mongodb.dbName);
        var myquery = { _id: new mongodb.ObjectID(req.body.id) };
        dbo.collection("lookSidewaysSolutions").deleteOne(myquery, function (err, obj) {
            if (err) throw err;
            console.log("1 document deleted");
            res.status(200).redirect('/lookSideways/dashboard');
            db.close();
        });
    });
});

router.get('/vote', (req, res) => {
    MongoClient.connect(keys.mongodb.dbURI, { useUnifiedTopology: true, useNewUrlParser: true }, function (err, db) {
        if (err) throw err;
        var dbo = db.db(keys.mongodb.dbName);
        dbo.collection("lookSidewaysSolutions").find({}).toArray(function (err, result) {
            if (err) res.status(400).json("Error Connecting DB");
            res.render('look-sideways/vote', {
                pageTitle: 'Look Sideways Vote',
                data: result,
            });
            db.close();
        });
    });
});

router.post('/vote', (req, res) => {

    console.log(req.body);
    MongoClient.connect(keys.mongodb.dbURI, { useNewUrlParser: true, useUnifiedTopology: true }, function (err, db) {
        if (err) throw err;
        for (let i = 0; i < Object.keys(req.body).length; i++) {
            console.log(Object.keys(req.body)[i])
            var dbo = db.db(keys.mongodb.dbName);
            var myquery = { _id: new mongodb.ObjectID(Object.keys(req.body)[i]) };
            dbo.collection("lookSidewaysSolutions").find(myquery).toArray(function (err, result) {
                if (err) res.status(400).json("Error Connecting DB");
                if (isNaN(result[0].count)) {
                    result[0].count = 0;
                    result[0].count = result[0].count + 1;
                } else {
                    result[0].count = result[0].count + 1;
                }
                console.log(result[0]);
                var myquery = { _id: new mongodb.ObjectID(result[0]._id) };
                dbo.collection("lookSidewaysSolutions").updateOne(myquery, { $set: result[0] }, function (err, res) {
                    if (err) throw err;
                    console.log("1 document updated");
                    
                });
            });
        }
        
    });
    res.status(201).redirect('back');
})

router.get('/vote/dashboard', (req, res) => {
    MongoClient.connect(keys.mongodb.dbURI, { useUnifiedTopology: true, useNewUrlParser: true }, function (err, db) {
        if (err) throw err;
        var dbo = db.db(keys.mongodb.dbName);
        dbo.collection("lookSidewaysSolutions").find({}).toArray(function (err, result) {
            if (err) res.status(400).json("Error Connecting DB");
            res.render('look-sideways/voting-dashboard', {
                pageTitle: 'Look Sideways Voting Dashboard',
                data: result
            });
            db.close();
        });
    });
});


module.exports = router;