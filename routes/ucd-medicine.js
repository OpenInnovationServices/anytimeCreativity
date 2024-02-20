const router = require('express').Router();
const controller = require('../controllers/ucd-medicine');

router.get('/', controller.index);
router.get('/dashboard', controller.dashboard);
router.get('/vote1', controller.vote1);
router.get('/vote2', controller.vote2);
router.get('/vote/dashboard', controller.voteDashboard);
router.get('/idea', controller.idea);
router.get('/result', controller.result);
module.exports = router;