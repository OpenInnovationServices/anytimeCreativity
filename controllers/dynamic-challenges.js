const router = require('express').Router();
const keys = require('../config/keys');
const MongoClient = require('mongodb').MongoClient;
var mongodb = require('mongodb');


router.get('/', (req, res) => {
    res.status(200).render('pages/dynamicAppCreationForm.ejs');
});

router.get('/:gameId', (req, res) => {
    // res.status(200).render('pages/connectTheDotsApp.ejs');
    console.log("Game Id is set to " + req.params.gameId);
    MongoClient.connect(keys.mongodb.dbURI, { useUnifiedTopology: true, useNewUrlParser: true }, function (err, db) {
        if (err) throw err;
        var dbo = db.db(keys.mongodb.dbName);
        dbo.collection("dynamicChallengeSolution").find({ "_id": new mongodb.ObjectId(req.params.gameId) }).toArray(function (err, result) {
            if (err) res.status(400).json("Error Connecting DB");
            console.log("in here " + result);
            res.status(200).render('pages/connectTheDotsAppDynamic.ejs', { data: result});
            db.close();
        });
    });
});

router.get('/dashboard/:gameId', (req, res) => {
    console.log("Game Id is set to " + req.params.gameId);
    MongoClient.connect(keys.mongodb.dbURI, { useUnifiedTopology: true, useNewUrlParser: true }, function (err, db) {
        if (err) throw err;
        var dbo = db.db(keys.mongodb.dbName);
        dbo.collection("dynamicChallengeDataCollection").find({ "gameId": req.params.gameId }).toArray(function (err, result) {
            if (err) res.status(400).json("Error Connecting DB");
            res.status(200).render('pages/connectTheDots-dashboard-dynamic.ejs', { data: result, length: result.length});
            db.close();
        });
    });
});

router.get('/vote', (req, res) => {
    MongoClient.connect(keys.mongodb.dbURI, { useUnifiedTopology: true, useNewUrlParser: true }, function (err, db) {
        if (err) throw err;
        var dbo = db.db(keys.mongodb.dbName);
        dbo.collection("dynamicChallengeDataCollection").find({ "code": "1001" }).toArray(function (err, result) {
            if (err) res.status(400).json("Error Connecting DB");
            res.status(200).render('pages/connectTheDots-voting.ejs', { data: result, length: result.length });
            db.close();
        });
    });
});

router.get('/vote/dashboard', (req, res) => {
    MongoClient.connect(keys.mongodb.dbURI, { useUnifiedTopology: true, useNewUrlParser: true }, function (err, db) {
        if (err) throw err;
        var dbo = db.db(keys.mongodb.dbName);
        dbo.collection("dynamicChallengeDataCollection").find({ "code": "1001" }).toArray(function (err, result) {
            if (err) res.status(400).json("Error Connecting DB");
            res.status(200).render('pages/connectTheDots-voting-dashboard.ejs', { data: result, length: result.length });
            db.close();
        });
    });
});

module.exports = router;