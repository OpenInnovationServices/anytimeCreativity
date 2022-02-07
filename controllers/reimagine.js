exports.index = (req, res, next) => {
    res.render('reimagine/index', {
        pageTitle: 'Reimagine',
    });
};

exports.dashboard = (req, res, next) => {
    res.render('reimagine/dashboard', {
        pageTitle: 'Reimagine Dashboard',
        data: [],
    });
};

exports.vote = (req, res, next) => {
    res.render('reimagine/vote', {
        pageTitle: 'Reimagine Vote',
        data: [],
    });
};

exports.voteDashboard = (req, res, next) => {
    res.render('reimagine/voting-dashboard', {
        pageTitle: 'Reimagine Voting Dashboard',
        data: [],
    });
};