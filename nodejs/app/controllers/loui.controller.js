const db = require('../models')
const axios = require('axios')
const Products = db.products
const Users = db.users
const Brand = db.brands
const ExhibitSettings = db.exhibitsettings
const { downloadImage, loginBuyma, exhibitBuyma } = require('../global')

var user_id = 1
var keyword = ''
var min_price = 0
var max_price = 0
var category = 'all'
var loui_brand
const site_url = 'https://it.louisvuitton.com/'
// var catergory_list = ["Sneakers","T-Shirts", "Outerwear", "Bags", "Apparel", "Hoodies", "Bottoms", "Jewelry"];

var catergory_list = [
  { c_name: 'バッグ', code: ['tfr7qdp'] },
  { c_name: '財布＆小物', code: ['t164iz3b'] },
  { c_name: 'トラベル', code: ['t193qm0'] },
  {
    c_name: 'アクセサリー',
    code: [
      'tte63om',
      'toyetr6',
      'tmr7ugu',
      'tmixwg8',
      'ty346sh',
      't1peha6j',
      'tui7c0x',
    ],
  },

  { c_name: 'ファッション･ジュエリー', code: ['tqnlr03'] },
  { c_name: 'プレタポルテ(洋服)', code: ['to8aw9x'] },
  { c_name: 'シューズ', code: ['t1mcbujj'] },
  { c_name: 'フレグランス(香水)', code: ['t1pipf2k'] },

  { c_name: 'ジュエリー', code: ['t13mxv0j'] },
  { c_name: 'ウォッチ(時計)', code: ['t9nfgwi'] },
  { c_name: 'パーソナライゼーション', code: ['t1x9bru', 'te5j5ah'] },
]

var sn_now_page = 1

class SneakersInfo {
  res = {}
  constructor(data) {
    this.res = data
  }
  save_data() {
    Products.findAll({
      where: { product_id: this.res.product_id },
    })
      .then((data) => {
        console.log('data', data)
        if (data.length > 0) {
          Products.update(this.res, {
            where: { product_id: this.res.product_id },
          })
            .then((num) => {
              console.log('Update data Okay!', this.res)
            })
            .catch((err) => {
              console.log('Update data Failed! -1')
            })
        } else {
          Products.create(this.res)
            .then((num) => {
              console.log('Create data Okay')
            })
            .catch((err) => {
              console.log('Create data Failed! -2', err)
            })
        }
      })
      .catch((err) => {
        console.log('Error get item_list!', err)
      })
  }
}
var index = 0
function SneakersGetData(page) {
  //https://api.louisvuitton.com/eco-eu/search-merch-eapi/v1/jpn-jp/plp/products/tkfqvgi?page=1
  // console.log(catergory_list[category]['code'][index])
  var url =
    'https://api.louisvuitton.com/eco-eu/search-merch-eapi/v1/jpn-jp/records?keyword=' +
    keyword +
    '&page=' +
    page
  //console.log("URL >> ", index);

  // if(max_price > 0){
  // 	url +="&filters[lowest_price_cents]="+min_price+"-"+max_price;
  // }
  // console.log("URL >> ", url);

  axios({
    url: encodeURI(url),
    method: 'get',
    headers: {
      client_id: '607e3016889f431fb8020693311016c9',
      client_secret: '60bbcdcD722D411B88cBb72C8246a22F',
    },
  })
    .then(async (response) => {
      var res = response.data.skus.hits
      console.log(response.data)
      if (res.length > 0) {
        for (var i = 0; i < res.length; i++) {
          var insert_query = {}

          insert_query.site_url = site_url

          insert_query.product_id = res[i].productId
          //console.log("SnerksName:", insert_query.product_id);
          insert_query.product_img = res[i].image[0].contentUrl
          local_img = 'images/' + new Date().getTime() + '.jpg'
          try {
            await downloadImage(insert_query.product_img, local_img)
            insert_query.product_local_img = local_img
          } catch (err) {
	    console.log(err)
            continue
          }
          insert_query.product_local_img = local_img
          insert_query.product_name = res[i].name
          insert_query.product_comment = res[i].disambiguatingDescription
          insert_query.category = ''

          insert_query.brand = loui_brand.id

          insert_query.season_ = ''
          insert_query.theme_ = ''
          insert_query.size_color = res[i].color
          insert_query.delivery = ''
          insert_query.deadline = new Date()
          insert_query.place = ''
          insert_query.shop_name_ = 'LOUIS VUITTON'
          insert_query.shipping_place = ''

          var price = res[i].offers.priceSpecification[0].price
            .replace('¥', '')
            .replace(',', '')

          //console.log(price);
          insert_query.product_price = price
          insert_query.normal_pirce_ = price
          insert_query.tariff_ = ''
          insert_query.exhibition_memo_ = ''
          insert_query.purchase_memo_ = ''
          insert_query.price_type = 'JPY'
          var sneak = new SneakersInfo(insert_query)
          sneak.save_data()
        }

        // sn_now_page++

        // SneakersGetData(sn_now_page)
      }
    })
    .catch((err) => {
      console.log(
        '============================Update data Failed!=======================\n',
        err,
      )
    })
}

exports.changeInfo = (req, res) => {}

exports.getInfo = async (req, res) => {
  try {
    if (req.query.sel > 0) {
      user_id = req.query.sel
      keyword = req.query.keyword
      loui_brand = await Brand.findOne({ where: { name: 'Louis Vuitton' } })
      if (loui_brand) {
      } else {
        loui_brand = await Brand.create({ name: 'Louis Vuitton' })
      }
      // if (req.query.min_price > 0) min_price = req.query.min_price

      // if (req.query.max_price > 0) max_price = req.query.max_price
      sn_now_page = 0
      index = 0
      SneakersGetData(sn_now_page)
    } else {
      console.log('Sel is 0!')
    }
  } catch (error) {
    console.log('Error loui getInfo!', error)
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
      console.log('exhibit in loui error: ', err)
      res.status(500).json({ success: false, error: err })
    })
}
