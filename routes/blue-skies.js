const router = require('express').Router();
const blueSkiesController = require('../controllers/blue-skies');

router.get('/', blueSkiesController.index);
router.get('/dashboard', blueSkiesController.dashboard);
router.get('/vote', blueSkiesController.vote);
router.get('/vote/dashboard', blueSkiesController.voteDashboard);
// router.post('/post-vote', blueSkiesController.postVote);
module.exports = router;