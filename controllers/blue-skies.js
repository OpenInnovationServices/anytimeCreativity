exports.index = (req, res, next) => {
    res.render('blue-skies/index', {
        pageTitle: 'Blue Skies',
    });
};

exports.dashboard = (req, res, next) => {
    res.render('blue-skies/dashboard', {
        pageTitle: 'Blue Skies Dashboard',
        data: [],
    });
};

exports.vote = (req, res, next) => {
    res.render('blue-skies/vote', {
        pageTitle: 'Blue Skies Vote',
        data: [],
    });
};

exports.voteDashboard = (req, res, next) => {
    res.render('blue-skies/voting-dashboard', {
        pageTitle: 'Blue Skies Voting Dashboard',
        data: [],
    });
};