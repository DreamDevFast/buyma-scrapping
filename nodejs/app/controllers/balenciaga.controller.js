const db = require('../models')
const axios = require('axios')
const Products = db.products
const Users = db.users
const Brand = db.brands
const ExhibitSettings = db.exhibitsettings
const {
  downloadImage,
  loginBuyma,
  exhibitBuyma,
  getProductsFromBalenciaga,
} = require('../global')

var user_id = 1
const site_url = 'https://www.balenciaga.com/'
var balenciaga_brand
const categoriesMapping = {}

class SneakersInfo {
  res = {}
  constructor(data) {
    this.res = data
  }
  save_data() {
    Products.findAll({
      where: { product_id: this.res.product_id, site_url },
    })
      .then((data) => {
        if (data.length > 0) {
          Products.update(this.res, {
            where: {
              product_id: this.res.product_id,
              site_url,
            },
          })
            .then((num) => {
              console.log('Update data Okay!')
            })
            .catch((err) => {
              console.log('Update data Failed!', err)
            })
        } else {
          Products.create(this.res)
            .then((num) => {
              console.log('Create data Okay!')
            })
            .catch((err) => {
              console.log('Create data Failed!', err)
            })
        }
      })
      .catch((err) => {
        console.log('Error get item_list!:', err)
      })
  }
}

async function SneakersGetData(page, hitsPerPage, query) {
  const url = `https://www.balenciaga.com/on/demandware.store/Sites-BAL-R-JAPN-Site/ja_JP/Search-UpdateGrid?q=${query}&prefn1=akeneo_employeesSalesVisible&prefv1=false&prefn2=akeneo_markDownInto&prefv2=no_season&prefn3=countryInclusion&prefv3=JP&start=${page}&sz=${hitsPerPage}`
  console.log('URL >> ', url)
  try {
    let products = await getProductsFromBalenciaga(encodeURI(url))

    for (var i = 0; i < products.length; i++) {
      var insert_query = {}

      insert_query.site_url = site_url

      insert_query.product_id = products[i].id
      //console.log("SnerksName:", insert_query.product_id);
      insert_query.product_img = products[i].image
      local_img = 'images/' + new Date().getTime() + '.jpg'
      await downloadImage(insert_query.product_img, local_img)
      insert_query.product_local_img = local_img
      insert_query.product_name = products[i].name
      insert_query.product_comment = ''
      insert_query.category = ''

      insert_query.brand = balenciaga_brand.id

      insert_query.season_ = ''
      insert_query.theme_ = ''
      insert_query.size_color = ''
      insert_query.delivery = ''
      insert_query.deadline = new Date()
      insert_query.place = ''
      insert_query.shop_name_ = ''
      insert_query.shipping_place = ''
      insert_query.product_price = products[i].discountPrice
      insert_query.normal_pirce_ = products[i].discountPrice
      insert_query.tariff_ = ''
      insert_query.exhibition_memo_ = ''
      insert_query.purchase_memo_ = ''
      insert_query.price_type = 'JPY'

      var sneak = new SneakersInfo(insert_query)
      await sneak.save_data()
    }

    // page++

    // SneakersGetData(page, query)
  } catch (err) {
    console.log('Fetch data error in balenciaga', err)
  }
}

const getInfo = async (req, res) => {
  try {
    console.log('here')
    if (req.query.sel > 0) {
      user_id = req.query.sel
      const keyword = req.query.keyword
      console.log(keyword)
      balenciaga_brand = await Brand.findOne({ where: { name: 'Balenciaga' } })
      if (balenciaga_brand) {
      } else {
        balenciaga_brand = await Brand.create({ name: 'Balenciaga' })
      }
      await SneakersGetData(0, 12, keyword)
    }
    res.status(200).json({ success: true })
  } catch (err) {
    console.log('get info error in Balenciaga: ', err)
    res.status(500).json({ success: false, error: err })
  }
}

const exhibit = (req, res) => {
  const { user_id } = req.body

  Products.findAll({
    where: { site_url },
  })
    .then(async (products) => {
      if (products.length) {
        const user = await Users.findOne({
          where: { id: user_id },
        })
        user.status = 'exhibit'
        await user.save()
        res.status(200).json({ success: false })
        const exhibitsettings = await ExhibitSettings.findOne({
          where: { user_id },
        })
        await loginBuyma()
        for (let i = 0; i < products.length; i++) {
          const success = await exhibitBuyma(
            products[i],
            i !== 0,
            exhibitsettings,
          )
        }
        user.status = 'init'
        await user.save()
      }
    })
    .catch((err) => {
      console.log('exhibit in dior error: ', err)
      res.status(500).json({ success: false, error: err })
    })
}
module.exports = {
  getInfo,
  exhibit,
}
