const express = require('express')
const router = express.Router()
const dior = require('../controllers/dior.controller.js')

router.get('/', dior.getInfo)
router.post('/', dior.exhibit)

module.exports = router
