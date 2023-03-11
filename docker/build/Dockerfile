FROM debian:bullseye
ENV DEBIAN_FRONTEND noninteractive
ENV LSB_RELEASE=bullseye
ENV NODE_VERSION=18.15.0
ENV NODE_ARCH=node-v$NODE_VERSION-linux-x64.tar.xz

ENV ARCH=x64
ENV PHPMYADMIN_VERSION=6.0+snapshot
ENV PHPMYADMIN_NAME=phpMyAdmin-$PHPMYADMIN_VERSION-english
#versions normales : phpMyAdmin
ENV PHPMYADMIN_DIR=snapshots

WORKDIR "/root"

# COPY /conf/phpmyadmin/phpmyadmin.conf .

RUN apt-get update && apt-get install -y nano mc \
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
# ADD https://files.phpmyadmin.net/$PHPMYADMIN_DIR/$PHPMYADMIN_VERSION/$PHPMYADMIN_NAME.tar.gz .
ADD https://files.phpmyadmin.net/$PHPMYADMIN_DIR/$PHPMYADMIN_NAME.tar.gz .
RUN tar xvf $PHPMYADMIN_NAME.tar.gz; \ 
    mv $PHPMYADMIN_NAME /usr/share/phpmyadmin; \
    rm $PHPMYADMIN_NAME.tar.gz; \     
    mkdir -p /var/lib/phpmyadmin/tmp; \
    chown www-data:www-data /var/lib/phpmyadmin/tmp; \
    mkdir /root/trf; \    
    /etc/init.d/mariadb start;  \
    a2enmod rewrite; \     
    a2enconf phpmyadmin.conf; \
    /etc/init.d/mariadb start;    
    # service mariadb start;
COPY /conf/phpmyadmin/config.inc.php /usr/share/phpmyadmin/config.inc.php
#droits
RUN chown -R www-data:www-data /usr/share/phpmyadmin; \
    chown -R www-data:www-data /var/www/html && chmod -R g+s /var/www/html;\
    chmod -R 777 /var/www/html;
COPY /conf/supervisord.conf /etc/supervisor/conf.d
#clean
RUN  rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/*; \
     apt autoclean; 
RUN npm install -g yarn; \
    npm install -g nodemon; \
    npm update -g; 
# faire make init
EXPOSE 80
ENTRYPOINT ["/usr/bin/supervisord"]
# CMD [ "/root/install/init.sh" ]


