const keys = require('../config/keys');
const MongoClient = require('mongodb').MongoClient;
const model = require('../models/blueSkiesModel');
var mongodb = require('mongodb');
const fs = require('fs');

exports.index = (req, res, next) => {
    res.render('blue-skies/index', {
        pageTitle: 'Blue Skies',
    });
};

exports.dashboard = (req, res, next) => {
    MongoClient.connect(keys.mongodb.dbURI, { useNewUrlParser: true, useUnifiedTopology: true }, function(err, db) {
        if (err) throw err;
        var dbo = db.db(keys.mongodb.dbName);
        dbo.collection("blueSkiesSolutions").find({}).toArray(function(err, result) {
            if (err) res.status(400).json("Error Connecting DB");
            // console.log(result);
            res.status(200).render('blue-skies/dashboard', {
                pageTitle: 'Blue Skies Dashboard',
                data: result
            });
            db.close();
        });
    });
};

exports.vote = (req, res, next) => {
    MongoClient.connect(keys.mongodb.dbURI, { useUnifiedTopology: true, useNewUrlParser: true }, function(err, db) {
        if (err) throw err;
        var dbo = db.db(keys.mongodb.dbName);
        dbo.collection("blueSkiesSolutions").find({}).toArray(function(err, result) {
            if (err) res.status(400).json("Error Connecting DB");
            res.render('blue-skies/vote', {
                pageTitle: 'Blue Skies Vote',
                data: result,
            });
            db.close();
        });
    });
};

exports.voteDashboard = (req, res, next) => {
    MongoClient.connect(keys.mongodb.dbURI, { useUnifiedTopology: true, useNewUrlParser: true }, function(err, db) {
        if (err) throw err;
        var dbo = db.db(keys.mongodb.dbName);
        dbo.collection("blueSkiesSolutions").find({}).toArray(function(err, result) {
            if (err) res.status(400).json("Error Connecting DB");
            res.render('blue-skies/voting-dashboard', {
                pageTitle: 'Blue Skies Results',
                data: result
            });
            db.close();
        });
    });
};

exports.post = (req, res, next) => {
    const blueSkiesObj = new model({
        problem: req.body.problem,
        problemText: req.body.problemText,
        solutions: req.body.solutions,
        teamName: req.body.teamName,
        playerNames: req.body.playerNames,
        ideaName: req.body.ideaName,
        ideaDescription: req.body.ideaDescription,
        count: 0
    });

    MongoClient.connect(keys.mongodb.dbURI, { useNewUrlParser: true, useUnifiedTopology: true }, function(err, db) {
        if (err) throw err;
        var dbo = db.db(keys.mongodb.dbName);
        dbo.collection("blueSkiesSolutions").insertOne(blueSkiesObj, function(err, result) {
            if (err) res.status(400).json("Error Connecting DB");
            res.status(201).redirect('back');
            db.close();
        });
    });
};

exports.delete = (req, res, next) => {
    MongoClient.connect(keys.mongodb.dbURI, { useNewUrlParser: true, useUnifiedTopology: true }, function(err, db) {
        if (err) throw err;
        var dbo = db.db(keys.mongodb.dbName);
        dbo.collection('blueSkiesSolutions', {}, function(err, solution) {
            solution.deleteMany({}, function(err, result) {
                if (err) {
                    console.log(err);
                }
                res.status(200).redirect('back');
                db.close();
            });
        });
    });
};

exports.deleteId = (req, res, next) => {
    MongoClient.connect(keys.mongodb.dbURI, { useNewUrlParser: true, useUnifiedTopology: true }, function(err, db) {
        if (err) throw err;
        var dbo = db.db(keys.mongodb.dbName);
        var myquery = { _id: new mongodb.ObjectID(req.body.id) };
        dbo.collection("blueSkiesSolutions").deleteOne(myquery, function(err, obj) {
            if (err) throw err;
            // console.log("1 document deleted");
            res.status(200).redirect('/blueSkies/dashboard');
            db.close();
        });
    });
};

exports.votePost = (req, res, next) => {
    MongoClient.connect(keys.mongodb.dbURI, { useNewUrlParser: true, useUnifiedTopology: true }, function(err, db) {
        if (err) throw err;
        for (let i = 0; i < Object.keys(req.body).length; i++) {
            // console.log(Object.keys(req.body)[i]);
            var dbo = db.db(keys.mongodb.dbName);
            var myquery = { _id: new mongodb.ObjectID(Object.keys(req.body)[i]) };
            dbo.collection("blueSkiesSolutions").find(myquery).toArray(function(err, result) {
                if (err) res.status(400).json("Error Connecting DB");
                if (isNaN(result[0].count)) {
                    result[0].count = 0;
                    result[0].count = result[0].count + 1;
                } else {
                    result[0].count = result[0].count + 1;
                }
                // console.log(result[0]);
                var myquery = { _id: new mongodb.ObjectID(result[0]._id) };
                dbo.collection("blueSkiesSolutions").updateOne(myquery, { $set: result[0] }, function(err, res) {
                    if (err) throw err;
                    // console.log("1 document updated");

                });
            });
        }
    });
    res.status(201).redirect('back');
};