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
// var category = 'all'

const site_url = 'https://www.goat.com/'

var category_list = [
  'basketball',
  'boots',
  'cheats',
  'lifestyle',
  'running',
  'sandals',
  'skateboarding',
]
var brand_list = [
  '1017 alyx 9sm',
  '11 by boris bidjan saberi',
  '361 degrees',
  'acne studios',
  'adidas',
  'air jordan',
  'alexander mcqueen',
  'alife',
  'ambush',
  'amiri',
  'and1',
  'anta',
  'apc',
  'asics',
  'balenciaga',
  'balmain',
  'bape',
  'big baller brand',
  'billionaire boys club',
  'birkenstock',
  'bottega veneta',
  'brandblack',
  'brooks',
  'burberry',
  'buscemi',
  'calvin klein',
  'casbia',
  'celine',
  'champion',
  'chanel',
  'chloe',
  'christian louboutin',
  'circa',
  'clae',
  'clarks',
  'clearweather',
  'collegium',
  'comme des garcons',
  'common projects',
  'converse',
  'courreges',
  'creative recreation',
  'crocs',
  'curry brand',
  'dada',
  'danner',
  'dc',
  'diadora',
  'diamond supply co',
  'didu',
  'dior',
  'dolce gabbana',
  'dr martens',
  'ellesse',
  'etonic',
  'ewing',
  'fear of god',
  'fear of god essentials',
  'fendi',
  'fila',
  'filling pieces',
  'fracap',
  'fred perry',
  'giuseppe zanotti',
  'givenchy',
  'golden goose',
  'gucci',
  'hender scheme',
  'heron preston',
  'hoka one one',
  'huf',
  'hummel hive',
  'isabel marant',
  'jimmy choo',
  'john geiger',
  'junya watanabe',
  'just don',
  'k swiss',
  'kangaroos',
  'karhu',
  'lakai',
  'lanvin',
  'le coq sportif',
  'li ning',
  'loewe',
  'louis vuitton',
  'lugz',
  'mad foot',
  'maison margiela',
  'marine serre',
  'marni',
  'mcm',
  'mcq',
  'mercer amsterdam',
  'merrell',
  'midnight studios',
  'mizuno',
  'moncler',
  'mschf',
  'new balance',
  'nike',
  'off white',
  'on',
  'onitsuka tiger',
  'opening ceremony',
  'osiris',
  'other',
  'palm angels',
  'pf flyers',
  'polo ralph lauren',
  'pony',
  'prada',
  'puma',
  'raf simons',
  'reebok',
  'rhude',
  'rick owens',
  'royal elastics',
  'saint laurent',
  'salomon',
  'sandal boyz',
  'saucony',
  'starbury',
  'stella mccartney',
  'straye',
  'suicoke',
  'superga',
  'supra',
  'supreme',
  'tas',
  'the hundreds',
  'the north face',
  'timberland',
  'tommy hilfiger',
  'ubiq',
  'ugg',
  'umbro',
  'undefeated',
  'under armour',
  'valentino',
  'vans',
  'veja',
  'versace',
  'vetements',
  'visvim',
  'yeezy',
  'yohji yamamoto',
]
var sn_now_page = 1

class SneakersInfo {
  res = {}
  constructor(data) {
    this.res = data
  }
  save_data() {
    console.log('+++', this.res)
    Products.findAll({
      where: { product_id: this.res.product_id },
    })
      .then((data) => {
        if (data.length > 0) {
          Products.update(this.res, {
            where: { product_id: this.res.product_id },
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

function SneakersGetData(page, hitsPerPage, categoryId, brandId) {
  //https://www.goat.com/_next/data/niCKxKxK6G3ks8FlRUHMH/en-US/search.json?query=
  // var url =
  //   'https://ac.cnstrc.com/browse/group_id/' +
  //   category +
  //   '?c=ciojs-client-2.29.2&key=key_XT7bjdbvjgECO5d8&i=79856f44-5524-4cb6-b5ce-c05edd0da397&s=4&page=' +
  //   page +
  //   '&num_results_per_page=100&_dt=1661741501397'
  const category = category_list[categoryId],
    brand = brand_list[brandId]
  var url = `https://ac.cnstrc.com/browse/group_id/sneakers?c=ciojs-client-2.29.11&key=key_XT7bjdbvjgECO5d8&i=02e0825a-0633-4e63-946a-29b4d7bd57d8&s=6&page=${page}&num_results_per_page=${hitsPerPage}&filters%5Bbrand%5D=${brand
    .split(' ')
    .join(
      '%20',
    )}&filters%5Bweb_groups%5D=${category}&fmt_options%5Bhidden_fields%5D=gp_lowest_price_cents_57&fmt_options%5Bhidden_fields%5D=gp_instant_ship_lowest_price_cents_57&fmt_options%5Bhidden_facets%5D=gp_lowest_price_cents_57&fmt_options%5Bhidden_facets%5D=gp_instant_ship_lowest_price_cents_57`

  // if (max_price > 0) {
  //   url += '&filters[lowest_price_cents]=' + min_price + '-' + max_price
  // }
  console.log('URL >> ', url)

  axios
    .get(url, {})
    .then(async (response) => {
      var results = response.data.response.results
      console.log('response')
      if (results.length > 0) {
        for (var i = 0; i < results.length; i++) {
          var insert_query = {}

          insert_query.site_url = site_url

          insert_query.product_id = results[i].data.id
          //console.log("SnerksName:", insert_query.product_id);
          insert_query.product_img = results[i].data.image_url
          local_img = 'images/' + new Date().getTime() + '.jpg'
          await downloadImage(insert_query.product_img, local_img)
          insert_query.product_local_img = local_img
          insert_query.product_name = results[i].value
          insert_query.product_comment = ''
          insert_query.category = category

          insert_query.brand = brandId + 1

          insert_query.season_ = ''
          insert_query.theme_ = ''
          insert_query.size_color = results[i].data.color
          insert_query.delivery = ''
          insert_query.deadline = results[i].data.release_date
          insert_query.place = ''
          insert_query.shop_name_ = ''
          insert_query.shipping_place = ''
          insert_query.product_price = Math.round(
            (results[i].data.gp_lowest_price_cents_57 *
              results[i].data.lowest_price_cents_jpy) /
              results[i].data.lowest_price_cents /
              100,
          )
          insert_query.normal_pirce_ = Math.round(
            (results[i].data.gp_lowest_price_cents_57 *
              results[i].data.lowest_price_cents_jpy) /
              results[i].data.lowest_price_cents /
              100,
          )
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
      const categoryId = parseInt(req.query.category),
        brandId = parseInt(req.query.brand)

      if (req.query.min_price > 0) min_price = req.query.min_price

      if (req.query.max_price > 0) max_price = req.query.max_price

      SneakersGetData(sn_now_page, 24, categoryId, brandId)

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
