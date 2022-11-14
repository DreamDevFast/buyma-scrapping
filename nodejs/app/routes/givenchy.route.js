const express = require('express')
const router = express.Router()
const givenchy = require('../controllers/givenchy.controller.js')

router.get('/', givenchy.getInfo)
router.post('/', givenchy.exhibit)

module.exports = router
