const mongoose = require('mongoose');
const Schema = mongoose.Schema;

const challengeSchema = new Schema({
    user: String,
    mix: String,
    mix1: String,
    match: String,
    match1: String,
    mix_text: String,
    mix1_text: String,
    match_text: String,
    match1_text: String,
    teamName: String,
    penName: String,
    ideaName: String,
    idea: String,
    code: String,
    count: 0
});

const challengeModel = mongoose.model('challengeData', challengeSchema, 'challengeDataCollection');

module.exports = challengeModel;