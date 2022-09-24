const express = require('express')
const router = express.Router()
const goat = require('./goat.route')
const loui = require('./loui.route')
const bur = require('./bur.route')
const dior = require('./dior.route')
const exhibit = require('./exhibit.route')

const cors = require('cors')
const corsOptions = {
  origin: '*',
  credentials: true, //access-control-allow-credentials:true
  optionSuccessStatus: 200,
}

const initializeRoute = (app) => {
  app.use(cors(corsOptions))
  router.use('/goats', goat)
  router.use('/louis', loui)
  router.use('/burs', bur)
  router.use('/dior', dior)
  router.use('/exhibit', exhibit)

  app.use('/api/v1', router)
}

module.exports = initializeRoute
