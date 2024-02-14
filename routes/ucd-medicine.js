const router = require('express').Router();
const controller = require('../controllers/ucd-medicine');

router.get('/', controller.index);
router.get('/dashboard', controller.dashboard);
router.get('/vote', controller.vote);
router.get('/vote/dashboard', controller.voteDashboard);
router.get('/idea', controller.idea);
module.exports = router;