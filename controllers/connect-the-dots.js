exports.index = (req, res, next) => {
    res.render('connect-the-dots/index', {
        pageTitle: 'Connect The Dots',
    });
};

exports.dashboard = (req, res, next) => {
    res.render('connect-the-dots/dashboard', {
        pageTitle: 'Connect The Dots Dashboard',
        data: [],
    });
};

exports.vote = (req, res, next) => {
    res.render('connect-the-dots/vote', {
        pageTitle: 'Connect The Dots Vote',
        data: [],
    });
};

exports.voteDashboard = (req, res, next) => {
    res.render('connect-the-dots/voting-dashboard', {
        pageTitle: 'Connect The Dots Voting Dashboard',
        data: [],
    });
};