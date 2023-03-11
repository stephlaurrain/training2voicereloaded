FROM debian:bullseye-slim
ENV DEBIAN_FRONTEND noninteractive
ENV LSB_RELEASE=bullseye
ENV NODE_VERSION=18.15.0
ENV NODE_ARCH=node-v$NODE_VERSION-linux-x64.tar.xz

ENV ARCH=x64
ENV PHPMYADMIN_VERSION=5.2.1

ADD /install/sql/phpmyadmin.sql ./tmp/phpmyadmin.sql

WORKDIR "/root"
COPY /install/$NODEARCH /root
RUN apt-get update && apt-get install -y nano \
    apt-utils \    
    xz-utils \ 
    supervisor;

#node
ADD https://nodejs.org/dist/v$NODE_VERSION/$NODE_ARCH .
RUN tar -xJf "$NODE_ARCH" -C /usr/local --strip-components=1 --no-same-owner; \
  rm "$NODE_ARCH";

# MySQL Server
RUN apt install -y mariadb-server --no-install-recommends;  
RUN  apt install -y  wget \
    gnupg \
    ca-certificates \ 
    apt-transport-https \    
    #php 
    wget -q https://packages.sury.org/php/apt.gpg -O- | apt-key add -; \    
    echo "deb https://packages.sury.org/php/ $LSB_RELEASE main" | tee /etc/apt/sources.list.d/php.list; \
    apt-get update; \    
    apt install -y php7.4 php7.4-cli php7.4-common php7.4-curl php7.4-mbstring php7.4-mysql php7.4-xml php7.4-xdebug; \    
    apt install -y php7.4-common php7.4-mysql php7.4-gd php7.4-imap php7.4-json php7.4-curl php7.4-zip php7.4-xml php7.4-mbstring php7.4-bz2 php7.4-intl php7.4-gmp;
# PHPMyAdmin    
ADD https://files.phpmyadmin.net/phpMyAdmin/$PHPMYADMIN_VERSION/phpMyAdmin-$PHPMYADMIN_VERSION-all-languages.tar.gz .
RUN tar xvf phpMyAdmin-$PHPMYADMIN_VERSION-all-languages.tar.gz; \ 
    mv phpMyAdmin-$PHPMYADMIN_VERSION-all-languages /usr/share/phpmyadmin; \
    rm phpMyAdmin-$PHPMYADMIN_VERSION-all-languages.tar.gz; \ 
    chown -R www-data:www-data /usr/share/phpmyadmin; \
    mkdir -p /var/lib/phpmyadmin/tmp; \
    chown www-data:www-data /var/lib/phpmyadmin/tmp; 
#    /etc/init.d/mysql start; \
#    a2enmod rewrite; \
#    mkdir /root/trf; \
#    mysql -u root < /tmp/phpmyadmin.sql; \
#    rm /tmp/phpmyadmin.sql; \
#    mysql -u root < /usr/share/phpmyadmin/sql/create_tables.sql; \
#    a2enconf phpmyadmin.conf;

COPY /conf/supervisord.conf /etc/supervisor/conf.d
#clean
RUN  rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/*; \
     apt autoclean; 
RUN npm install -g yarn; \
    npm install -g nodemon; \
    npm update -g; 

EXPOSE 80

ENTRYPOINT ["/usr/bin/supervisord"]



