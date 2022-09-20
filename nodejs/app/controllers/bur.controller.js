const db = require('../models')
const axios = require('axios')
const Products = db.products
const Users = db.users
const { downloadImage, loginBuyma, exhibitBuyma } = require('../global')

var user_id = 1
var keyword = ''
var min_price = 0
var max_price = 0
var category = 'all'
const site_url = 'https://it.burberry.com/'
// https://it.burberry.com/web-api/pages/products?location=/cat1350882/cat3300042/cat8610034&pagePath=/l/nuovi-arrivi-bambino/&offset=1&limit=1&country=IT&language=en
var catergory_list = [
  {
    cat_name: '女性用',
    location:
      'location=/cat1350151/cat1350155/cat6910020&pagePath=/2/nuovi-arrivi-donna-novita/&language=jp&country=JP&limit=100',
  },
  {
    cat_name: '男性用',
    location:
      'location=/cat1350556/cat1350564/cat7170024&pagePath=/l/novita-per-uomo/&language=jp&country=JP&limit=100',
  },
  {
    cat_name: '子供用',
    location:
      'location=/cat1350882/cat3300042/cat8610034&pagePath=/l/nuovi-arrivi-bambino/&language=jp&country=JP&limit=100',
  },

  {
    cat_name: 'ジャケットとコート',
    location:
      'location=/cat1350556/cat8460076/cat8460086&pagePath=/l/giacche-e-cappotti-uomo/&language=jp&country=JP&limit=100',
  },
  {
    cat_name: '女性用バッグ',
    location:
      'location=/cat1350151/cat1350397/cat6720026&pagePath=/borse-donna/&language=jp&country=JP&limit=100',
  },
  {
    cat_name: '男性用バッグ',
    location:
      'location=/cat1350556/cat8800113/cat8800115&pagePath=/borse-uomo/&language=jp&country=JP&limit=100',
  },

  {
    cat_name: '女性用ギフトアイテム',
    location:
      'location=/cat1350151/cat1360092/cat4020120&pagePath=/articoli-da-regalo-donna/&language=jp&country=JP&limit=100',
  },
  {
    cat_name: '男性用ギフトアイテム',
    location:
      'location=/cat1350556/cat1360241/cat8040016&pagePath=/articoli-da-regalo-uomo/&language=jp&country=JP&limit=100',
  },
  {
    cat_name: '子供用ギフトアイテム',
    location:
      'location=/cat1350882/cat1360297/cat5980059&pagePath=/articoli-da-regalo-bambini/&language=jp&country=JP&limit=100',
  },
]

var sn_now_page = 1

class SneakersInfo {
  res = {}
  constructor(data) {
    this.res = data
  }
  save_data() {
    Products.findAll({
      where: { user_id: user_id, product_id: this.res.product_id },
    })
      .then((data) => {
        console.log('data', data)
        if (data.length > 0) {
          Products.update(this.res, {
            where: { user_id: user_id, product_id: this.res.product_id },
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
              console.log('Update data Okay!', this.res)
            })
            .catch((err) => {
              console.log('Update data Failed! -2')
            })
        }
      })
      .catch((err) => {
        console.log('Error get item_list!')
      })
  }
}

function SneakersGetData(page) {
  var url =
    'https://it.burberry.com/web-api/pages/products?' +
    catergory_list[category]['location'] +
    '&offset=' +
    (page - 1) * 100

  console.log('url>>>', url)

  axios
    .get(url, {})
    .then(async (response) => {
      var res = response.data.data.products

      if (res.length > 0) {
        for (var i = 0; i < res.length; i++) {
          var insert_query = {}

          insert_query.user_id = user_id
          insert_query.site_url = site_url

          insert_query.product_id = res[i].id
          // //console.log("SnerksName:", insert_query.product_id);
          insert_query.product_img =
            'https:' + res[i].media.defaults.image.imageDefault
          local_img = 'images/' + new Date().getTime() + '.jpg'
          await downloadImage(insert_query.product_img, local_img)
          insert_query.product_local_img = local_img
          insert_query.product_name = res[i].content.title
          insert_query.product_comment = res[i].content.description
          insert_query.category = catergory_list[category]['cat_name']

          insert_query.brand = ''

          insert_query.season_ = ''
          insert_query.theme_ = ''
          insert_query.size_color = ''
          insert_query.delivery = ''
          insert_query.deadline = ''
          insert_query.place = ''
          insert_query.shop_name_ = 'AGGIORNAMENTI'
          insert_query.shipping_place = ''

          // // var price = res[i].offers.priceSpecification[0].price.replace("€", "");
          // // price = price.replace(",", ".");

          // // //console.log(price);
          insert_query.product_price = res[i].price.current.value
          insert_query.normal_pirce_ = res[i].price.current.value
          insert_query.tariff_ = ''
          insert_query.exhibition_memo_ = ''
          insert_query.purchase_memo_ = ''
          insert_query.price_type = 'JPY'

          console.log(insert_query)
          var sneak = new SneakersInfo(insert_query)
          sneak.save_data()
        }

        // sn_now_page++

        // SneakersGetData(sn_now_page)
      }
    })
    .catch((err) => {
      // if(index < catergory_list[category]["code"].length - 1){
      // 	index++;
      // 	sn_now_page = 1;
      // 	SneakersGetData(sn_now_page);
      // }
      console.log('Update data Failed! 123', err)
    })
}

exports.changeInfo = (req, res) => {}

exports.getInfo = (req, res) => {
  console.log('Hi')
  try {
    if (req.query.sel > 0) {
      user_id = req.query.sel
      category = req.query.category

      if (req.query.min_price > 0) min_price = req.query.min_price

      if (req.query.max_price > 0) max_price = req.query.max_price
      sn_now_page = 1

      SneakersGetData(sn_now_page)
    } else {
      console.log('Sel is 0!')
    }
  } catch (error) {
    console.log('Error Bur getInfo!')
  }
}

exports.exhibit = (req, res) => {
  const { user_id } = req.body

  Products.findAll({
    where: { user_id, site_url },
  })
    .then(async (products) => {
      if (products.length) {
        if (products.length) {
          const user = await Users.findOne({
            where: { id: user_id },
          })
          user.status = 'exhibit'
          await user.save()
          res.status(200).json({ success: false })

          await loginBuyma()
          for (let i = 0; i < products.length; i++) {
            const success = await exhibitBuyma(products[i], i !== 0)
            if (success) products[i].status = 'exhibit'
            await products[i].save()
          }
          user.status = 'init'
          await user.save()
        }
      }
    })
    .catch((err) => {
      console.log('exhibit in bur error: ', err)
      res.status(500).json({ success: false, error: err })
    })
}
