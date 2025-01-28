CREATE DATABASE IF NOT EXISTS registered;
CREATE USER IF NOT EXISTS 'ashwani'@'localhost' IDENTIFIED BY 'ashwani';
GRANT ALL PRIVILEGES ON registered.* TO 'ashwani'@'localhost';
FLUSH PRIVILEGES;
