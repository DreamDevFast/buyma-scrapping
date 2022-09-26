const db = require('../models')
const axios = require('axios')
const Products = db.products
const Users = db.users
const Brand = db.brands
const ExhibitSettings = db.exhibitsettings
const { downloadImage, loginBuyma, exhibitBuyma } = require('../global')

var user_id = 1
const url =
  'https://hkoolreumf-dsn.algolia.net/1/indexes/Japan_Catalog_UNO/query?x-algolia-agent=Algolia%20for%20JavaScript%20(4.10.3)%3B%20Browser%20(lite)&x-algolia-api-key=3ca17c2ebda5c3b2cde891f9ed8ea40b&x-algolia-application-id=HKOOLREUMF'
const site_url = 'https://www.gucci.com/'
var gucci_brand
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

function SneakersGetData(page, hitsPerPage, query) {
  console.log('URL >> ', url)

  axios({
    method: 'POST',
    url,
    data: {
      query,
      offset: hitsPerPage * page,
      //   numericFilters: [['onlineDate <: 20230925']],
      length: hitsPerPage,
      facetFilters: [
        ['sellableIn:jp'],
        ['inStock:true', 'isVisibleWithoutStock:true', 'isStockInStore:true'],
      ],
      facets: [
        'categoryLevel1_ja',
        'categoryLevel2_ja',
        'categoryLevel3_ja',
        'combinedCategory3And4_ja',
        'material_ja',
        'lineName',
        'colour_ja',
        'size_ja',
      ],
      restrictSearchableAttributes: [
        'styleCode',
        'categoryLevel1_ja',
        'categoryLevel2_ja',
        'categoryLevel3_ja',
        'categoryLevel4_ja',
        'allCategories_ja',
        'name_ja',
        'lineName',
        'material_ja',
        'colour_ja',
        'size_ja',
        'sku',
      ],
      attributesToRetrieve: [
        'name_ja',
        'imgUrl',
        'altImgUrl',
        'price_jpy',
        'pdpUrl',
        'categoryLevel1_ja',
        'categoryLevel2_ja',
        'categoryLevel3_ja',
        'categoryLevel4_ja',
      ],
      attributesToHighlight: [],
      analyticsTags: ['jp', 'ja', 'jp-ja'],
    },
    headers: {
      'x-algolia-api-key': '64e489d5d73ec5bbc8ef0d7713096fba',
      'x-algolia-application-id': 'KPGNQ6FJI9',
      'Content-Type': 'application/x-www-form-urlencoded',
    },
  })
    .then(async (response) => {
      console.log(response.data)
      const hits = response.data.hits

      for (var i = 0; i < hits.length; i++) {
        var insert_query = {}

        insert_query.site_url = site_url

        insert_query.product_id = hits[i].objectID
        //console.log("SnerksName:", insert_query.product_id);
        insert_query.product_img =
          'https:' +
          hits[i].imgUrl.replace('$format$', 'White_South_0_160_470x470')
        local_img = 'images/' + new Date().getTime() + '.jpg'
        await downloadImage(insert_query.product_img, local_img)
        insert_query.product_local_img = local_img
        insert_query.product_name = hits[i].name_ja
        insert_query.product_comment = hits[i].description
        insert_query.category =
          hits[i].categoryLevel1_ja.join('/') +
          hits[i].categoryLevel2_ja +
          hits[i].categoryLevel3_ja

        insert_query.brand = gucci_brand.id

        insert_query.season_ = ''
        insert_query.theme_ = ''
        insert_query.size_color = ''
        insert_query.delivery = ''
        insert_query.deadline = new Date()
        insert_query.place = ''
        insert_query.shop_name_ = ''
        insert_query.shipping_place = ''
        insert_query.product_price = hits[i].price_jpy
        insert_query.normal_pirce_ = hits[i].price_jpy
        insert_query.tariff_ = ''
        insert_query.exhibition_memo_ = ''
        insert_query.purchase_memo_ = ''
        insert_query.price_type = 'JPY'

        var sneak = new SneakersInfo(insert_query)
        await sneak.save_data()
      }
      //console.log("++++++++++++++++++++++++++++++++++++++++++++++++++++++", page);
      //   page++

      //   SneakersGetData(page, hitsPerPage, query)
    })
    .catch((err) => {
      console.log('Update data Failed!: ', err)
    })
}

const getInfo = async (req, res) => {
  try {
    if (req.query.sel > 0) {
      user_id = req.query.sel
      const keyword = req.query.keyword
      gucci_brand = await Brand.findOne({ where: { name: 'GUCCI' } })
      if (gucci_brand) {
      } else {
        gucci_brand = await Brand.create({ name: 'GUCCI' })
      }
      SneakersGetData(0, 25, keyword)
    }
    res.status(200).json({ success: true })
  } catch (err) {
    console.log('get info error in gucci: ', err)
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
      console.log('exhibit in gucci error: ', err)
      res.status(500).json({ success: false, error: err })
    })
}
module.exports = {
  getInfo,
  exhibit,
}
