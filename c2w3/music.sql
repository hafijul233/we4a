create schema music collate utf8mb4_general_ci;

create table artists
(
    artist_id int unsigned auto_increment
        primary key,
    name varchar(255) not null
);

create table albums
(
    album_id int unsigned auto_increment
        primary key,
    name varchar(255) not null,
    artist_id int unsigned not null,
    constraint FK_album_1
        foreign key (artist_id) references artists (artist_id)
            on update cascade on delete cascade
);

create table genres
(
    genre_id int unsigned auto_increment
        primary key,
    name varchar(255) not null
);

create table tracks
(
    track_id int unsigned auto_increment
        primary key,
    name varchar(255) not null,
    length decimal(10,2) not null,
    rating decimal(3,2) not null,
    cont int unsigned not null,
    album_id int unsigned not null,
    genre_id int unsigned not null,
    constraint FK_tracks_1
        foreign key (album_id) references albums (album_id)
            on update cascade on delete cascade,
    constraint FK_tracks_2
        foreign key (genre_id) references genres (genre_id)
            on update cascade on delete cascade
);

