const mongoose = require('mongoose');
const Schema = mongoose.Schema;

const blueSkiesSchema = new Schema({
    problem: String,
    solutions:String,
    teamName: String,
    playerNames: String,
    ideaName: String,
    ideaDescription: String,
    count: 0
});

const blueSkies = mongoose.model('blueSkiesSolution', blueSkiesSchema, 'blueSkiesSolutions');

module.exports = blueSkies;