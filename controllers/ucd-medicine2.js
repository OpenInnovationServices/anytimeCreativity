const router = require('express').Router();
const keys = require('../config/keys');
const MongoClient = require('mongodb').MongoClient;

exports.index = (req, res, next) => {
    res.render('ucd-medicine2/index', {
        pageTitle: 'UCD Medicine',
    });
};

exports.dashboard = (req, res, next) => {
    MongoClient.connect(keys.mongodb.dbURI, { useUnifiedTopology: true, useNewUrlParser: true }, function(err, db) {
        if (err) throw err;
        var dbo = db.db(keys.mongodb.dbName);
        dbo.collection("challengeDataCollection").find({ "code": "1004" }).toArray(function(err, result) {
            if (err) res.status(400).json("Error Connecting DB");
            res.status(200).render('ucd-medicine2/dashboard', {
                pageTitle: 'UCD Medicine Dashboard',
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
        dbo.collection("challengeDataCollection").find({ "code": "1004" }).toArray(function(err, result) {
            if (err) res.status(400).json("Error Connecting DB");
            res.render('ucd-medicine2/vote1', {
                pageTitle: 'UCD Medicine Vote',
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
        dbo.collection("challengeDataCollection").find({ "code": "1004" }).toArray(function(err, result) {
            if (err) res.status(400).json("Error Connecting DB");
            res.render('ucd-medicine2/vote2', {
                pageTitle: 'UCD Medicine Vote',
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
        dbo.collection("challengeDataCollection").find({ "code": "1004" }).toArray(function(err, result) {
            if (err) res.status(400).json("Error Connecting DB");
            res.render('ucd-medicine2/voting-dashboard', {
                pageTitle: 'UCD Medicine Vote Dashboard',
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
        dbo.collection("challengeDataIdeaCollection").find({ "code": "1004" }).toArray(function(err, result) {
            if (err) res.status(400).json("Error Connecting DB");
            res.render('ucd-medicine2/vote-idea', {
                pageTitle: 'UCD Medicine Idea',
                data: result
            });
            db.close();
        });
    });
};

exports.result = async (req, res, next) => {
    let client, db;

    try{
        client = await MongoClient.connect(keys.mongodb.dbURI, { useNewUrlParser: true });
        db = client.db(keys.mongodb.dbName);

        let collection = db.collection('challengeDataCollection');
        let ideaCollection = db.collection('challengeDataIdeaCollection');

        const result1 = await collection.find({ "code": "1004" }).sort( { count: -1 } ).toArray()
        const result2 = await ideaCollection.find({ "code": "1004" }).toArray()

        res.render('ucd-medicine2/vote-result', {
            pageTitle: 'UCD Medicine Idea',
            data: { result1, result2 }
        });

    } catch (err) { 
        console.error(err); 
        res.status(400).json("Error Connecting DB");
    } finally {
        client.close(); 
    }
};

exports.resultDashboard = async (req, res, next) => {
    let client, db;

    try{
        client = await MongoClient.connect(keys.mongodb.dbURI, { useNewUrlParser: true });
        db = client.db(keys.mongodb.dbName);

        let collection = db.collection('challengeDataCollection');
        let ideaCollection = db.collection('challengeDataIdeaCollection');

        const result1 = await collection.find({ "code": "1004" }).sort( { count: -1 } ).toArray()
        const result2 = await ideaCollection.find({ "code": "1004" }).toArray()

        res.render('ucd-medicine2/vote-result-dashboard', {
            pageTitle: 'UCD Medicine Idea',
            data: { result1, result2 }
        });

    } catch (err) { 
        console.error(err); 
        res.status(400).json("Error Connecting DB");
    } finally {
        client.close(); 
    }
};
