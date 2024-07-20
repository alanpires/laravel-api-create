# Laravel API - Via CEP

Este é um projeto Laravel para consulta de endereços a partir de códigos de CEP utilizando a API ViaCEP. O projeto inclui uma API que permite buscar informações sobre endereços brasileiros.

## Funcionalidades

- Consulta de endereços por códigos de CEP.
- Documentação da API gerada com Swagger.

## Requisitos

- PHP 8.x
- Composer
- Laravel 9.x ou superior
- MySQL ou outro banco de dados suportado pelo Laravel

## Instalação

1. **Clone o repositório:**

    ```bash
    git clone https://github.com/alanpires/laravel-api-create.git
    ```

2. **Navegue até o diretório do projeto:**

    ```bash
    cd laravel-api-create
    ```

3. **Instale as dependências do Composer:**

    ```bash
    composer install
    ```

4. **Configure o ambiente:**

    Copie o arquivo `.env.example` para `.env` e ajuste as configurações de banco de dados e outras variáveis de ambiente conforme necessário:

    ```bash
    cp .env.example .env
    ```

5. **Gere a chave de aplicação:**

    ```bash
    php artisan key:generate
    ```

6. **Execute as migrações (se houver):**

    ```bash
    php artisan migrate
    ```

## Uso

Inicie o servidor de desenvolvimento Laravel:

```bash
php artisan serve
```

A API estará disponível em http://localhost:8000.

## Documentação da API

A documentação da API é gerada automaticamente e pode ser acessada através da interface Swagger UI:

[Documentação Swagger](http://localhost:8000/api/documentation)

## URL de Acesso

O projeto está disponível no seguinte endereço:

- https://laravel-teste-tecnico-via-cep.onrender.com

## Testes

Para rodar os testes automatizados, use:

```bash
php artisan test
```

## Licença
MIT.