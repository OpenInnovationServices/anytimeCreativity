const router = require('express').Router();
const madAndNuttyController = require('../controllers/mad-and-nutty');

router.get('/', madAndNuttyController.index);
router.get('/dashboard', madAndNuttyController.dashboard);
router.get('/vote', madAndNuttyController.vote);
router.get('/vote/dashboard', madAndNuttyController.voteDashboard);
// router.post('/post-vote', madAndNuttyController.postVote);
module.exports = router;