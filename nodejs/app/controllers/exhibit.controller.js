const db = require('../models')
const axios = require('axios')
const Products = db.products
const Users = db.users
const Brand = db.brands
const ExhibitSettings = db.exhibitsettings
const { downloadImage, loginBuyma, exhibitBuyma } = require('../global')

const exhibit = async (req, res) => {
  const { user_id, ids } = req.body
  const user = await Users.findOne({
    where: { id: user_id },
  })
  try {
    user.status = 'exhibit'
    await user.save()
    res.status(200).json({ success: false })
    const exhibitsettings = await ExhibitSettings.findOne({
      where: { user_id },
    })
    await loginBuyma(user.buyma_id, user.buyma_pwd)

    for (let i = 0; i < ids.length; i++) {
      let product = await Products.findOne({
        where: { id: ids[i] },
        include: [
          {
            model: Brand,
            as: 'bd',
          },
        ],
      })
      console.log(product.bd.name)

      await exhibitBuyma(product, i !== 0, exhibitsettings)
    }
    

    user.status = 'init'
    await user.save()
  } catch (err) {
    console.log('exhibit in dior error: ', err)
    user.status = 'init'
    await user.save()
  }
}

module.exports = {
  exhibit,
}
