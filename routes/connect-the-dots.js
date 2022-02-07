const router = require('express').Router();
const connectTheDotsController = require('../controllers/connect-the-dots');

router.get('/', connectTheDotsController.index);
router.get('/dashboard', connectTheDotsController.dashboard);
router.get('/vote', connectTheDotsController.vote);
router.get('/vote/dashboard', connectTheDotsController.voteDashboard);
// router.post('/post-vote', connectTheDotsController.postVote);
module.exports = router;