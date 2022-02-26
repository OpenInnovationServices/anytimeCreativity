const mongoose = require('mongoose');
const Schema = mongoose.Schema;

const dynamicChallengeDataSchema = new Schema({
    mix: String,
    match: String,
    mix_text: String,
    match_text: String,
    teamName:String,
    penName: String,
    ideaName: String,
    idea: String,
    gameCode: String,
    gameId: String,
    code: String,
    count: 0
});

const dynamicChallengeModel = mongoose.model('dynamicChallengeData', dynamicChallengeDataSchema, 'dynamicChallengeDataCollection');

module.exports = dynamicChallengeModel;