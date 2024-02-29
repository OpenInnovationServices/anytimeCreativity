const mongoose = require('mongoose');
const Schema = mongoose.Schema;

const repurposeSchema = new Schema({
    object: String,
    playerNames: String,
    teamName: String,
    imaginations: String,
    ideaCount:String,
    ideaName: String,
    ideaDescription: String,
    count: 0
});

const repurposeSchemaModel = mongoose.model('repurposeSolution', repurposeSchema, 'repurposeSolution');

module.exports = repurposeSchemaModel;