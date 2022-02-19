const router = require('express').Router();
const keys = require('../config/keys');
const MongoClient = require('mongodb').MongoClient;

exports.index = (req, res, next) => {
    res.render('connect-the-dots/index', {
        pageTitle: 'Connect The Dots',
    });
};

exports.dashboard = (req, res, next) => {
    MongoClient.connect(keys.mongodb.dbURI, { useUnifiedTopology: true, useNewUrlParser: true }, function(err, db) {
        if (err) throw err;
        var dbo = db.db(keys.mongodb.dbName);
        dbo.collection("challengeDataCollection").find({ "code": "1001" }).toArray(function(err, result) {
            if (err) res.status(400).json("Error Connecting DB");
            res.status(200).render('connect-the-dots/dashboard', {
                pageTitle: 'Connect The Dots Dashboard',
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
        dbo.collection("challengeDataCollection").find({ "code": "1001" }).toArray(function(err, result) {
            if (err) res.status(400).json("Error Connecting DB");
            res.render('connect-the-dots/vote', {
                pageTitle: 'Connect The Dots Vote',
                data: result
            });
            db.close();
        });
    });
};

exports.voteDashboard = (req, res, next) => {
    MongoClient.connect(keys.mongodb.dbURI, { useUnifiedTopology: true, useNewUrlParser: true }, function(err, db) {
        if (err) throw err;
        var dbo = db.db(keys.mongodb.dbName);
        dbo.collection("challengeDataCollection").find({ "code": "1001" }).toArray(function(err, result) {
            if (err) res.status(400).json("Error Connecting DB");
            res.render('connect-the-dots/voting-dashboard', {
                pageTitle: 'Connect The Dots Results',
                data: result
            });
            db.close();
        });
    });
};