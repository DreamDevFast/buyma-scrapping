const express = require('express')
const router = express.Router()
const buy = require('../controllers/bur.controller.js')

router.get('/get_info', buy.getInfo)
router.get('/change_info', buy.changeInfo)
router.post('/', buy.exhibit)

module.exports = router
