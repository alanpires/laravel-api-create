# Use a imagem oficial do PHP
FROM php:8.0-fpm

# Defina a variável de ambiente para permitir o uso de plugins como root
ENV COMPOSER_ALLOW_SUPERUSER=1

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

# Limpe o cache do Composer e gere o autoload
RUN composer clear-cache && composer dump-autoload -o

# Instale as dependências do Composer
RUN composer install --no-dev --optimize-autoloader --verbose

# Adicione o script de implantação e torne-o executável
COPY deploy.sh /usr/local/bin/deploy.sh
RUN chmod +x /usr/local/bin/deploy.sh

# Exponha a porta que o servidor vai rodar
EXPOSE 9000

# Inicie o PHP-FPM
CMD ["php-fpm"]

# Execute o script de implantação após iniciar o contêiner
ENTRYPOINT ["/usr/local/bin/deploy.sh"]