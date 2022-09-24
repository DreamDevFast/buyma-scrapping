const express = require('express')
const router = express.Router()
const exhibit = require('../controllers/exhibit.controller.js')

router.post('/', exhibit.exhibit)

module.exports = router
