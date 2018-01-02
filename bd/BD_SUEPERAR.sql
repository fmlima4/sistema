CREATE TABLE representantes (
 rcod int primary key NOT NULL AUTO_INCREMENT,
 rnome varchar(10) NOT NULL,
 email varchar(100) NOT NULL,
 fone int(10) NOT NULL,
 ativo int(10) NOT NULL,
 );

create table clientes(
cnome varchar(30) NOT NULL,
contato varchar(30) NOT NULL,
telefone varchar(30) NOT NULL,
emailc varchar(30) NOT NULL,
cidade varchar(30) NOT NULL,
representante int NOT NULL,
segmento varchar(30) NOT NULL,
cnpj varchar(30) NOT NULL,
ccod int primary key NOT NULL AUTO_INCREMENT,
CONSTRAINT fk_clientes FOREIGN KEY (representante) references representantes(rcod)
);

CREATE TABLE users (
 id tinyint(4) NOT NULL PRIMARY KEY AUTO_INCREMENT,
 username varchar(10) NOT NULL,
 password varchar(100) NOT NULL,
 cargo varchar(100) NOT NULL,
 int(10) NOT NULL
 );


create table comentarios(
comentdate date NOT NULL,
cliente int NOT NULL,
texto varchar(300) NOT NULL,
autor tinyint(4)  NOT NULL,
comcod int PRIMARY KEY NOT NULL AUTO_INCREMENT,
CONSTRAINT fk_comentario FOREIGN KEY (autor)references users(id)
);

create table produtos(
pnome varchar(30) NOT NULL,
descricao varchar(150) NOT NULL,
pcod int PRIMARY KEY NOT NULL AUTO_INCREMENT
);

create table orcamentos(
cliente int NOT NULL,
produto int,
autor tinyint(4)  NOT NULL,
orcdate date NOT NULL,
situacao varchar(30) NOT NULL,
numero varchar(30) NOT NULL,
valor float NOT NULL,
ativo int(10) NOT NULL,
ocod int primary key NOT NULL AUTO_INCREMENT,
CONSTRAINT fk_orcamentos FOREIGN KEY (cliente)references clientes(ccod),
CONSTRAINT fk_orcamentos1 FOREIGN KEY (produto)references produtos(pcod),
CONSTRAINT fk_comentario FOREIGN KEY (autor)references users(id)
);

create table eventos(
idevento int not null PRIMARY KEY AUTO_INCREMENT,
nomeEvento varchar(10) not null,
inicio date not null,
fim date not null,
descricaoEvento varchar(100) not null,
user varchar(10) not null,
importancia varchar(10) not null
)


