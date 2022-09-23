module.exports = (sequelize, Sequelize) => {
  const brand = sequelize.define(
    'brands',
    {
      name: {
        type: Sequelize.STRING,
      },
    },
    {
      timestamps: false,
    },
  )
  return brand
}
