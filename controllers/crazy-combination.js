exports.index = (req, res, next) => {
    res.render('crazy-combinations/index', {
        pageTitle: 'Crazy Combination',
    });
};

exports.dashboard = (req, res, next) => {
    res.render('crazy-combinations/dashboard', {
        pageTitle: 'Crazy Combination Dashboard',
        data: [],
    });
};

exports.vote = (req, res, next) => {
    res.render('crazy-combinations/vote', {
        pageTitle: 'Crazy Combination Vote',
        data: [],
    });
};

exports.voteDashboard = (req, res, next) => {
    res.render('crazy-combinations/voting-dashboard', {
        pageTitle: 'Crazy Combination Voting Dashboard',
        data: [],
    });
};