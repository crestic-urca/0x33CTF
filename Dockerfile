#1. on telecharge l'image php:7.4-apache comme base
FROM php:7.4-apache

#2. maj + installation git + libdev bz2 + libicu-dev + libzipdev + nano + unzip
RUN apt-get update -y \
 && apt-get install -y libbz2-dev libicu-dev libzip-dev nano unzip \
 # libsqlite3-dev
 && rm -rf /var/lib/apt/lists/*

#3. configuration apache
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf \
 && sed -ri -e 's!/var/www/!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf \
 && a2enmod rewrite headers \
 && echo "ServerName localhost" >> /etc/apache2/apache2.conf

ENV APACHE_DOCUMENT_ROOT=/var/www/html/public

#4. php extensions
RUN docker-php-ext-install -j$(nproc) \
	#bz2 \
	bcmath \
	#calendar \
	#iconv \
	#intl \
	# mbstring \ mbstring est deja inclu dans l'image php:7.4-apache
	opcache \
	pdo_mysql
    #pdo_sqlite # déjà présent
	#zip

#5. installation derniere version composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

#6. git clone
#RUN git clone https://gitlab-mmi.univ-reims.fr/desf0002/projet-ctf.git

#7. composer install
COPY composer.json composer.lock /var/www/html/
WORKDIR /var/www/html
RUN composer install --no-scripts --no-autoloader --no-cache --no-suggest
#--no-dev

#8. configuration du site
COPY --chown=www-data:www-data . /var/www/html/
RUN composer dump-autoload --optimize \
 && cp .env.docker .env \
 && touch database/database.sqlite \
 && chown www-data:www-data database/database.sqlite
 #remplissage de la BDD
RUN php artisan key:generate
RUN php artisan migrate:fresh
RUN php artisan db:seed

#9. configuration utilisateur
#ARG uid
#RUN useradd -G www-data,root -u $uid -d /home/devuser devuser
#RUN mkdir -p /home/devuser/.composer && \
#    chown -R devuser:devuser /home/devuser

COPY docker_init.sh /var/www/html/
RUN chmod u+x docker_init.sh
CMD ["./docker_init.sh"]

#10. expose le port utilise par le serveur
EXPOSE 80

#11. lance la commande apache2ctl start
#CMD ["apache2ctl","start"]
