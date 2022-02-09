const mongoose = require('mongoose');
const Schema = mongoose.Schema;

const madAndNuttySchema = new Schema({
    object1: String,
    object2: String,
    object3: String,
    object4: String,
    teamName: String,
    playerNames: String,
    ideaName:String,
    ideaDescription: String,
    image: String,
    count: 0
});

const madAndNutty = mongoose.model('madAndNuttySolution', madAndNuttySchema, 'madAndNuttySolutions');

module.exports = madAndNutty;