const router = require('express').Router();
const crazyCombinationController = require('../controllers/crazy-combination');

router.get('/', crazyCombinationController.index);
router.get('/dashboard', crazyCombinationController.dashboard);
router.get('/vote', crazyCombinationController.vote);
router.get('/vote/dashboard', crazyCombinationController.voteDashboard);
// router.post('/post-vote', crazyCombinationController.postVote);
module.exports = router;