module.exports = (sequelize, Sequelize) => {
  const competitionList = sequelize.define("competitions", {
    user_id: {
      type: Sequelize.INTEGER
    },
    rakuten_list: {
      type: Sequelize.STRING
    },
    yahoo_list: {
      type: Sequelize.STRING
    },  

  },
  { 
    timestamps: false
  });
  return competitionList;
};