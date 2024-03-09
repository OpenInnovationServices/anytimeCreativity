const keys = require('../config/keys');
const MongoClient = require('mongodb').MongoClient;
const model = require('../models/fortuneTellersModel');
var mongodb = require('mongodb');
const fs = require('fs');

exports.index = (req, res, next) => {
    res.render('fortune-tellers/index', {
        pageTitle: 'Fortune Tellers',
    });
};

exports.dashboard = (req, res, next) => {
    MongoClient.connect(keys.mongodb.dbURI, { useNewUrlParser: true, useUnifiedTopology: true }, function(err, db) {
        if (err) throw err;
        var dbo = db.db(keys.mongodb.dbName);
        dbo.collection("fortuneTellers").find({}).toArray(function(err, result) {
            if (err) res.status(400).json("Error Connecting DB");
            // console.log(result);
            res.status(200).render('fortune-tellers/dashboard', {
                pageTitle: 'Fortune Tellers Dashboard',
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
        dbo.collection("fortuneTellers").find({}).toArray(function(err, result) {
            if (err) res.status(400).json("Error Connecting DB");
            res.render('fortune-tellers/vote', {
                pageTitle: 'Fortune Tellers Vote',
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
        dbo.collection("fortuneTellers").find({}).toArray(function(err, result) {
            if (err) res.status(400).json("Error Connecting DB");
            res.render('fortune-tellers/voting-dashboard', {
                pageTitle: 'Fortune Tellers Results',
                data: result
            });
            db.close();
        });
    });
};

exports.post = (req, res, next) => {
    const modelObj = new model({
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
        dbo.collection("fortuneTellers").insertOne(modelObj, function(err, result) {
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
        dbo.collection('fortuneTellers', {}, function(err, solution) {
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
        dbo.collection("fortuneTellers").deleteOne(myquery, function(err, obj) {
            if (err) throw err;
            // console.log("1 document deleted");
            res.status(200).redirect('/fortuneTellers/dashboard');
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
            dbo.collection("fortuneTellers").find(myquery).toArray(function(err, result) {
                if (err) res.status(400).json("Error Connecting DB");
                if (isNaN(result[0].count)) {
                    result[0].count = 0;
                    result[0].count = result[0].count + 1;
                } else {
                    result[0].count = result[0].count + 1;
                }
                // console.log(result[0]);
                var myquery = { _id: new mongodb.ObjectID(result[0]._id) };
                dbo.collection("fortuneTellers").updateOne(myquery, { $set: result[0] }, function(err, res) {
                    if (err) throw err;
                    // console.log("1 document updated");

                });
            });
        }
    });
    res.status(201).redirect('back');
};