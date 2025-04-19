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

INSERT INTO pages (id, name, parent_id, path)
VALUES (1, 'Корень', 1, "root.htm"),       -- 1
        (2, 'Общежитие', 1, 'dormitory.htm'), -- 2
        (3, 'Направления', 1, 'specs.htm'),   -- 3
        (4, 'Строительство', 3, 'build.htm'), -- 4
        (5, 'Информатика', 3, 'it.htm');      -- 5