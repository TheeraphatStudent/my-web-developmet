CREATE TABLE Users (
    id          INT AUTO_INCREMENT PRIMARY KEY,
    username    VARCHAR(255) NOT NULL,
    password    VARCHAR(255) NOT NULL,
    created     TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated     TIMESTAMP

);

CREATE TABLE Students (
    uniq_id     VARCHAR(255) PRIMARY KEY,
    stdid       VARCHAR(50),
    prefix      VARCHAR(5),
    full_name   VARCHAR(255),
    year        INT,
    grade       FLOAT,
    birthday    DATE,
    created     TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated     TIMESTAMP

)