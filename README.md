# Oficina-2.0

O projeto tem por objetivo realizar o cadastro de orçamento de uma oficina, ou seja, o usuário poderá cadastrar um novo orçamento, deletar orçamento, pesquisar e atualizar um orçamento. Além disso, haverá filtros por intervalo de datas, vendedor e cliente de um orçamento. Além disso, é utilizado a arquitetura MVC para organização do código.

# Instalações para executar o projeto:

## Download Composer(Linux):

$ php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');"

$ php -r "if (hash_file('sha384', 'composer-setup.php') === 'a5c698ffe4b8e849a443b120cd5ba38043260d5c4023dbf93e1558871f1f07f58274fc6f4c93bcfd858c6bd0775cd8d1') { echo 'Installer verified'; } else { echo 'Installer corrupt'; unlink('composer-setup.php'); } echo PHP_EOL;"

$ php composer-setup.php

$ php -r "unlink('composer-setup.php');"

Para mais detalhes acessar link: https://getcomposer.org/download/

## Download Symfony(Linux):

$ wget https://get.symfony.com/cli/installer -O - | bash

Para mais detalhes acessar link: https://symfony.com/download

## Criação de banco:

Para este projeto foi utilizado o Doctrine ORM para mapear as entidades do sistemas em tabelas de banco de dados.

# Instalação do Doctrine:

 $ composer require symfony/orm-pack
 
 $ composer require --dev symfony/maker-bundle

# Configurando o banco de dados:

Neste projeto ulitizou-se o banco Mysql. As informações de conexão com o banco de dados são armazenadas em uma variável de ambiente chamada DATABASE_URL, presente no arquivo .env localizado na raiz do projeto, conforme demoonstrado abaixo, onde coloca-se o usuário do banco em db_user, senha em db_password e o nome da base de dados em db_name. 

DATABASE_URL="mysql://db_user:db_password@127.0.0.1:3306/db_name"

Após a configuração, o Doctrine irá criar o db_name dados db_name, conforme abaixo:

$ php bin/console doctrine:database:create

Para finalizar a criação da tabela no schema é necessário executar os comandos:

$ php bin/console make:migration

$ php bin/console doctrine:migrations:migrate

Para mais informações acessar link: https://symfony.com/doc/current/doctrine.html#installing-doctrine

## Instalações de pacotes utilizados no projeto:

Obs.: Se estiver utlizando Linux e for executar projeto como root utilize o comando a seguir:

    $ export COMPOSER_ALLOW_SUPERUSER=1; composer show;

$ composer require symfony/http-foundationcomposer

## Execução do projeto:

$ symfony server:start



















