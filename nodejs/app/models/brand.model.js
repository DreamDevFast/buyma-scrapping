module.exports = (sequelize, Sequelize) => {
  const brands = sequelize.define(
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

  return brands
}
