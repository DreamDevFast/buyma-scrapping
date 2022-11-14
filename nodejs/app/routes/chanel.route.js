const express = require('express')
const router = express.Router()
const chanel = require('../controllers/chanel.controller.js')

router.get('/', chanel.getInfo)
router.post('/', chanel.exhibit)

module.exports = router
