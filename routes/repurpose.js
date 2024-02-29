const router = require('express').Router();
const controller = require('../controllers/repurpose');

router.get('/', controller.index);
router.get('/dashboard', controller.dashboard);
router.get('/vote', controller.vote);
router.get('/vote/dashboard', controller.voteDashboard);
router.post('/', controller.post);
router.post('/delete', controller.delete);
router.post('/delete/id', controller.deleteId);
router.post('/vote', controller.votePost);
module.exports = router;