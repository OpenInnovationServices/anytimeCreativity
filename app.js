const express = require('express');
const app = express();

var path = require('path');
const bodyParser = require('body-parser');

//Setting Port
var port = process.env.PORT || 3000;

app.all("/*", function(req, res, next) {
    res.header('Access-Control-Allow-Origin', '*');
    res.header('Access-Control-Allow-Methods', 'GET,PUT,POST,DELETE,OPTIONS');
    res.header('Access-Control-Allow-Headers', 'Content-Type, Authorization, Content-Length, X-Requested-With');
    next();
});

app.use(express.static(path.join(__dirname, '/public')));

// set the view engine to ejs
app.set('view engine', 'ejs');
app.set('views', 'views');

// parse requests of content-type - application/x-www-form-urlencoded
app.use(bodyParser.urlencoded({ extended: true }));

// parse requests of content-type - application/json
app.use(bodyParser.json());

app.get('/', (req, res) => {
    res.status(200).render('index');
});

app.get('/challenges', (req, res) => {
    res.status(200).render('challenges');
});

app.get('/how-it-works', (req, res) => {
    res.status(200).render('how-it-works');
});

app.get('/pricing', (req, res) => {
    res.status(200).render('pricing');
});

app.get('/crazyCombinations', (req, res) => {
    res.status(200).render('crazy-combinations');
});

app.get('/connectTheDots', (req, res) => {
    res.status(200).render('connect-the-dots');
});

app.get('/reImagine', (req, res) => {
    res.status(200).render('re-imagine');
});

app.get('/madAndNutty', (req, res) => {
    res.status(200).render('mad-nutty');
});

app.get('/blueSkies', (req, res) => {
    res.status(200).render('blue-skies');
});

app.get('/lookSideways', (req, res) => {
    res.status(200).render('look-sideways');
});

app.get('/book-a-demo', (req, res) => {
    res.status(200).render('book-a-demo');
});

// Handle 404 - Keep this as a last route
app.use(function(req, res, next) {
    res.status(404).send('404: File Not Found');
});

app.listen(port, () => {
    console.log('app now listening for request on port 3000');
});