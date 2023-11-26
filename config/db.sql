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
  id int(11) PRIMARY KEY,
  project_name varchar(100) NOT NULL,
  description text ,
  start_date date ,
  deadline date ,
  status varchar(50) ,
  user_id int(11),
  FOREIGN key user_id REFERENCES user(id)
);

create table team (
    id int primary key auto_increment,
    team_name varchar(100),
    project_id int ,
    user_id int,
    FOREIGN key (project_id) REFERENCES project(id),
    FOREIGN key (user_id) REFERENCES user(id)
);





INSERT INTO role (id, 'role_name') VALUES
(13, 'Admin'),
(14, 'Manager'),
(15, 'Employee');


INSERT INTO role_user (role_id, user_id) VALUES
(13, 28),
(15, 7);


INSERT INTO user (id, 'username', 'email', 'Password') VALUES
(7, 'JohnDoe', 'john@example.com', 'password123'),
(28, 'said ', 'said@gmail.com', '123');
