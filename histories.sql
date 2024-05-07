CREATE TABLE Histories (
    id INT PRIMARY KEY AUTO_INCREMENT,
    username VARCHAR(200),
    amount DOUBLE,
    country VARCHAR(200),
    active TINYINT(1),
    datetime DATETIME
);