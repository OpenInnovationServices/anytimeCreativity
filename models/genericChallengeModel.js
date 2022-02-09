const mongoose = require('mongoose');
const Schema = mongoose.Schema;

const challengeSchema = new Schema({
    mix: String,
    match: String,
    mix_text: String,
    match_text: String,
    teamName:String,
    penName: String,
    ideaName: String,
    idea: String,
    code: String,
    count: 0
});

const challengeModel = mongoose.model('challengeData', challengeSchema, 'challengeDataCollection');

module.exports = challengeModel;