const db = require('../models')
const axios = require('axios')
const Products = db.products
const Users = db.users
const ExhibitSettings = db.exhibitsettings

const { downloadImage, loginBuyma, exhibitBuyma } = require('../global')

var user_id = 1
var keyword = ''
var min_price = 0
var max_price = 0
var category = 'all'

const site_url = 'https://www.goat.com/'

// var catergory_list = ["Sneakers","T-Shirts", "Outerwear", "Bags", "Apparel", "Hoodies", "Bottoms", "Jewelry"];
var sn_now_page = 1

class SneakersInfo {
  res = {}
  constructor(data) {
    this.res = data
  }
  save_data() {
    console.log('+++', this.res)
    Products.findAll({
      where: { user_id: user_id, product_id: this.res.product_id },
    })
      .then((data) => {
        if (data.length > 0) {
          Products.update(this.res, {
            where: { user_id: user_id, product_id: this.res.product_id },
          })
            .then((num) => {
              console.log('Update data Okay!', this.res)
            })
            .catch((err) => {
              console.log('Update data Failed!')
            })
        } else {
          Products.create(this.res)
            .then((num) => {
              console.log('Update data Okay!', this.res)
            })
            .catch((err) => {
              console.log('Update data Failed!')
            })
        }
      })
      .catch((err) => {
        console.log('Error get item_list!')
      })
  }
}

function SneakersGetData(page) {
  //https://www.goat.com/_next/data/niCKxKxK6G3ks8FlRUHMH/en-US/search.json?query=
  var url =
    'https://ac.cnstrc.com/browse/group_id/' +
    category +
    '?c=ciojs-client-2.29.2&key=key_XT7bjdbvjgECO5d8&i=79856f44-5524-4cb6-b5ce-c05edd0da397&s=4&page=' +
    page +
    '&num_results_per_page=100&_dt=1661741501397'

  if (max_price > 0) {
    url += '&filters[lowest_price_cents]=' + min_price + '-' + max_price
  }
  console.log('URL >> ', url)

  axios
    .get(url, {})
    .then(async (response) => {
      var res = response.data.response.results
      let facets = response.data.response.facets

      console.log(res)
      if (res.length > 0) {
        for (var i = 0; i < res.length; i++) {
          var insert_query = {}

          var val = res[i].value.split("'")

          insert_query.site_url = site_url

          insert_query.product_id = res[i].data.id
          //console.log("SnerksName:", insert_query.product_id);
          insert_query.product_img = res[i].data.image_url
          local_img = 'images/' + new Date().getTime() + '.jpg'
          await downloadImage(insert_query.product_img, local_img)
          insert_query.product_local_img = local_img
          insert_query.product_name = val[1]
          insert_query.product_comment = res[i].value
          insert_query.category = res[i].data.category

          insert_query.brand = 'Goat'

          insert_query.season_ = ''
          insert_query.theme_ = ''
          insert_query.size_color = res[i].data.color
          insert_query.delivery = ''
          insert_query.deadline = res[i].data.release_date
          insert_query.place = ''
          insert_query.shop_name_ = val[0]
          insert_query.shipping_place = ''
          insert_query.product_price = res[i].data.lowest_price_cents_jpy
          insert_query.normal_pirce_ = res[i].data.retail_price_cents_jpy
          insert_query.tariff_ = ''
          insert_query.exhibition_memo_ = ''
          insert_query.purchase_memo_ = ''
          insert_query.price_type = 'JPY'

          var sneak = new SneakersInfo(insert_query)
          sneak.save_data()
        }
        //console.log("++++++++++++++++++++++++++++++++++++++++++++++++++++++", page);
        // sn_now_page++;

        // SneakersGetData(sn_now_page);
      }
    })
    .catch((err) => {
      console.log('Update data Failed!')
    })
}

exports.changeInfo = (req, res) => {}

exports.getInfo = async (req, res) => {
  try {
    if (req.query.sel > 0) {
      user_id = req.query.sel
      category = req.query.category

      if (req.query.min_price > 0) min_price = req.query.min_price

      if (req.query.max_price > 0) max_price = req.query.max_price

      SneakersGetData(sn_now_page)

      res.status(200).json({ success: true })
    } else {
      console.log('Sel is 0!')
    }
  } catch (error) {
    console.log('Error Goat getInfo!')
  }
}

exports.exhibit = (req, res) => {
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
        // console.log(exhibitsettings)
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
      console.log('exhibit in goat error: ', err)
    })
}
