# Docker

### Status
```
docker ps -a
```
`Exited (1)...` is broke

### Logs
```
docker logs <id_or_name_container>
```

### Restart
```
docker restart <id_or_name_container>
```
`$(docker ps -q)` restart all

### Stop & start
```
docker stop <name_container>
docker start <name_container>
```

### Recreate docker-compose
```
docker-compose up -d
```