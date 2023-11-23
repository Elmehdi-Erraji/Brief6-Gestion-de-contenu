CREATE DATABASE brief6;


create table role (
    id int primary key auto_increment,
    role_name varchar(50)
);
 
create table user (
    id int primary key auto_increment,
    username varchar(100) not null,
    email VARCHAR(100) not null,
    Password varchar(100)
);


create table role_user(
    role_id int ,
    user_id int , 
    FOREIGN key (role_id) REFERENCES role(id),
    FOREIGN key (user_id) REFERENCES user(id),
    PRIMARY key (role_id,user_id)
);

create table project (
    id int PRIMARY key auto_increment,
    project_name VARCHAR(100),
    client_name VARCHAR(100),
    start_date date ,
    deadline date ,
    statu varchar(50)
);

create table team (
    id int primary key auto_increment,
    team_name varchar(100),
    project_id int ,
    user_id int,
    FOREIGN key (project_id) REFERENCES project(id),
    FOREIGN key (user_id) REFERENCES user(id)
);