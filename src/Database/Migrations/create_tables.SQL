CREATE TABLE Bot_Feature_Categories(
  id_bot_feature_category INT AUTO_INCREMENT,
  name VARCHAR(50) NOT NULL,
  PRIMARY KEY(id_bot_feature_category),
  UNIQUE(name)
);
CREATE TABLE Bot_Platforms(
  id_platform INT AUTO_INCREMENT,
  name VARCHAR(50) NOT NULL,
  PRIMARY KEY(id_platform),
  UNIQUE(name)
);
CREATE TABLE Bot_Language_Models(
  id_model INT AUTO_INCREMENT,
  name VARCHAR(191) NOT NULL,
  PRIMARY KEY(id_model),
  UNIQUE(name)
);
CREATE TABLE User_Roles(
  id_role INT AUTO_INCREMENT,
  name VARCHAR(50),
  PRIMARY KEY(id_role)
);
CREATE TABLE Users(
  id_user INT AUTO_INCREMENT,
  mail VARCHAR(80) NOT NULL,
  username VARCHAR(50) NOT NULL,
  password_hash VARCHAR(255) NOT NULL,
  is_activated BOOLEAN NOT NULL,
  gdpr DATE NOT NULL,
  twitch_id VARCHAR(255),
  twitch_username VARCHAR(255),
  id_role INT NOT NULL,
  PRIMARY KEY(id_user),
  UNIQUE(mail),
  FOREIGN KEY(id_role) REFERENCES User_Roles(id_role)
);
CREATE TABLE Bots(
  id_bot INT AUTO_INCREMENT,
  name VARCHAR(50),
  creation_date DATETIME,
  cooldown_time INT,
  max_openai_message_length VARCHAR(50),
  id_model INT NOT NULL,
  id_platform INT NOT NULL,
  id_user INT NOT NULL,
  PRIMARY KEY(id_bot),
  FOREIGN KEY(id_model) REFERENCES Bot_Language_Models(id_model),
  FOREIGN KEY(id_platform) REFERENCES Bot_Platforms(id_platform),
  FOREIGN KEY(id_user) REFERENCES Users(id_user)
);
CREATE TABLE Bot_Features(
  id_bot_feature INT AUTO_INCREMENT,
  name VARCHAR(50),
  is_admin BOOLEAN NOT NULL,
  is_subscriber BOOLEAN NOT NULL,
  id_bot_feature_category INT NOT NULL,
  PRIMARY KEY(id_bot_feature),
  UNIQUE(name),
  FOREIGN KEY(id_bot_feature_category) REFERENCES Bot_Feature_Categories(id_bot_feature_category)
);
CREATE TABLE Bot_Commands(
  id_bot_command INT AUTO_INCREMENT,
  name VARCHAR(50) NOT NULL,
  text VARCHAR(255) NOT NULL,
  id_bot INT NOT NULL,
  PRIMARY KEY(id_bot_command),
  FOREIGN KEY(id_bot) REFERENCES Bots(id_bot)
);
CREATE TABLE Relation_Bots_Features(
  id_bot INT,
  id_bot_feature INT,
  is_admin_override BOOLEAN,
  is_subscriber_override BOOLEAN,
  PRIMARY KEY(id_bot, id_bot_feature),
  FOREIGN KEY(id_bot) REFERENCES Bots(id_bot),
  FOREIGN KEY(id_bot_feature) REFERENCES Bot_Features(id_bot_feature)
);