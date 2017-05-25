CREATE TABLE representantes (
 rcod int primary key NOT NULL AUTO_INCREMENT,
 rnome varchar(10) NOT NULL,
 email varchar(100) NOT NULL,
 fone int(10) NOT NULL,
 );

create table clientes(
nome varchar(30) NOT NULL,
contato varchar(30) NOT NULL,
telefone varchar(30) NOT NULL,
email varchar(30) NOT NULL,
ccod int primary key NOT NULL AUTO_INCREMENT
);

CREATE TABLE users (
 id tinyint(4) NOT NULL PRIMARY KEY AUTO_INCREMENT,
 username varchar(10) NOT NULL,
 password varchar(100) NOT NULL,
 );


create table comentarios(
dat varchar(30) NOT NULL,
cliente int NOT NULL,
texto varchar(300) NOT NULL,
autor tinyint(4)  NOT NULL,
comcod int PRIMARY KEY NOT NULL AUTO_INCREMENT,
CONSTRAINT fk_comentario FOREIGN KEY (autor)references users(id)
);

create table produtos(
nome varchar(30) NOT NULL,
descricao varchar(150) NOT NULL,
pcod int PRIMARY KEY NOT NULL AUTO_INCREMENT
);

create table orcamentos(
cliente int NOT NULL,
produto int NOT NULL,
orcdat varchar(30) NOT NULL,
situacao varchar(30) NOT NULL,
numero int NOT NULL,
ocod int primary key NOT NULL AUTO_INCREMENT,
CONSTRAINT fk_orcamentos FOREIGN KEY (cliente)references clientes(ccod),
CONSTRAINT fk_orcamentos1 FOREIGN KEY (produto)references produtos(pcod)
);

create table calendar(
t_id int not null PRIMARY KEY AUTO_INCREMENT,
dia varchar(10) not null,
hora varchar(5) not null,
cliente int not null,
descricao varchar(100),
CONSTRAINT fk_calendar FOREIGN KEY (cliente)references clientes(ccod)
)


