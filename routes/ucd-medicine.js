const router = require('express').Router();
const controller = require('../controllers/ucd-medicine');

router.get('/', controller.index);
router.get('/dashboard', controller.dashboard);
router.get('/vote', controller.vote1);
router.get('/build', controller.vote2);
router.get('/vote/dashboard', controller.voteDashboard);
router.get('/idea', controller.idea);
router.get('/results', controller.result);
router.get('/results/dashboard', controller.resultDashboard);
module.exports = router;