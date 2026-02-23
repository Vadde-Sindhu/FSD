CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50),
    password VARCHAR(100)
);

INSERT INTO users (username, password)
VALUES ('admin', '12345');
