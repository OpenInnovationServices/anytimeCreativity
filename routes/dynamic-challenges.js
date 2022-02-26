const router = require('express').Router();
const keys = require('../config/keys');
const MongoClient = require('mongodb').MongoClient;
var mongodb = require('mongodb');
const model = require('../models/gameCreateModel');


router.get('/', (req, res) => {
    MongoClient.connect(keys.mongodb.dbURI, { useUnifiedTopology: true, useNewUrlParser: true }, function (err, db) {
        if (err) throw err;
        var dbo = db.db(keys.mongodb.dbName);
        dbo.collection("objectsIcons").find({}).toArray(function (err, result) {
            if (err) res.status(400).json("Error Connecting DB");
            console.log("in here " + result);
            // res.send("Success");
            res.status(200).render('dynamic-pages/createGameCTD', { data: result});
            db.close();
        });
    });
});

router.post('/', (req, res) => {
    const game = new model({
        companyName: req.body.companyName,
        mixGroup: req.body.mixGroup,
        matchGroup: req.body.matchGroup,
        gameCode: "1001"
    });
    MongoClient.connect(keys.mongodb.dbURI, { useNewUrlParser: true, useUnifiedTopology: true }, function(err, db) {
        if (err) throw err;
        var dbo = db.db(keys.mongodb.dbName);
        dbo.collection("dynamicChallengeSolution").insertOne(game, function(err, result) {
            if (err) res.status(400).json("Error Connecting DB");
            res.send(result);
            db.close();
        });
    });
});

router.get('/ctd/:gameId', (req, res) => {
    // res.status(200).render('pages/connectTheDotsApp.ejs');
    console.log("Game Id is set to " + req.params.gameId);
    MongoClient.connect(keys.mongodb.dbURI, { useUnifiedTopology: true, useNewUrlParser: true }, function (err, db) {
        if (err) throw err;
        var dbo = db.db(keys.mongodb.dbName);
        dbo.collection("dynamicChallengeSolution").find({ "_id": new mongodb.ObjectId(req.params.gameId) }).toArray(function (err, result) {
            if (err) res.status(400).json("Error Connecting DB");
            console.log("in here " + result);
            // res.send("Success");
            res.status(200).render('dynamic-pages/connect-the-dots/index', { data: result});
            db.close();
        });
    });
});

router.get('/ctd/dashboard/:gameId', (req, res) => {
    console.log("Game Id is set to " + req.params.gameId);
    MongoClient.connect(keys.mongodb.dbURI, { useUnifiedTopology: true, useNewUrlParser: true }, function (err, db) {
        if (err) throw err;
        var dbo = db.db(keys.mongodb.dbName);
        dbo.collection("dynamicChallengeDataCollection").find({ "gameId": req.params.gameId }).toArray(function (err, result) {
            if (err) res.status(400).json("Error Connecting DB");
            res.status(200).render('dynamic-pages/connect-the-dots/dashboard', { pageTitle: 'Connect The Dots Dashboard',data: result});
            db.close();
        });
    });
});

router.get('/ctd/vote/:gameId', (req, res) => {
    MongoClient.connect(keys.mongodb.dbURI, { useUnifiedTopology: true, useNewUrlParser: true }, function (err, db) {
        if (err) throw err;
        var dbo = db.db(keys.mongodb.dbName);
        dbo.collection("dynamicChallengeDataCollection").find({ "gameId": req.params.gameId }).toArray(function (err, result) {
            if (err) res.status(400).json("Error Connecting DB");
            res.status(200).render('dynamic-pages/connect-the-dots/voting', { data: result});
            db.close();
        });
    });
});

router.get('/ctd/vote/dashboard/:gameId', (req, res) => {
    MongoClient.connect(keys.mongodb.dbURI, { useUnifiedTopology: true, useNewUrlParser: true }, function (err, db) {
        if (err) throw err;
        var dbo = db.db(keys.mongodb.dbName);
        dbo.collection("dynamicChallengeDataCollection").find({ "gameId": req.params.gameId  }).toArray(function (err, result) {
            if (err) res.status(400).json("Error Connecting DB");
            res.status(200).render('dynamic-pages/connect-the-dots/voting-dashboard', { data: result, length: result.length });
            db.close();
        });
    });
});

module.exports = router;