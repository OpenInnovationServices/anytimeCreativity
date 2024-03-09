const mongoose = require('mongoose');
const Schema = mongoose.Schema;

const blueSkiesSchema = new Schema({
    problem: String,
    problemText: String,
    solutions:String,
    teamName: String,
    playerNames: String,
    ideaName: String,
    ideaDescription: String,
    count: 0
});

const blueSkies = mongoose.model('fortuneTellers', blueSkiesSchema, 'fortuneTellers');

module.exports = blueSkies;