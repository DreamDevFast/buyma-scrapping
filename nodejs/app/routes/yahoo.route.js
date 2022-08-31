const express = require("express");
const router = express.Router();
const yahoos = require("../controllers/yahoo.controller.js");

router.get('/get_info', yahoos.getInfo);
router.get('/change_info', yahoos.changeInfo);

module.exports = router;