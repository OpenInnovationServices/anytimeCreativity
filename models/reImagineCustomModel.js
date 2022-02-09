const mongoose = require('mongoose');
const Schema = mongoose.Schema;

const reImagineNewSchema = new Schema({
    object: String,
    playerNames: String,
    teamName: String,
    imaginations: String,
    ideaCount:String,
    ideaName: String,
    ideaDescription: String,
    count: 0
});

const reImagineNew = mongoose.model('reImagineNewSolution', reImagineNewSchema, 'reImagineNewSolutions');

module.exports = reImagineNew;