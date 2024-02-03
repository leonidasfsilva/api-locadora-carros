# API para locadora de carros
Projeto esboço para locadora de veículos baseado em **[Laravel 10 + Docker + MySQL]**


## Configurando o projeto
Clone o projeto para o seu localhost
```sh
git clone https://github.com/leonidasfsilva/api-locadora-carros.git api-carros
```
Acesse a pasta do projeto
```sh
cd api-carros
```


Crie o arquivo .env copiando a partir de exemplo
```sh
cp .env.example .env
```


Atualize essas variáveis de ambiente no arquivo .env
```dosini
APP_NAME="API Carros"
APP_URL=http://localhost:8989

DB_CONNECTION=mysql
DB_HOST=mysql
DB_PORT=3306
DB_DATABASE=nome_database
DB_USERNAME=nome_usuario
DB_PASSWORD=senha_database

CACHE_DRIVER=redis
QUEUE_CONNECTION=redis
SESSION_DRIVER=redis

REDIS_HOST=redis
REDIS_PASSWORD=null
REDIS_PORT=6379
```


Suba os containers do projeto
```sh
docker-compose up -d
```

Acesse o container do projeto
```sh
docker-compose exec -it app bash
```
Instale as dependências do projeto
```sh
composer install
```
Gere a key do projeto
```sh
php artisan key:generate
```
Rode as *migrations* do Laravel para criar as tabelas
```sh
php artisan migrate
```
Caso queira popular as tabelas, rode as *Seeders* do Laravel
```sh
php artisan db:seed
```

## Acessando os endpoints da API


### Veículos
-----
**[GET]**
http://localhost:8989/api/cars - lista todos os veículos cadastrados

**[GET]**
http://localhost:8989/api/cars/details/**{id}** - lista os dados de um veículo **(id do veículo deve ser informado na URL)**

**[POST]**
http://localhost:8989/api/cars/add - cadastra um novo veículo, abaixo a exemplificação do json enviado na requisição
```sh
{
	"model": "Ecosport",
	"brand": "Ford",
	"plate": "JPL4I96"
}
```

**[PUT]**
http://localhost:8989/api/cars/edit/**{id}** - atualiza os dados de um veículo **(id do veículo deve ser informado na URL)**, abaixo a exemplificação do json enviado na requisição
```sh
{
	"model": "Compass",
	"brand": "Jeep",
	"plate": "LLL3J85"
}
```

**[DEL]**
http://localhost:8989/api/cars/remove/**{id}** - remove o cadastro de um veículo **(id do veículo deve ser informado na URL)**



### Usuários
-----
**[GET]**
http://localhost:8989/api/users - lista todos os usuários cadastrados

**[GET]**
http://localhost:8989/api/users/details/**{id}** - lista os dados de um usuário **(id do usuário deve ser informado na URL)**

**[POST]**
http://localhost:8989/api/users/add - cadastra um novo usuário, abaixo a exemplificação do json enviado na requisição
```sh
{
	"name": "Nome Sobrenome",
	"email": "email@exemplo.com"
}
```

**[PUT]**
http://localhost:8989/api/users/edit/**{id}** - atualiza os dados de um usuário **(id do usuário deve ser informado na URL)**, abaixo a exemplificação do json enviado na requisição
```sh
{
	"name": "Nome Sobrenome",
	"email": "novoemail@exemplo.com"
}
```

**[DEL]**
http://localhost:8989/api/users/remove/**{id}** - remove o cadastro de um usuário **(id do usuário deve ser informado na URL)**


### Aluguéis
-----
**[GET]**
http://localhost:8989/api/rents/user/{id} - lista todos os veículos alugados por um usuário **(id do usuário deve ser informado na URL)**


**[POST]**
http://localhost:8989/api/rents/add - registra um novo aluguel de um veículo para um usuário, abaixo a exemplificação do json enviado na requisição
```sh
{
	"id_user": 4,
	"id_car": 11
}
```

**[POST]**
http://localhost:8989/api/rents/return - remove o registro de aluguel de um veículo de um usuário
```sh
{
	"id_user": 4,
	"id_car": 11
}
```


