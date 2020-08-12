create schema course collate utf8mb4_general_ci;

create table course
(
    course_id int auto_increment
        primary key,
    title varchar(128) null,
    constraint title
        unique (title)
)
    charset=utf8;

create table role
(
    role_id int auto_increment
        primary key,
    title varchar(45) not null
);

create table user
(
    user_id int auto_increment
        primary key,
    name varchar(128) null,
    constraint name
        unique (name)
)
    charset=utf8;

create table member
(
    user_id int not null,
    course_id int not null,
    role int null,
    primary key (user_id, course_id),
    constraint member_ibfk_1
        foreign key (user_id) references user (user_id)
            on update cascade on delete cascade,
    constraint member_ibfk_2
        foreign key (course_id) references course (course_id)
            on update cascade on delete cascade
)
    charset=utf8;

create index course_id
    on member (course_id);

