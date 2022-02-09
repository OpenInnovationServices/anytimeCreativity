const router = require('express').Router();
const keys = require('../config/keys');
const MongoClient = require('mongodb').MongoClient;
const madAndNutty = require('../models/madAndNuttyModel');
var mongodb = require('mongodb');
const fs = require('fs');
var multer = require('multer')
var upload = multer({ dest: 'appUploads/' })

var multer = require("multer");
var storage = multer.diskStorage({
    destination: function(req, file, callback){
        callback(null, './public/assets/uploads'); // set the destination
    },
    filename: function(req, file, callback){
        callback(null, Date.now() + '.png'); // set the file name and extension
    }
});
var upload = multer({storage: storage});
router.post('/add', upload.single('imagename'), function(req, res, next) {
    var image = req.file.filename;
    console.log('req.file.path');
    res.status(201).redirect('back');
   /** rest */ 
});

router.get('/', (req, res) => {
    res.render('mad-and-nutty/index', {
        pageTitle: 'Mad And Nutty',
    });
});

// router.get('/set', (req, res) => {
//     res.status(200).render('pages/reImagineSettings.ejs');
// });

//create home route
router.get('/dashboard', (req, res) => {
    MongoClient.connect(keys.mongodb.dbURI, { useNewUrlParser: true, useUnifiedTopology: true }, function (err, db) {
        if (err) throw err;
        var dbo = db.db(keys.mongodb.dbName);
        dbo.collection("madAndNuttySolutions").find({}).toArray(function (err, result) {
            if (err) res.status(400).json("Error Connecting DB");
            console.log(result);
            res.render('mad-and-nutty/dashboard', {
                pageTitle: 'Mad And Nutty Dashboard',
                data: result,
            });
            db.close();
        });
    });

});

router.post('/', upload.single('appFile'), (req, res) => {
    if(req.file != null){
        var imagePath = "/assets/uploads/"+req.file.filename;
    }
    
    const madAndNuttyObj = new madAndNutty({
        object1: req.body.object1,
        object2: req.body.object2,
        object3: req.body.object3,
        object4: req.body.object4,
        image: imagePath,
        teamName: req.body.teamName,
        playerNames: req.body.playerNames,
        ideaName: req.body.ideaName,
        ideaDescription: req.body.ideaDescription,
        count: 0
    });
    console.log(madAndNuttyObj);
    // res.status(201).redirect('back');
    MongoClient.connect(keys.mongodb.dbURI, { useNewUrlParser: true, useUnifiedTopology: true }, function (err, db) {
        if (err) throw err;
        var dbo = db.db(keys.mongodb.dbName);
        dbo.collection("madAndNuttySolutions").insertOne(madAndNuttyObj, function (err, result) {
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
        dbo.collection("madAndNuttySolutions").findOne(myquery, function (err, result) {
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
        dbo.collection('madAndNuttySolutions', {}, function (err, solution) {
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
        dbo.collection("madAndNuttySolutions").deleteOne(myquery, function (err, obj) {
            if (err) throw err;
            console.log("1 document deleted");
            res.status(200).redirect('/madAndNutty/dashboard');
            db.close();
        });
    });
});

router.get('/vote', (req, res) => {
    MongoClient.connect(keys.mongodb.dbURI, { useUnifiedTopology: true, useNewUrlParser: true }, function (err, db) {
        if (err) throw err;
        var dbo = db.db(keys.mongodb.dbName);
        dbo.collection("madAndNuttySolutions").find({}).toArray(function (err, result) {
            if (err) res.status(400).json("Error Connecting DB");
            res.render('mad-and-nutty/vote', {
                pageTitle: 'Mad And Nutty Vote',
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
            dbo.collection("madAndNuttySolutions").find(myquery).toArray(function (err, result) {
                if (err) res.status(400).json("Error Connecting DB");
                if (isNaN(result[0].count)) {
                    result[0].count = 0;
                    result[0].count = result[0].count + 1;
                } else {
                    result[0].count = result[0].count + 1;
                }
                console.log(result[0]);
                var myquery = { _id: new mongodb.ObjectID(result[0]._id) };
                dbo.collection("madAndNuttySolutions").updateOne(myquery, { $set: result[0] }, function (err, res) {
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
        dbo.collection("madAndNuttySolutions").find({}).toArray(function (err, result) {
            if (err) res.status(400).json("Error Connecting DB");
            res.render('mad-and-nutty/vote', {
                pageTitle: 'Mad And Nutty Vote',
                data: result,
            });
            db.close();
        });
    });
});

module.exports = router;