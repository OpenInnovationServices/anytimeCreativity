const express = require('express');
const app = express();

var path = require('path');
const bodyParser = require('body-parser');

//Routes
const crazyCombinationRoutes = require('./routes/crazy-combination');
const connectTheDotsRoutes = require('./routes/connect-the-dots');
const madAndNuttyRoutes = require('./routes/mad-and-nutty');
const blueSkiesRoutes = require('./routes/blue-skies');
const lookSidewaysRoutes = require('./routes/look-sideways');
const reimagineRoutes = require('./routes/reimagine');
const repurposeRoutes = require('./routes/repurpose');
const submitChallengeDataApiRoutes = require('./routes/challenges-data-api');
const ucdMedicineRoutes = require('./routes/ucd-medicine.js');
const ucdMedicine1Routes = require('./routes/ucd-medicine1.js');
const ucdMedicine2Routes = require('./routes/ucd-medicine2.js');
const ucdMedicine3Routes = require('./routes/ucd-medicine3.js');
const fortuneTellersRoutes = require('./routes/fortune-tellers');


//Setting Port
var port = process.env.PORT || 3030;

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

app.use('/crazyCombinations', crazyCombinationRoutes);
app.use('/connectTheDots', connectTheDotsRoutes);
app.use('/madAndNutty', madAndNuttyRoutes);
app.use('/blueSkies', blueSkiesRoutes);
app.use('/lookSideways', lookSidewaysRoutes);
app.use('/reImagine', reimagineRoutes);
app.use('/repurpose', repurposeRoutes);
app.use('/ConnectTheDots/UCDMedicine/challenge', ucdMedicineRoutes);
app.use('/ConnectTheDots/UCDMedicine1/challenge', ucdMedicine1Routes);
app.use('/ConnectTheDots/UCDMedicine2/challenge', ucdMedicine2Routes);
app.use('/ConnectTheDots/UCDMedicine3/challenge', ucdMedicine3Routes);
app.use('/api/challenge', submitChallengeDataApiRoutes);
app.use('/fortuneTellers', fortuneTellersRoutes);


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

app.get('/book-a-demo', (req, res) => {
    res.status(200).render('book-a-demo');
});

app.get('/privacy-policy', (req, res) => {
    res.status(200).render('privacy-policy');
});

app.get('/reImagine1', (req, res) => {
    res.status(200).render('reimagine/index1');
});

// Handle 404 - Keep this as a last route
app.use(function(req, res, next) {
    res.status(404).send('404: File Not Found');
});

app.listen(port, () => {
    console.log('app now listening for request on port 3000');
});