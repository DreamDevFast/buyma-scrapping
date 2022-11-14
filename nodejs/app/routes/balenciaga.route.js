const express = require('express')
const router = express.Router()
const balenciaga = require('../controllers/balenciaga.controller.js')

router.get('/', balenciaga.getInfo)
router.post('/', balenciaga.exhibit)

module.exports = router
