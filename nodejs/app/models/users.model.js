module.exports = (sequelize, Sequelize) => {
  const users = sequelize.define(
    'users',
    {
      _token: {
        type: Sequelize.STRING,
      },
      email: {
        type: Sequelize.STRING,
      },
      email_verified_at: {
        type: Sequelize.STRING,
      },
      password: {
        type: Sequelize.STRING,
      },
      role: {
        type: Sequelize.STRING,
      },
      family_name: {
        type: Sequelize.STRING,
      },
      cell_phone: {
        type: Sequelize.STRING,
      },
      buyma_id: {
	type: Sequelize.STRING,
      },
      buyma_pwd: {
	type: Sequelize.STRING,
      },
      status: {
        type: Sequelize.STRING,
      },
    },
    {
      timestamps: false,
    },
  )
  return users
}
