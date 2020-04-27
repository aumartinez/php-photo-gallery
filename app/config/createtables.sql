-- Create tables

CREATE TABLE IF NOT EXISTS gallery (
  id INT NOT NULL AUTO_INCREMENT,
  user VARCHAR(50) NOT NULL,
  file_name VARCHAR(150) NOT NULL,
  file_path VARCHAR(150) NOT NULL,
  file_caption VARCHAR(255) NOT NULL,
  PRIMARY KEY (id),
  UNIQUE (file_path)
) ENGINE = MyISAM DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_unicode_ci AUTO_INCREMENT = 1;