const express = require('express')
const router = express.Router()
const loui = require('../controllers/loui.controller.js')

router.get('/get_info', loui.getInfo)
router.get('/change_info', loui.changeInfo)
router.post('/', loui.exhibit)

module.exports = router
