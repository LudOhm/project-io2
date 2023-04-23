CREATE DATABASE instapets
  CHARACTER SET = 'UTF8';
  USE instapets; 

CREATE TABLE Users (
  user_id INTEGER PRIMARY KEY NOT NULL AUTO_INCREMENT,
  user_pseudo VARCHAR(50) NOT NULL,
  user_prenom VARCHAR(50) NOT NULL,
  user_nom VARCHAR(50) NOT NULL,
  user_naissance VARCHAR(50) NOT NULL,
  user_email VARCHAR(50) NOT NULL,
  user_motdepasse VARCHAR(50) NOT NULL,
  user_admin BOOLEAN NOT NULL,
  UNIQUE(user_pseudo, user_email)
);

CREATE TABLE Followings (
  id_suis INTEGER PRIMARY KEY NOT NULL AUTO_INCREMENT,
  user_id INTEGER NOT NULL,
  following_id INTEGER NOT NULL,
  FOREIGN KEY (user_id) REFERENCES Users(user_id),
  FOREIGN KEY (following_id) REFERENCES Users(user_id)
);

CREATE TABLE Followers (
  id_suivi INTEGER PRIMARY KEY NOT NULL AUTO_INCREMENT,
  user_id INTEGER NOT NULL,
  followers_id INTEGER NOT NULL,
  FOREIGN KEY (user_id) REFERENCES Users(user_id),
  FOREIGN KEY (followers_id) REFERENCES Users(user_id)
);

CREATE TABLE Posts (
  post_id INTEGER PRIMARY KEY NOT NULL AUTO_INCREMENT,
  user_id INTEGER NOT NULL,
  post_title VARCHAR(500) NOT NULL,
  post_contenu VARCHAR(5000) NOT NULL,
  post_picture LONGBLOB NOT NULL,
  FOREIGN KEY (user_id) REFERENCES Users(user_id)
);

CREATE TABLE Likes(
  like_id INTEGER PRIMARY KEY NOT NULL AUTO_INCREMENT,
  post_id INTEGER NOT NULL,
  user_id INTEGER NOT NULL,
  is_liked BOOLEAN NOT NULL,
  FOREIGN KEY (user_id) REFERENCES Users(user_id),
  FOREIGN KEY (post_id) REFERENCES Posts(post_id)
);
