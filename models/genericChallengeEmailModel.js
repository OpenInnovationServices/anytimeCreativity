const mongoose = require('mongoose');
const Schema = mongoose.Schema;

const challengeDataEmailCollectionSchema = new Schema({
    code: String,
    ids: {
        type: Array,
    },
    email: {
        type: String,
        required: true
    }
});

module.exports = mongoose.model('challengeDataEmailCollection', challengeDataEmailCollectionSchema);