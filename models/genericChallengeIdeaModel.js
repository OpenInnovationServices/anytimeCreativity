const mongoose = require('mongoose');
const Schema = mongoose.Schema;

const challengeDataIdeaCollectionSchema = new Schema({
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
    count: 0,
    newIdea: String,
    name: String,
    twist: String
});

module.exports = mongoose.model('challengeDataIdeaCollection', challengeDataIdeaCollectionSchema);