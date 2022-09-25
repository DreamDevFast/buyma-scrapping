module.exports = (sequelize, Sequelize) => {
  const products = sequelize.define(
    'products',
    {
      site_url: {
        type: Sequelize.STRING,
      },
      product_id: {
        type: Sequelize.STRING,
      },
      product_img: {
        type: Sequelize.STRING,
      },
      product_local_img: {
        type: Sequelize.STRING,
      },
      product_name: {
        type: Sequelize.STRING,
      },

      product_comment: {
        type: Sequelize.STRING,
      },
      category: {
        type: Sequelize.STRING,
      },
      season_: {
        type: Sequelize.STRING,
      },
      theme_: {
        type: Sequelize.STRING,
      },
      size_color: {
        type: Sequelize.STRING,
      },
      delivery: {
        type: Sequelize.STRING,
      },
      deadline: {
        type: Sequelize.DATE,
      },
      brand: {
        type: Sequelize.INTEGER,
        allowNull: false,
        references: {
          model: 'brands',
          key: 'id',
        },
      },
      place: {
        type: Sequelize.STRING,
      },
      shop_name_: {
        type: Sequelize.STRING,
      },
      shipping_place: {
        type: Sequelize.INTEGER,
      },
      product_price: {
        type: Sequelize.INTEGER,
      },
      normal_pirce_: {
        type: Sequelize.INTEGER,
      },
      tariff_: {
        type: Sequelize.STRING,
      },
      exhibition_memo_: {
        type: Sequelize.STRING,
      },
      price_type: {
        type: Sequelize.STRING,
      },

      purchase_memo_: {
        type: Sequelize.STRING,
      },
    },
    {
      timestamps: false,
    },
  )

  return products
}
