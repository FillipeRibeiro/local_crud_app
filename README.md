<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## Project Structure
A aplicação foi criada apenas como uma API utilizando Laravel.

O ambiente de execução é feita com Laravel Sail utilizando containers docker para o servidor da aplicação e banco de dados PostgreSql.

A arquitetura segue de maneira simples e fazendo uso de recursos nativos do laravel como Form Requests e Resources, mas também utilizando das camadas Actions e Service para execução da lógica de forma desvinculada a Controller.

## Setup

Para configurar o ambiente local é necessário ter instalado as ferramentas abaixo:

 - Composer (v2.7.* ou maior)
 - PHP (v8.2.* ou maior)
 - Docker

Primeiro passo é instalar as dependencias do projeto, para isso basta rodar o comando `composer install`.

Proximo passo é criar o arquivo `.env` na raiz do projeto e copiar todo o conteúdo de `.env.example` para o `.env`.

Agora é preciso criar/subir nossos containers com Laravel Sail, rodando o comando `sail up` ou `sail up -d` para rodar de modo desanexado.

Por fim vamos rodar as migrations no nosso container com o comando `sail artisan migrate`.

A sua aplicação já está pronta e funcionando.

## API Documentation

Os endpoints da API estão no arquivo `routes/api.php`.

Mas aqui vai um breve resumo de cada um deles:

GET /places -> Lista todos os locais e possuí filtros de name, state e city e paginação.

GET /places/{id} -> Lista local especifico.

POST /places -> Cria um local novo no request é preciso enviar name, state e city. (Olhar classe CreatePlaceRequest)

PATCH /places/{id} -> Atualiza um local no request pode ser enviado name, state e city. (Olhar classe UpdatePlaceRequest)

DELETE /places/{id} -> Deleta um local sendo necessário apenas um ID valido na url do request.
