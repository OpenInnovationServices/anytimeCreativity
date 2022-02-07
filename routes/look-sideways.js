const router = require('express').Router();
const lookSidewaysController = require('../controllers/look-sideways');

router.get('/', lookSidewaysController.index);
router.get('/dashboard', lookSidewaysController.dashboard);
router.get('/vote', lookSidewaysController.vote);
router.get('/vote/dashboard', lookSidewaysController.voteDashboard);
// router.post('/post-vote', lookSidewaysController.postVote);
module.exports = router;