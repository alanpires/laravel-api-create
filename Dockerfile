# Use a imagem oficial do PHP 8.2
FROM php:8.2-fpm

# Instale dependências e extensões necessárias
RUN apt-get update && apt-get install -y \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    libzip-dev \
    unzip \
    libxml2-dev \
    git \
    libpq-dev \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install gd zip pdo pdo_pgsql \
    && pecl install xdebug \
    && docker-php-ext-enable xdebug

# Defina o diretório de trabalho
WORKDIR /var/www

# Copie os arquivos da aplicação para o contêiner
COPY . .

# Instale o Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Defina a variável de ambiente para permitir plugins do Composer
ENV COMPOSER_ALLOW_SUPERUSER=1

# Verifique a versão do Composer
RUN composer --version

# Instale as dependências do Composer
RUN composer install --no-dev --optimize-autoloader --verbose \
    || { echo 'Composer install failed'; exit 1; }

# Exponha a porta que o servidor vai rodar
EXPOSE 8080

# Dê permissões de execução ao script de implantação
COPY deploy.sh /usr/local/bin/deploy.sh
RUN chmod +x /usr/local/bin/deploy.sh

# Configure o script de implantação como o ponto de entrada
ENTRYPOINT ["/usr/local/bin/deploy.sh"]

# Inicie o PHP-FPM
CMD ["php-fpm"]