CREATE DATABASE IF NOT EXISTS university_db;
USE university_db;

CREATE TABLE IF NOT EXISTS students (
    id          INT AUTO_INCREMENT PRIMARY KEY,
    name        VARCHAR(100) NOT NULL,
    roll_no     VARCHAR(20)  NOT NULL UNIQUE,
    department  VARCHAR(50)  NOT NULL,
    semester    INT          NOT NULL,
    email       VARCHAR(100) NOT NULL
);

INSERT INTO students (name, roll_no, department, semester, email) VALUES
('Ali Hassan',  'BSCS-001', 'Computer Science', 2, 'ali@example.com'),
('Sara Ahmed',  'BSCS-002', 'Computer Science', 2, 'sara@example.com'),
('Usman Tariq', 'BSCS-003', 'Computer Science', 4, 'usman@example.com');
