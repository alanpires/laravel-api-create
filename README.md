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

## Execução com Docker

1. Configure as Variáveis de Ambiente

Crie um arquivo .env e configure as variáveis de ambiente.

```bash
DB_CONNECTION=your_db_connection
DB_HOST=your_db_host
DB_PORT=your_db_port
DB_DATABASE=your_db_database
DB_USERNAME=your_db_username
DB_PASSWORD=your_db_password
```

2. Construa e Inicie os Contêineres

Execute o comando a seguir para construir a imagem Docker e iniciar os contêineres definidos no docker-compose.yml:

```bash
docker-compose up --build
```

Isso iniciará a aplicação e o banco de dados. A aplicação estará disponível em http://localhost:8000.

## Testes

Para rodar os testes automatizados, use:

```bash
php artisan test
```

## Licença
MIT.