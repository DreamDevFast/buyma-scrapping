const express = require("express");
const router = express.Router();
const goat = require("./goat.route");
const loui = require("./loui.route");

const yahoo = require("./yahoo.route");
const cors = require("cors");
const corsOptions = {
   origin:'*', 
   credentials:true,            //access-control-allow-credentials:true
   optionSuccessStatus:200,
}

const initializeRoute = (app) => {
    app.use(cors(corsOptions));
    router.use('/goats', goat);
    router.use('/louis', loui);
    router.use('/yahoos', yahoo);
    app.use('/api/v1', router);
}

module.exports = initializeRoute;