CREATE DATABASE infocenter_db;

USE infocenter_db;

CREATE TABLE pages(
    id        int          NOT NULL AUTO_INCREMENT,
    name      varchar(255) NOT NULL,
    parent_id int,
    path      varchar(255),
    PRIMARY KEY (id)
);

-- ALTER TABLE pages CONVERT TO CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

-- тестовые данные -- 
INSERT INTO pages (id, name, parent_id, path)
VALUES (1, 'Корень', 1, "root.htm"),       -- 1
        (2, 'Общежитие', 1, 'dormitory.htm'), -- 2
        (3, 'Направления', 1, 'specs.htm'),   -- 3
        (4, 'Строительство', 3, 'build.htm'), -- 4
        (5, 'Информатика', 3, 'it.htm');      -- 5

CREATE TABLE calls(
    id           int          NOT NULL AUTO_INCREMENT,
    phone_number varchar(16)  NOT NULL,
    full_name    varchar(255) NOT NULL,
    question     text         NOT NULL,
    source_page  int          NOT NULL,
    PRIMARY KEY (id)
)