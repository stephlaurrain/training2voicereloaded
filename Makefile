all: build

PROJECT=opnclssrm
CONTAINER_NAME=training_devenv_ctn
IMAGE_NAME=training_devenv_img
DOCKER_USER=docker
REMOTE_ROOT=-w '/root'

start:
	service docker start

listctn: 
	docker container ls --all

listimg:
	docker image ls

rembash:
	docker exec -ti $(CONTAINER_NAME) bash

getip:
	docker inspect $(CONTAINER_NAME) | grep "IPAddress"

restartapache:
	docker exec  $(REMOTE_ROOT) $(CONTAINER_NAME) service apache2 restart

startapache:
	docker exec   $(REMOTE_ROOT) $(CONTAINER_NAME) service apache2 start

startmysql:
	docker exec  $(REMOTE_ROOT) $(CONTAINER_NAME) /etc/init.d/mysql start
 


stopall:
	docker stop $$(docker ps -q -a)

##cleaning
dri:
	docker rmi $$(docker images -q)

drmf: 
	docker rm -f $$(docker ps -q -a)

#clnall: stopall drmf dri prune

clnright:
	docker exec  $(REMOTE_ROOT) $(CONTAINER_NAME) bash -c '/root/install/clnright.sh'

init:
	docker exec  $(REMOTE_ROOT) $(CONTAINER_NAME) bash -c '/root/install/init.sh'

prune:
	docker image prune -a

builderprune:
	docker builder prune

#param make erase CONTAINER_NAME="mon_container" lancé par make erase CONTAINER_NAME="pro"
erase: stopall
	docker container rm $(CONTAINER_NAME) && docker image rm $$(docker images '*$(CONTAINER_NAME)*')

#GRUNT
gruntsync:
	docker exec  $(REMOTE_ROOT) $(CONTAINER_NAME) grunt sync


gruntprod:
	docker exec  $(REMOTE_ROOT) $(CONTAINER_NAME) grunt prod

gruntdev:
	docker exec  $(REMOTE_ROOT) $(CONTAINER_NAME) grunt dev 

gruntwatch:
	docker exec  $(REMOTE_ROOT) $(CONTAINER_NAME)grunt watch
  


#
# launch
build:
	docker-compose build

up:
	docker-compose up
upd: 
	docker-compose up -d

setpsswd:
	docker exec  $(REMOTE_ROOT)  $(CONTAINER_NAME) passwd docker

buildraw:
	docker build -t $(CONTAINER_NAME) ./docker/build

browser: 
	python3 browser.py
  

.FORCE:
