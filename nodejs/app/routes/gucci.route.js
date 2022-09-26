const express = require('express')
const router = express.Router()
const gucci = require('../controllers/gucci.controller.js')

router.get('/', gucci.getInfo)
router.post('/', gucci.exhibit)

module.exports = router
