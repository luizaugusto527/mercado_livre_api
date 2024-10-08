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
### Integração com o Mercado Livre
Para realizar a integração com o mercado livre foram feitas as etapas a seguir
1. Criar a conta no mercado livre
2. Apos a conta ser criada acesse o link para criar uma nova API clicando [aqui](https://developers.mercadolivre.com.br/devcenter)
Todas as infromações sobre como criar a conta pode ser vista clicando [aqui](https://developers.mercadolivre.com.br/pt_br/crie-uma-aplicacao-no-mercado-livre)

 Após criar a aplicação guarde as informações do ID do aplicativo, cheve secreta e URIs de redirect
4. Com as informações em mãos, acesse o link
~~~php
   https://auth.mercadolivre.com.br/authorization?response_type=code&client_id=SEU_API_ID&redirect_uri=SUA_URI_REDIRECT
~~~
Com isso você será redirecionado para uma página do mercado livre onde é necesário dar a permissão de acesso
![image](https://github.com/user-attachments/assets/71003adf-fbc6-45d1-a83b-6ab033ea5553)

Ao clicar em autorizar você será redirecionado para a página da url de redirect com o code, exemplo:
https://localhost.com/redirect?code=TG-61828b7fffcc9a001b4bc890-314029626
Neste exemplo o code é TG-61828b7fffcc9a001b4bc890-314029626

5. Trocando o Code por um Token
   Com o code em mãos basta fazer uma requisição ao mercado livre para pegar o token e o refresh token

   Exemplo que requisição

    ~~~php
    $curl = curl_init();
    curl_setopt_array($curl, array(
    CURLOPT_URL => 'https://api.mercadolibre.com/oauth/token',
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => '',
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 0,
    CURLOPT_FOLLOWLOCATION => true,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => 'POST',
    CURLOPT_POSTFIELDS => 'grant_type=authorization_code&client_id=SEU_ID_CLIENT&client_secret=SUA_CHAVE_SECRETA&code=CODE&redirect_uri=SUA_URL_REDIRECT',
    CURLOPT_HTTPHEADER => array(
    'accept: application/json',
    'content-type: application/x-www-form-urlencoded'
     ),
    ));
    $response = curl_exec($curl);
    curl_close($curl);
    echo $response;
    ~~~~
    

Com isso você terá essa resposta
~~~json
{
    "access_token": "APP_USR-1743588130245622-100809-b71613a461e875541f66ef429b9fd00a-171164521",
    "token_type": "Bearer",
    "expires_in": 21600,
    "scope": "offline_access read write",
    "user_id": 171164521,
    "refresh_token": "TG-6705328eda61f700015ffb5a-171164521"
}
~~~
Com o token e o refresh_token em mãos basta rodar a query no banco de dados

~~~sql
INSERT INTO access_tokens (token, refresh_token, expires_at) 
VALUES (
    'SEU_TOKEN', 
    'SEU_REFRESH_TOKEN', 
    DATE_ADD(NOW(), INTERVAL 6 HOUR)
);
~~~
**OBS:** O token do mercado livre expira a cada 6 horas, portando a aplicação já está propramada para buscar um novo token a cada 6 horas portando o passo 6 só precisa ser feito uma vez e o sistema buscará automaticamente o token

6. Vá no arquivo .env e coloque o ID da aplicação na variável MERCADO_LIVRE_CLIENT_ID a chave secreta na variável MERCADO_LIVRE_CLIENT_SECRET e a url de redirecionamento na variável MERCADO_LIVRE_REDIRECT_URI 


