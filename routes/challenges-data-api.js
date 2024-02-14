const router = require('express').Router();
const keys = require('../config/keys');
const MongoClient = require('mongodb').MongoClient;
const challengeModel = require('../models/genericChallengeModel');
const challengeDataEmailCollectionModel = require('../models/genericChallengeEmailModel');
const challengeDataIdeaCollection = require('../models/genericChallengeIdeaModel');

var mongodb = require('mongodb');

// get all data api
router.get('/', (req, res) => {
    //res.status(200).render('pages/index.ejs');
    MongoClient.connect(keys.mongodb.dbURI, { useUnifiedTopology: true, useNewUrlParser: true }, function(err, db) {
        if (err) throw err;
        var dbo = db.db(keys.mongodb.dbName);
        dbo.collection("challengeDataCollection").find({}).toArray(function(err, result) {
            if (err) res.status(400).json("Error Connecting DB");
            res.status(200).json(result);
            db.close();
        });
    });

});


//create home route
// router.get('/view',(req,res)=>{
//     MongoClient.connect(keys.mongodb.dbURI,{useNewUrlParser:true}, function(err, db) {
//         if (err) throw err;
//         var dbo = db.db("PROD");
//         dbo.collection("challengeDataCollection").find({}).toArray(function(err, result) {
//           if (err) res.status(400).json("Error Connecting DB");
//           //console.log(result);
//           res.status(200).render('pages/cc-view.ejs',{data:result,length:result.length});
//           db.close();
//         });
//     }); 

// });

router.post('/', (req, res) => {
    // console.log(req.body);
    const idea = new challengeModel({
        user: req.body.user,
        mix: req.body.mix,
        mix1: req.body.mix1,
        match: req.body.match,
        match1: req.body.match1,
        mix_text: req.body.mix_text,
        mix1_text: req.body.mix1_text,
        match_text: req.body.match_text,
        match1_text: req.body.match1_text,
        idea: req.body.idea,
        penName: req.body.penName,
        teamName: req.body.teamName,
        ideaName: req.body.ideaName,
        code: req.body.code,
        count: 0
    });
    // console.log(idea);
    // console.log('-------------------------');
    // return false;

    MongoClient.connect(keys.mongodb.dbURI, { useNewUrlParser: true }, function(err, db) {
        if (err) throw err;
        var dbo = db.db(keys.mongodb.dbName);
        dbo.collection("challengeDataCollection").insertOne(idea, function(err, result) {
            if (err) res.status(400).json("Error Connecting DB");
            res.status(201).redirect('/api/challenge');
            db.close();
        });
    });
})

router.post('/delete', (req, res) => {
    MongoClient.connect(keys.mongodb.dbURI, { useNewUrlParser: true }, function(err, db) {
        if (err) throw err;
        var dbo = db.db(keys.mongodb.dbName);
        dbo.collection('challengeDataCollection', {}, function(err, solution) {
            solution.deleteMany({}, function(err, result) {
                if (err) {
                    console.log(err);
                }
                res.status(200).redirect('/challenge');
                db.close();
            });
        });
    });
});

router.post('/delete/id', (req, res) => {
    MongoClient.connect(keys.mongodb.dbURI, { useNewUrlParser: true }, function(err, db) {
        if (err) throw err;
        var dbo = db.db(keys.mongodb.dbName);
        var myquery = { _id: new mongodb.ObjectID(req.body.id) };
        dbo.collection("challengeDataCollection").deleteOne(myquery, function(err, obj) {
            if (err) throw err;
            console.log("1 document deleted");
            res.status(200).redirect('back');
            db.close();
        });
    });
});

router.get('/:code', (req, res) => {
    //res.status(200).render('pages/index.ejs');
    console.log(req.params.code);
    MongoClient.connect(keys.mongodb.dbURI, { useUnifiedTopology: true, useNewUrlParser: true }, function(err, db) {
        if (err) throw err;
        var dbo = db.db(keys.mongodb.dbName);
        dbo.collection("challengeDataCollection").find({ "code": req.params.code }).toArray(function(err, result) {
            if (err) res.status(400).json("Error Connecting DB");
            res.status(200).json(result);
            db.close();
        });
    });

});

router.post('/voteCheck', async (req, res) => {
    const email = req.body.email;
    const code = req.body.code;
    let client, db;

    try{
        client = await MongoClient.connect(keys.mongodb.dbURI, {useNewUrlParser: true});
        db = client.db(keys.mongodb.dbName);
        let collection = db.collection('challengeDataEmailCollection');
        let result = await collection.findOne({ "code": code, 'email': email });
       
        if (result) {
            res.status(201).json({ 'status': 'exists' });
        } else {
            res.status(201).json({ 'status': 'not exists' });
        }

        // let result = await collection.countDocuments();
        // return result.toArray();
    } catch (err) { 
        console.error(err); 
        res.status(400).json("Error Connecting DB");
    } finally {
        client.close(); 
    }
});

router.post('/VoteAdd', async (req, res) => {
    let client, db;

    try{
        const email = req.body.email;
        const code = req.body.code;
        const ids = [];
    
        delete req.body.email;
        delete req.body.code;
    
        for (let i = 0; i < Object.keys(req.body).length; i++) {
            ids.push(Object.keys(req.body)[i])
        }
    
        const newModel = new challengeDataEmailCollectionModel({
            email,
            code,
            ids,
        });

        client = await MongoClient.connect(keys.mongodb.dbURI, {useNewUrlParser: true});
        db = client.db(keys.mongodb.dbName);

        let emailCollection = db.collection('challengeDataEmailCollection');
        let collection = db.collection('challengeDataCollection');

        for (const id of ids) {
            var myquery = { _id: new mongodb.ObjectID(id) };
            const result = await collection.findOne(myquery);

            if(result) {
                const newCount = (isNaN(result.count) || (result.count < 0) ) ? 0 :  result.count + 1;
                await collection.updateOne(myquery, { $set: { count: newCount} });
                // console.log("1 document updated");
            }
        }

        await emailCollection.deleteOne({ "code": code, 'email': email });
        await emailCollection.insertOne(newModel);

        // client.close(); 
        // console.log('Add Vote --');
        res.status(201).redirect('back');
    } catch (err) { 
        console.error(err); 
        res.status(400).json("Error Connecting DB");
    } finally {
        client.close(); 
    }
});

router.post('/voteRemove', async (req, res) => {
    let client, db;

    try{
        const email = req.body.email;
        const code = req.body.code;
        const ids = [];
    
        delete req.body.email;
        delete req.body.code;
    
        for (let i = 0; i < Object.keys(req.body).length; i++) {
            ids.push(Object.keys(req.body)[i])
        }
    
        const newModel = new challengeDataEmailCollectionModel({
            email,
            code,
            ids,
        });

        client = await MongoClient.connect(keys.mongodb.dbURI, {useNewUrlParser: true});
        db = client.db(keys.mongodb.dbName);

        let emailCollection = db.collection('challengeDataEmailCollection');
        let collection = db.collection('challengeDataCollection');

        let result = await emailCollection.findOne({ "code": code, 'email': email });
       
        if (result) {
            const newIds = result.ids;

            for (const id of newIds) {
                var myquery = { _id: new mongodb.ObjectID(id) };
                const result = await collection.findOne(myquery);
    
                if(result) {
                    let newCount = (isNaN(result.count) || (result.count < 0) ) ? 0 :  result.count - 1;
                    newCount = newCount < 0 ? 0 : newCount;
                    await collection.updateOne(myquery, { $set: { count: newCount} });
                    // console.log("1 document updated");
                }
            }
        }

        for (const id of ids) {
            var myquery = { _id: new mongodb.ObjectID(id) };
            const result = await collection.findOne(myquery);

            if(result) {
                const newCount = (isNaN(result.count) || (result.count < 0) ) ? 0 :  result.count + 1;
                await collection.updateOne(myquery, { $set: { count: newCount} });
                // console.log("1 document updated");
            }
        }

        await emailCollection.deleteOne({ "code": code, 'email': email });
        await emailCollection.insertOne(newModel);

        // client.close(); 
        // console.log('Remove Vote --');
        res.status(201).redirect('back');
    } catch (err) { 
        console.error(err); 
        res.status(400).json("Error Connecting DB");
    } finally {
        client.close(); 
    }
});

router.post('/voteIdea', async (req, res) => {
    let client, db;

    try{
        const code = req.body.code;
        const id = req.body.id;
        const name = req.body.name;
        const twist = req.body.twist;
       
        client = await MongoClient.connect(keys.mongodb.dbURI, {useNewUrlParser: true});
        db = client.db(keys.mongodb.dbName);

        let ideaCollection = db.collection('challengeDataIdeaCollection');
        let collection = db.collection('challengeDataCollection');

        var myquery = { _id: new mongodb.ObjectID(id) };
        const result = await collection.findOne(myquery);

        if(result) {
            const newModel = new challengeDataIdeaCollection({
                ...result,
                id,
                name,
                twist,
                code,
                _id: new mongodb.ObjectID(),
            });
            
            await ideaCollection.insertOne(newModel);

            res.status(201).json({ 'status': 'success' });
        } else {
            res.status(404).json("Result not found");
        }

        // client.close(); 
        // console.log('Add Vote --');
        // res.status(201).redirect('back');
    } catch (err) {
        console.error(err); 
        res.status(400).json("Error Connecting DB");
    } finally {
        client.close(); 
    }
});



//## Not using this.
router.post('/vote', (req, res) => {
    MongoClient.connect(keys.mongodb.dbURI, { useNewUrlParser: true }, function(err, db) {
        if (err) throw err;
        for (let i = 0; i < Object.keys(req.body).length; i++) {
            console.log(Object.keys(req.body)[i])
            var dbo = db.db(keys.mongodb.dbName);
            var myquery = { _id: new mongodb.ObjectID(Object.keys(req.body)[i]) };
            dbo.collection("challengeDataCollection").find(myquery).toArray(function(err, result) {
                if (err) res.status(400).json("Error Connecting DB");
                if (isNaN(result[0].count)) {
                    result[0].count = 0;
                    result[0].count = result[0].count + 1;
                } else {
                    result[0].count = result[0].count + 1;
                }
                console.log(result[0]);
                var myquery = { _id: new mongodb.ObjectID(result[0]._id) };
                dbo.collection("challengeDataCollection").updateOne(myquery, { $set: result[0] }, function(err, res) {
                    if (err) throw err;
                    console.log("1 document updated");
                    db.close();
                });
            });
        }
    });
    res.status(201).redirect('back');
})

module.exports = router;