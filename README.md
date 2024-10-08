Desafio Destak
==============

### Resumo do projeto

#### O projeto consiste em criar uma aplicação que realizará a integração com a API do mercado livre e realizar o cadastro de um produto

### Instalação do projeto

#### Para realizar o projeto estou utilizando o Laragon, que pode ser baixado clicando (aqui)[https://laragon.org/download/)
Ao fazer a instalação do Laragon, basta clicar no terminal
![image](https://github.com/user-attachments/assets/22832b65-da09-4ab5-bb09-02a88169cf11]

Ao abrir o terminal digite os comandos:
~~~php
git clone https://github.com/luizaugusto527/mercado_livre_api/
cd mercado_livre_api/
~~~
Após ter clonado e entrado no diretório do projeto, basta instalar as dependências do projeto com o comando

~~~php
composer install
npm install
npm run build

~~~
Com as dependências instaladas, renomeie o arquivo .env.exemple para .env
Após isso precisamos criar o banco de dados e as tabelas usadas no projeto, para isso basta rodar o comando abaixo no terminal do laragon
~~~php
php artisan migrate

~~~

Todos os dados necessários estão em um arquivo sql que pode ser baixado clicando (aqui)[https://drive.google.com/file/d/1QNzg_dRMgl0tn5Ac33kCxdt-6oTwNl9N/view?usp=sharing]

### Conseguir as credencias de acesso para a API do mercado livre

#### \-------
