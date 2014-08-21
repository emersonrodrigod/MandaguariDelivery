/*Create table USER*/
CREATE TABLE IF NOT EXISTS `user`(
    id int not null auto_increment primary key,
    `name` varchar(255) not null,
    email varchar(255) not null,
    password varchar(255) not null,
    role varchar(100) not null default 'user',
    unique(email)
);

/*Create table Area*/
CREATE TABLE IF NOT EXISTS area (
    id int not null auto_increment primary key,
    `name` varchar(255) not null,
    enable int not null default 1
);

/*Create table Category*/
CREATE TABLE IF NOT EXISTS category(
    id int not null auto_increment primary key,
    `name` varchar(255) not null,
    enable int not null default 1,
    id_parent int default null,
    id_area int not null,
    foreign key(id_area) references area(id)
);

alter table category add constraint fk_category_category foreign key(id_parent) references category(id);