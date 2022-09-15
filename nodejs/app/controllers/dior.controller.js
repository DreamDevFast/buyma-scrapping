const db = require('../models')
const axios = require('axios')
const Products = db.products

const getInfo = (req, res) => {
  try {
    if (res.query.user_id > 0) {
      const keyword = res.query.keyword
    }
    res.status(200).json({ success: true })
  } catch (err) {
    console.log('get info error in dior: ', err)
    res.status(500).json({ success: false, error: err })
  }
}

module.exports = {
  getInfo,
}
