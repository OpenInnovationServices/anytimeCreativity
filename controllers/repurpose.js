const keys = require('../config/keys');
const MongoClient = require('mongodb').MongoClient;
const model = require('../models/repurposeModel');
var mongodb = require('mongodb');
const fs = require('fs');

exports.index = (req, res, next) => {
    res.render('repurpose/index', {
        pageTitle: 'Repurpose',
    });
};

exports.dashboard = (req, res, next) => {
    MongoClient.connect(keys.mongodb.dbURI, { useNewUrlParser: true, useUnifiedTopology: true }, function(err, db) {
        if (err) throw err;
        var dbo = db.db(keys.mongodb.dbName);
        dbo.collection("repurposeSolution").find({}).toArray(function(err, result) {
            if (err) res.status(400).json("Error Connecting DB");
            // console.log(result);
            res.status(200).render('repurpose/dashboard', {
                pageTitle: 'Repurpose Dashboard',
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
        dbo.collection("repurposeSolution").find({}).toArray(function(err, result) {
            if (err) res.status(400).json("Error Connecting DB");
            res.render('repurpose/vote', {
                pageTitle: 'Repurpose Vote',
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
        dbo.collection("repurposeSolution").find({}).toArray(function(err, result) {
            if (err) res.status(400).json("Error Connecting DB");
            res.render('repurpose/voting-dashboard', {
                pageTitle: 'Repurpose Results',
                data: result
            });
            db.close();
        });
    });
};

var multer = require("multer");
var storage = multer.diskStorage({
    destination: function(req, file, callback) {
        callback(null, './public/assets/uploads'); // set the destination
    },
    filename: function(req, file, callback) {
        callback(null, Date.now() + '.png'); // set the file name and extension
    }
});
var upload = multer({ storage: storage });

exports.post = (req, res, next) => {
    const Repurposed = new model({
        object: req.body.object,
        teamName: req.body.team,
        playerNames: req.body.playerNames,
        imaginations: req.body.imaginations,
        ideaName: req.body.ideaName,
        ideaCount: req.body.ideaCount,
        ideaDescription: req.body.ideaDescription,
        count: 0
    });

    MongoClient.connect(keys.mongodb.dbURI, { useNewUrlParser: true, useUnifiedTopology: true }, function(err, db) {
        if (err) throw err;
        var dbo = db.db(keys.mongodb.dbName);
        dbo.collection("repurposeSolution").insertOne(Repurposed, function(err, result) {
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
        dbo.collection('repurposeSolution', {}, function(err, solution) {
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
        dbo.collection("repurposeSolution").deleteOne(myquery, function(err, obj) {
            if (err) throw err;
            // console.log("1 document deleted");
            res.status(200).redirect('/repurpose/dashboard');
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
            dbo.collection("repurposeSolution").find(myquery).toArray(function(err, result) {
                if (err) res.status(400).json("Error Connecting DB");
                if (isNaN(result[0].count)) {
                    result[0].count = 0;
                    result[0].count = result[0].count + 1;
                } else {
                    result[0].count = result[0].count + 1;
                }
                // console.log(result[0]);
                var myquery = { _id: new mongodb.ObjectID(result[0]._id) };
                dbo.collection("repurposeSolution").updateOne(myquery, { $set: result[0] }, function(err, res) {
                    if (err) throw err;
                    // console.log("1 document updated");

                });
            });
        }
    });
    res.status(201).redirect('back');
};