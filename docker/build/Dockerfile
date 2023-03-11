FROM debian:bullseye-slim
ENV DEBIAN_FRONTEND noninteractive
ENV LSB_RELEASE=bullseye
ENV NODE_VERSION=18
ENV NODE_SUBVERSION=13.0
ENV ARCH=x64
ENV NODEARCH=node-v$NODE_VERSION.$NODE_SUBVERSION-linux-$ARCH.tar.xz
WORKDIR "/root"
COPY /install/$NODEARCH /root
RUN apt-get update && apt-get install -y nano \
    apt-utils \    
    xz-utils \ 
    supervisor;
RUN tar -xJf "$NODEARCH" -C /usr/local --strip-components=1 --no-same-owner; \
  rm "$NODEARCH";

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
COPY /conf/supervisord.conf /etc/supervisor/conf.d
#clean
RUN  rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/*; \
     apt autoclean; 
RUN npm install -g yarn; \
    npm install -g nodemon; \
    npm update -g; 
EXPOSE 80

ENTRYPOINT ["/usr/bin/supervisord"]



