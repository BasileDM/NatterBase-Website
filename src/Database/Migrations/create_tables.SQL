SET default_storage_engine = InnoDB;
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
  id_model INT NOT NULL,
  twitch_join_channel VARCHAR(255),
  id_platform INT NOT NULL,
  id_user INT NOT NULL,
  PRIMARY KEY(id_bot),
  FOREIGN KEY(id_model) REFERENCES Bot_Language_Models(id_model),
  FOREIGN KEY(id_platform) REFERENCES Bot_Platforms(id_platform),
  FOREIGN KEY(id_user) REFERENCES Users(id_user) ON DELETE CASCADE
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
  FOREIGN KEY(id_bot) REFERENCES Bots(id_bot) ON DELETE CASCADE
);
CREATE TABLE Relation_Bots_Features (
  id INT AUTO_INCREMENT PRIMARY KEY,
  id_bot INT,
  id_bot_feature INT,
  is_admin_override BOOLEAN,
  is_subscriber_override BOOLEAN,
  `trigger` VARCHAR(50),
  max_openai_message_length INT,
  open_ai_pre_prompt VARCHAR(255),
  dice_sides_number INT,
  delete_trigger VARCHAR(50),
  FOREIGN KEY (id_bot) REFERENCES Bots(id_bot) ON DELETE CASCADE,
  FOREIGN KEY (id_bot_feature) REFERENCES Bot_Features(id_bot_feature),
  UNIQUE (id_bot, `trigger`)
);
INSERT INTO User_Roles (name)
VALUES('user');
INSERT INTO User_Roles (name)
VALUES('admin');
INSERT INTO Users (
    mail,
    username,
    password_hash,
    is_activated,
    gdpr,
    twitch_id,
    twitch_username,
    id_role
  )
VALUES(
    'admin@admin.com',
    'admin',
    '$2y$10$tfBK4jlXBc.HDoBW3cWK2eoH76SJu.rUlTJQa0/JzIaAeE/yfNmLW',
    true,
    CURRENT_DATE,
    NULL,
    NULL,
    2
  );
INSERT INTO Bot_Feature_Categories (name)
VALUES('Game');
INSERT INTO Bot_Feature_Categories (name)
VALUES('AI');
INSERT INTO Bot_Feature_Categories (name)
VALUES('Text');

INSERT INTO Bot_Features (name, is_admin, is_subscriber, id_bot_feature_category)
VALUES('Dice throw', true, false, 1);
INSERT INTO Bot_Features (name, is_admin, is_subscriber, id_bot_feature_category)
VALUES('AI chat', true, false, 2);
INSERT INTO Bot_Features (name, is_admin, is_subscriber, id_bot_feature_category)
VALUES('Text command', true, false, 3);

INSERT INTO Bot_Language_Models (name)
VALUES('gpt-3.5-turbo');
INSERT INTO Bot_Platforms (name)
VALUES('Twitch');