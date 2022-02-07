exports.index = (req, res, next) => {
    res.render('look-sideways/index', {
        pageTitle: 'Look Sideways',
    });
};

exports.dashboard = (req, res, next) => {
    res.render('look-sideways/dashboard', {
        pageTitle: 'Look Sideways Dashboard',
        data: [],
    });
};

exports.vote = (req, res, next) => {
    res.render('look-sideways/vote', {
        pageTitle: 'Look Sideways Vote',
        data: [],
    });
};

exports.voteDashboard = (req, res, next) => {
    res.render('look-sideways/voting-dashboard', {
        pageTitle: 'Look Sideways Voting Dashboard',
        data: [],
    });
};