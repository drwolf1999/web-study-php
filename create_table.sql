create table todos (
    title           VARCHAR (10) NOT NULL,
    description     VARCHAR (1000) NOT NULL,
    do              TINYINT NOT NULL
) ENGINE=InnoDB DEFAULT CHARACTER SET=utf8;