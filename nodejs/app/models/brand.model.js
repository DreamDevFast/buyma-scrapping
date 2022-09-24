module.exports = (sequelize, Sequelize) => {
  const brands = sequelize.define(
    'brands',
    {
      id: {
        type: Sequelize.INTEGER,
        primaryKey: true,
        allowNull: false,
      },
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
