CREATE DATABASE infocenter_db;

USE infocenter_db;

CREATE TABLE pages(
    id int NOT NULL AUTO_INCREMENT,
    name varchar(255) NOT NULL,
    parent_id int,
    path varchar(255),
    PRIMARY KEY (id)
);

ALTER TABLE pages CONVERT TO CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

INSERT INTO pages (name, parent_id, path)
VALUES ('Корень', 1, "root.htm"),       -- 1
        ('Общежитие', 1, 'dormitory.htm'), -- 2
        ('Направления', 1, 'specs.htm'),   -- 3
        ('Строительство', 3, 'build.htm'), -- 4
        ('Информатика', 3, 'it.htm');      -- 5