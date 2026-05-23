# Docker
`Dockerfile` > `Image`  \
`docker-compose.yml` > Container1, Container2, ...

## Dockerfile (image)
instruction:
- `FROM` base image
- `WORKDIR` serve files
- `COPY` copy file into container
- `RUN` run linux command (building)
- `ENV`
- `EXPOSE` port
- `CMD` run linux command

### Commands
build: \
`docker build -t <image_name> .`

run: \
`docker run -p 3000:3000 <image_name>`
- `--name` set container name
- `-d` detach

test run: \
`docker run --rm -it <image_name> sh` remove image when exit

list volume: \
`docker volumne ls`

status: \
`docker ps -a`

remote container: \
`docker exec -it <container_name>`

## Docker compose
`docker-compose.yml` (service == container)

run: \
`docker-compose up -d`
- *`-d` Detached mode*
- *`--build` new image*

stop: \
`docker-compose down`

list: \
`docker-compose ps -a`

---

## Commands
logs: `docker logs <container_name_or_id>`
- *`-f` follow logs*

restart: `docker restart <container_id>`
- *`$(docker ps -q)` restart all*

stop&start: 
- `docker stop <container_id>`
- `docker start <container_id>`

run: `docker run <container_id>`
- *`-it` interactive terminal*

## List images

## Logs layer

## Troubleshoot

### Check disk
```
docker exec -it <container_name> df -h
```

### Shell
```
docker exec -it <container_name> sh
```

### Run php file
```
docker exec -it php8 php weadmin/index.php
```