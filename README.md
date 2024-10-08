Desafio Destak
==============

### Resumo do projeto

#### O projeto consiste em criar uma aplicação que realizará a integração com a API do mercado livre e realizar o cadastro de um produto

### Instalação do projeto

#### Para realizar o projeto estou utilizando o Laragon, que pode ser baixado clicando [clique aqui](https://laragon.org/download/)

Ao fazer a instalação do Laragon, basta clicar no terminal
![image](https://github.com/user-attachments/assets/e0274eb9-e40e-42ff-b71e-1e665cbc20ed)


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

Todos os dados necessários estão em um arquivo sql que pode ser baixado clicando [aqui](https://drive.google.com/file/d/1QNzg_dRMgl0tn5Ac33kCxdt-6oTwNl9N/view?usp=sharing)
Após baixar os dados, basta clicar no banco de dados
![image](https://github.com/user-attachments/assets/7cc9d7a5-fc5a-4be4-bca5-3c47c5b886b0)

E escolher o banco de dados "test_destak"
![image](https://github.com/user-attachments/assets/b72b5b54-b147-4dc0-8ba4-7173b4d5131d)

Agora basta ir no terminal do Laragon e digitar o comando
~~~php
php artisan serve

~~~
A aplicação será iniciada no endereço http://127.0.0.1:8000 e as credenciais de acesso são
email: admin@admin
senha:123456789
### Conseguir as credencias de acesso para a API do mercado livre

#### \-------
