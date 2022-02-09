const router = require('express').Router();
const keys = require('../config/keys');
const MongoClient = require('mongodb').MongoClient;
const blueSkies = require('../models/blueSkiesModel');
var mongodb = require('mongodb');
const fs = require('fs');

router.get('/', (req, res) => {
    res.status(200).render('blue-skies/index', {
        pageTitle: 'Blue Skies',
    });
});

//create home route
router.get('/dashboard', (req, res) => {
    MongoClient.connect(keys.mongodb.dbURI, { useNewUrlParser: true, useUnifiedTopology: true }, function (err, db) {
        if (err) throw err;
        var dbo = db.db(keys.mongodb.dbName);
        dbo.collection("blueSkiesSolutions").find({}).toArray(function (err, result) {
            if (err) res.status(400).json("Error Connecting DB");
            console.log(result);
            res.status(200).render('blue-skies/dashboard', {
                pageTitle: 'Blue Skies Dashboard',
                data: result
            });
            db.close();
        });
    });

});

router.post('/', (req, res) => {
    const blueSkiesObj = new blueSkies({
        problem: req.body.problem,
        solutions:req.body.solutions,
        teamName: req.body.teamName,
        playerNames: req.body.playerNames,
        ideaName: req.body.ideaName,
        ideaDescription: req.body.ideaDescription,
        count: 0
    });
    // console.log(blueSkiesObj);
    MongoClient.connect(keys.mongodb.dbURI, { useNewUrlParser: true, useUnifiedTopology: true }, function (err, db) {
        if (err) throw err;
        var dbo = db.db(keys.mongodb.dbName);
        dbo.collection("blueSkiesSolutions").insertOne(blueSkiesObj, function (err, result) {
            if (err) res.status(400).json("Error Connecting DB");
            res.status(201).redirect('back');
            db.close();
        });
    });
});

router.post('/delete', (req, res) => {
    MongoClient.connect(keys.mongodb.dbURI, { useNewUrlParser: true, useUnifiedTopology: true }, function (err, db) {
        if (err) throw err;
        var dbo = db.db(keys.mongodb.dbName);
        dbo.collection('blueSkiesSolutions', {}, function (err, solution) {
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
        dbo.collection("blueSkiesSolutions").deleteOne(myquery, function (err, obj) {
            if (err) throw err;
            console.log("1 document deleted");
            res.status(200).redirect('/blueSkies/dashboard');
            db.close();
        });
    });
});

router.get('/vote', (req, res) => {
    MongoClient.connect(keys.mongodb.dbURI, { useUnifiedTopology: true, useNewUrlParser: true }, function (err, db) {
        if (err) throw err;
        var dbo = db.db(keys.mongodb.dbName);
        dbo.collection("blueSkiesSolutions").find({}).toArray(function (err, result) {
            if (err) res.status(400).json("Error Connecting DB");
            res.render('blue-skies/vote', {
                pageTitle: 'Blue Skies Vote',
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
            dbo.collection("blueSkiesSolutions").find(myquery).toArray(function (err, result) {
                if (err) res.status(400).json("Error Connecting DB");
                if (isNaN(result[0].count)) {
                    result[0].count = 0;
                    result[0].count = result[0].count + 1;
                } else {
                    result[0].count = result[0].count + 1;
                }
                console.log(result[0]);
                var myquery = { _id: new mongodb.ObjectID(result[0]._id) };
                dbo.collection("blueSkiesSolutions").updateOne(myquery, { $set: result[0] }, function (err, res) {
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
        dbo.collection("blueSkiesSolutions").find({}).toArray(function (err, result) {
            if (err) res.status(400).json("Error Connecting DB");
            res.render('blue-skies/voting-dashboard', {
                pageTitle: 'Blue Skies Voting Dashboard',
                data: result
            });
            db.close();
        });
    });
});


module.exports = router;