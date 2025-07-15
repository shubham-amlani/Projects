import express from 'express';
import session from 'express-session';
import MongoStore from 'connect-mongo';
import './db.js';
import User from './models/User.js';
import cors from 'cors';

const app = express();
app.use(express.json());
app.use(express.urlencoded({ extended: true }));

app.use(cors({
  origin: 'http://localhost:5173', // Replace with your frontend app's URL
  credentials: true
}));

app.use(
    session({
      secret: 'your_secret_key',
      resave: false,
      saveUninitialized: false,
      store: MongoStore.create({
        mongoUrl: 'mongodb://localhost:27017/mines',
      }),
      cookie: { secure: false }, // Set to true if using HTTPS
    })
);

app.post('/api/auth', async (req, res) => {
  try {
    const { username } = req.body;
    let user = await User.findOne({ username });
    
    if (user) {
      // User exists, log them in
      req.session.userId = user._id;
      return res.status(200).send(`Logged in UID:${user._id}`);
    } else {
      // User does not exist, create a new user
      user = new User({ username });
      await user.save();
      req.session.userId = user._id;
      return res.status(201).send(`User registered and logged in UID:${user._id}`);
    }
  } catch (error) {
    res.status(400).send(error.message);
  }
});

app.get('/api/auth/check', (req, res) => {
  const userId = req.session.userId;
  if (userId) {
    return res.json({ authenticated: true });
  } else {
    return res.json({ authenticated: false });
  }
});

app.post('/api/auth/logout', (req, res) => {
  req.session.destroy();
  res.send('Logged out');
});

// Middleware to check if user is authenticated
const isAuthenticated = (req, res, next) => {
    if (req.session.userId) {
      return next();
    }
    res.sendStatus(401);
};

// Get Balance Route
app.get('/balance', isAuthenticated, async (req, res) => {
    try {
      const user = await User.findById(req.session.userId);
      res.status(200).send({ balance: user.balance });
    } catch (error) {
      res.status(400).send(error.message);
    }
});

// Update Balance Route
app.post('/balance', isAuthenticated, async (req, res) => {
    try {
      const { amount } = req.body;
      const user = await User.findById(req.session.userId);
      user.balance += amount;
      await user.save();
      res.status(200).send({ balance: user.balance });
    } catch (error) {
      res.status(400).send(error.message);
    }
});

app.post('/startgame', async (req, res)=>{
    console.log(req.body);
    res.send(JSON.stringify({status: 'started', gameId:'as4e89234'}));
});

app.post('/opentile', (req, res)=>{
    console.log(req.body);
    res.send(JSON.stringify({gameId: 'as4e89234', status: 'in-progress', tilesArray: [[0, 1], [0, 0], [1, 0], [0, 1]]}));
})

app.listen(3000, function(req, res){
    console.log("Server is up and running...");
});