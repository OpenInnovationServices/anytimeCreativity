exports.index = (req, res, next) => {
    res.render('mad-and-nutty/index', {
        pageTitle: 'Mad And Nutty',
    });
};

exports.dashboard = (req, res, next) => {
    res.render('mad-and-nutty/dashboard', {
        pageTitle: 'Mad And Nutty Dashboard',
        data: [],
    });
};

exports.vote = (req, res, next) => {
    res.render('mad-and-nutty/vote', {
        pageTitle: 'Mad And Nutty Vote',
        data: [],
    });
};

exports.voteDashboard = (req, res, next) => {
    res.render('mad-and-nutty/voting-dashboard', {
        pageTitle: 'Mad And Nutty Voting Dashboard',
        data: [],
    });
};