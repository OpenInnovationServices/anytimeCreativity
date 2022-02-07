const router = require('express').Router();
const reimagineController = require('../controllers/reimagine');

router.get('/', reimagineController.index);
router.get('/dashboard', reimagineController.dashboard);
router.get('/vote', reimagineController.vote);
router.get('/vote/dashboard', reimagineController.voteDashboard);
// router.post('/post-vote', reimagineController.postVote);
module.exports = router;