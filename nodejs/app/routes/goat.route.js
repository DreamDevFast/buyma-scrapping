const express = require('express')
const router = express.Router()
const goat = require('../controllers/goat.controller.js')

router.get('/get_info', goat.getInfo)
router.get('/change_info', goat.changeInfo)
router.post('/', goat.exhibit)

module.exports = router
