FROM debian:bullseye-slim
ENV DEBIAN_FRONTEND noninteractive
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
        
COPY /conf/supervisord.conf /etc/supervisor/conf.d
#clean
RUN  rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/*; \
     apt autoclean; 
RUN npm install -g yarn; \
    npm install -g nodemon; \
    npm update -g; 
EXPOSE 80

ENTRYPOINT ["/usr/bin/supervisord"]



