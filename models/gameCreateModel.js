const mongoose = require('mongoose');
const Schema = mongoose.Schema;

const dynamicChallengeSchema = new Schema({
    companyName: String,
    mixGroup:[],
    matchGroup: [],
    gameCode: String
});

const dynamicChallengeCreate = mongoose.model('dynamicChallengeSolution', dynamicChallengeSchema, 'dynamicChallengeSolutions');

module.exports = dynamicChallengeCreate;