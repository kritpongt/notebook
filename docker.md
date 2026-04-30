# Docker commands

### Status
```
docker ps -a
```
*`Exited (1)...` is down*

### Logs
```
docker logs -f <container_name_or_id>
```
*`-f` follow log*

### Restart
```
docker restart <container_name>
```
*`$(docker ps -q)` restart all*

### Stop & start
```
docker stop <container_name>
docker start <container_name>
```

## Docker Compose

### Run
```
docker-compose up -d
```
*`-d` Detached mode*

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