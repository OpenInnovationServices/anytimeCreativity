const router = require('express').Router();
const keys = require('../config/keys');
const MongoClient = require('mongodb').MongoClient;
var mongodb = require('mongodb');

exports.index = (req, res, next) => {
    res.render('crazy-combinations/index', {
        pageTitle: 'Crazy Combination',
    });
};

exports.dashboard = (req, res, next) => {
    // res.render('crazy-combinations/dashboard', {
    //     pageTitle: 'Crazy Combination Dashboard',
    //     data: [],
    // });
    MongoClient.connect(keys.mongodb.dbURI, { useUnifiedTopology: true, useNewUrlParser: true }, function (err, db) {
        if (err) throw err;
        var dbo = db.db(keys.mongodb.dbName);
        dbo.collection("challengeDataCollection").find({ "code": "1000" }).toArray(function (err, result) {
            if (err) res.status(400).json("Error Connecting DB");
            res.status(200).render('crazy-combinations/dashboard', { pageTitle: 'Crazy Combination Dashboard', data: result });
            db.close();
        });
    });
};

exports.vote = (req, res, next) => {
    // res.render('crazy-combinations/vote', {
    //     pageTitle: 'Crazy Combination Vote',
    //     data: [],
    // });
    MongoClient.connect(keys.mongodb.dbURI, { useUnifiedTopology: true, useNewUrlParser: true }, function (err, db) {
        if (err) throw err;
        var dbo = db.db(keys.mongodb.dbName);
        dbo.collection("challengeDataCollection").find({ "code": "1000" }).toArray(function (err, result) {
            if (err) res.status(400).json("Error Connecting DB");
            res.status(200).render('pages/crazyCombo-voting.ejs', { pageTitle: 'Crazy Combination Vote', data: result});
            db.close();
        });
    });
};

exports.voteDashboard = (req, res, next) => {
    // res.render('crazy-combinations/voting-dashboard', {
    //     pageTitle: 'Crazy Combination Voting Dashboard',
    //     data: [],
    // });
    MongoClient.connect(keys.mongodb.dbURI, { useUnifiedTopology: true, useNewUrlParser: true }, function (err, db) {
        if (err) throw err;
        var dbo = db.db(keys.mongodb.dbName);
        dbo.collection("challengeDataCollection").find({ "code": "1000" }).toArray(function (err, result) {
            if (err) res.status(400).json("Error Connecting DB");
            res.status(200).render('pages/crazyCombo-voting-dashboard.ejs', { pageTitle: 'Crazy Combination Vote', data: result });
            db.close();
        });
    });
};