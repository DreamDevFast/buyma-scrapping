module.exports = (sequelize, Sequelize) => {
  const exhibitsettings = sequelize.define(
    'exhibitsettings',
    {
      user_id: {
        type: Sequelize.INTEGER,
      },
      commission: {
        type: Sequelize.INTEGER,
      },
      comment: {
        type: Sequelize.STRING,
      },
    },
    {
      timestamps: false,
    },
  )
  return exhibitsettings
}
