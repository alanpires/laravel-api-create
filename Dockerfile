# Defina a variável de ambiente para permitir o uso de plugins como root
ENV COMPOSER_ALLOW_SUPERUSER=1

# Use a imagem oficial do PHP
FROM php:8.1-fpm

# Instale dependências e extensões necessárias
RUN apt-get update && apt-get install -y \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    libzip-dev \
    unzip \
    libxml2-dev \
    git \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install gd zip pdo pdo_mysql \
    && pecl install xdebug \
    && docker-php-ext-enable xdebug

# Defina o diretório de trabalho
WORKDIR /var/www/html

# Copie os arquivos da aplicação para o contêiner
COPY . .

# Instale o Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Verifique a versão do Composer
RUN composer --version

# Instale as dependências do Composer
RUN composer install --no-dev --optimize-autoloader --verbose \
    || { echo 'Composer install failed'; exit 1; }

# Adicione o script de implantação e torne-o executável
COPY deploy.sh /usr/local/bin/deploy.sh
RUN chmod +x /usr/local/bin/deploy.sh

# Exponha a porta que o servidor vai rodar
EXPOSE 9000

# Inicie o PHP-FPM
CMD ["php-fpm"]

# Execute o script de implantação após iniciar o contêiner
ENTRYPOINT ["/usr/local/bin/deploy.sh"]