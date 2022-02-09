const router = require('express').Router();
const keys = require('../config/keys');
const MongoClient = require('mongodb').MongoClient;
const reImagine = require('../models/reImagineCustomModel');
// const riImage = require('../models/imageUploadModal');
var mongodb = require('mongodb');


router.get('/', (req, res) => {
    res.render('reimagine/index', {
        pageTitle: 'Reimagine',
    });
});


router.get('/dashboard', (req, res) => {
    MongoClient.connect(keys.mongodb.dbURI, { useNewUrlParser: true, useUnifiedTopology: true }, function(err, db) {
        if (err) throw err;
        var dbo = db.db(keys.mongodb.dbName);
        dbo.collection("reImagineCustomSolutions").find({}).toArray(function(err, result) {
            if (err) res.status(400).json("Error Connecting DB");
              console.log(result);
              res.render('reimagine/dashboard', {
                pageTitle: 'Reimagine Dashboard',
                data: result,
            });
            db.close();
        });
    });

});

router.post('/', (req, res) => {
    console.log(req.body);
    const reImagined = new reImagine({
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
        dbo.collection("reImagineCustomSolutions").insertOne(reImagined, function(err, result) {
            if (err) res.status(400).json("Error Connecting DB");
            res.status(201).redirect('/eCHALLENGES');
            db.close();
        });
    });
})



router.post('/delete/id', (req, res) => {
    MongoClient.connect(keys.mongodb.dbURI, { useNewUrlParser: true, useUnifiedTopology: true }, function(err, db) {
        if (err) throw err;
        var dbo = db.db(keys.mongodb.dbName);
        var myquery = { _id: new mongodb.ObjectID(req.body.id) };
        dbo.collection("reImagineCustomSolutions").deleteOne(myquery, function(err, obj) {
            if (err) throw err;
            // console.log("1 document deleted");
            res.status(200).redirect('/Reimagine/dashboard');
            db.close();
        });
    });
});

router.get('/vote', (req, res) => {
    MongoClient.connect(keys.mongodb.dbURI, { useUnifiedTopology: true, useNewUrlParser: true }, function(err, db) {
        if (err) throw err;
        var dbo = db.db(keys.mongodb.dbName);
        dbo.collection("reImagineCustomSolutions").find({}).toArray(function(err, result) {
            if (err) res.status(400).json("Error Connecting DB");
            res.render('reimagine/vote', {
                pageTitle: 'Reimagine Vote',
                data: result,
            });
            db.close();
        });
    });
});

router.post('/vote', (req, res) => {

    console.log(req.body);
    MongoClient.connect(keys.mongodb.dbURI, { useNewUrlParser: true, useUnifiedTopology: true }, function(err, db) {
        if (err) throw err;
        for (let i = 0; i < Object.keys(req.body).length; i++) {
            console.log(Object.keys(req.body)[i])
            var dbo = db.db(keys.mongodb.dbName);
            var myquery = { _id: new mongodb.ObjectID(Object.keys(req.body)[i]) };
            dbo.collection("reImagineCustomSolutions").find(myquery).toArray(function(err, result) {
                if (err) res.status(400).json("Error Connecting DB");
                if (isNaN(result[0].count)) {
                    result[0].count = 0;
                    result[0].count = result[0].count + 1;
                } else {
                    result[0].count = result[0].count + 1;
                }
                console.log(result[0]);
                var myquery = { _id: new mongodb.ObjectID(result[0]._id) };
                dbo.collection("reImagineCustomSolutions").updateOne(myquery, { $set: result[0] }, function(err, res) {
                    if (err) throw err;
                    console.log("1 document updated");

                });
            });
        }

    });
    res.status(201).redirect('back');
})

router.get('/vote/dashboard', (req, res) => {
    MongoClient.connect(keys.mongodb.dbURI, { useUnifiedTopology: true, useNewUrlParser: true }, function(err, db) {
        if (err) throw err;
        var dbo = db.db(keys.mongodb.dbName);
        dbo.collection("reImagineCustomSolutions").find({}).toArray(function(err, result) {
            if (err) res.status(400).json("Error Connecting DB");
            res.render('reimagine/voting-dashboard', {
                pageTitle: 'Reimagine Voting Dashboard',
                data: result,
            });
            db.close();
        });
    });
});

// router.get('/settings', (req, res) => {
//     MongoClient.connect(keys.mongodb.dbURI, { useNewUrlParser: true, useUnifiedTopology: true }, function(err, db) {
//         if (err) throw err;
//         var dbo = db.db(keys.mongodb.dbName);
//         dbo.collection("riImageSolutions").find({}).toArray(function(err, result) {
//             if (err) res.status(400).json("Error Connecting DB");
//             //   console.log(result);
//             res.status(200).render('pages/reImagineSettings.ejs', { data: result });
//             db.close();
//         });
//     });
// });

// router.post('/selectImage', (req, res) => {
//     MongoClient.connect(keys.mongodb.dbURI, { useNewUrlParser: true }, function(err, db) {
//         if (err) throw err;
//         var dbo = db.db(keys.mongodb.dbName);
//         var myquery = {};
//         var newValue = { $set: { selected: "N" } };
//         dbo.collection("riImageSolutions").updateMany(myquery, newValue, function(err, res) {
//             if (err) throw err;
//             // console.log(res.result.nModified+"Updated");
//         });

//         var myquery = { _id: new mongodb.ObjectID(req.body.riImage) };
//         var newValue = { $set: { selected: "Y" } };
//         dbo.collection("riImageSolutions").updateOne(myquery, newValue, function(err, obj) {
//             if (err) throw err;
//             //console.log("1 document deleted");
//             res.status(200).redirect('/reImagine/settings');
//             db.close();
//         });
//     });
// })

module.exports = router;