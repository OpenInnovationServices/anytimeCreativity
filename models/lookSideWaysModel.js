const mongoose = require('mongoose');
const Schema = mongoose.Schema;

const lookSidewaysSchema = new Schema({
    team: String,
    playerNames:String,
    idea: String,
    ideaName: String,
    count: 0
});

const lookSideways = mongoose.model('lookSidewaysSolution', lookSidewaysSchema, 'lookSidewaysSolutions');

module.exports = lookSideways;