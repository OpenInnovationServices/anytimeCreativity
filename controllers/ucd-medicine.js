const router = require('express').Router();
const keys = require('../config/keys');
const MongoClient = require('mongodb').MongoClient;

exports.index = (req, res, next) => {
    res.render('ucd-medicine/index', {
        pageTitle: 'Connect The Dots',
    });
};

exports.dashboard = (req, res, next) => {
    MongoClient.connect(keys.mongodb.dbURI, { useUnifiedTopology: true, useNewUrlParser: true }, function(err, db) {
        if (err) throw err;
        var dbo = db.db(keys.mongodb.dbName);
        dbo.collection("challengeDataCollection").find({ "code": "1002" }).toArray(function(err, result) {
            if (err) res.status(400).json("Error Connecting DB");
            res.status(200).render('ucd-medicine/dashboard', {
                pageTitle: 'Connect The Dots Dashboard',
                data: result
            });
            db.close();
        });
    });
};

exports.vote1 = (req, res, next) => {
    MongoClient.connect(keys.mongodb.dbURI, { useUnifiedTopology: true, useNewUrlParser: true }, function(err, db) {
        if (err) throw err;
        var dbo = db.db(keys.mongodb.dbName);
        dbo.collection("challengeDataCollection").find({ "code": "1002" }).toArray(function(err, result) {
            if (err) res.status(400).json("Error Connecting DB");
            res.render('ucd-medicine/vote1', {
                pageTitle: 'Connect The Dots Vote',
                data: result
            });
            db.close();
        });
    });
};


exports.vote2 = (req, res, next) => {
    MongoClient.connect(keys.mongodb.dbURI, { useUnifiedTopology: true, useNewUrlParser: true }, function(err, db) {
        if (err) throw err;
        var dbo = db.db(keys.mongodb.dbName);
        dbo.collection("challengeDataCollection").find({ "code": "1002" }).toArray(function(err, result) {
            if (err) res.status(400).json("Error Connecting DB");
            res.render('ucd-medicine/vote2', {
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
        dbo.collection("challengeDataCollection").find({ "code": "1002" }).toArray(function(err, result) {
            if (err) res.status(400).json("Error Connecting DB");
            res.render('ucd-medicine/voting-dashboard', {
                pageTitle: 'Connect The Dots Results',
                data: result
            });
            db.close();
        });
    });
};


exports.idea = (req, res, next) => {
    MongoClient.connect(keys.mongodb.dbURI, { useUnifiedTopology: true, useNewUrlParser: true }, function(err, db) {
        if (err) throw err;
        var dbo = db.db(keys.mongodb.dbName);
        dbo.collection("challengeDataIdeaCollection").find({ "code": "1002" }).toArray(function(err, result) {
            if (err) res.status(400).json("Error Connecting DB");
            res.render('ucd-medicine/vote-idea', {
                pageTitle: 'Connect The Dots Vote',
                data: result
            });
            db.close();
        });
    });
};