CREATE DATABASE instapets
  CHARACTER SET = 'UTF8';


CREATE TABLE users (
  user_id SERIAL PRIMARY KEY NOT NULL,
  user_pseudo VARCHAR(50) NOT NULL,
  user_prenom VARCHAR(50) NOT NULL,
  user_nom VARCHAR(50) NOT NULL,
  user_email VARCHAR(50) NOT NULL,
  user_motdepasse VARCHAR(50) NOT NULL,
  user_date_naissance VARCHAR(50) NOT NULL
);

CREATE TABLE posts (
  post_id SERIAL PRIMARY KEY NOT NULL,
  user_id INTEGER NOT NULL,
  post_contenu VARCHAR(5000) NOT NULL
);

CREATE TABLE likes(
  like_od SERIAL PRIMARY KEY NOT NULL,
  post_id INTEGER NOT NULL,
  user_id INTEGER NOT NULL,
  is_liked BOOLEAN NOT NULL
)