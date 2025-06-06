
create table usuarios(
id int auto_increment primary key,
nome_completo varchar(250) not null,
email varchar(100) not null unique,
contato varchar(20),
data_registro date
);

use biblioteca;
create table emprestimos(
id int auto_increment primary key,
livro_emprestado varchar(100) not null,
nome_responsavel varchar (100) not null,
data_emprestimo date,
data_prevista_devolucao date,
data_real_devolucao date
);