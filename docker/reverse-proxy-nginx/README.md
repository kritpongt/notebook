### Create docker network
`docker network create webproxy`

### Start
`docker-compose up -d`

### Other projects
create: \
`docker network create <network_name>`

and then add the following in `docker-compose.yml`:
```
environment:
	VIRTUAL_HOST: <domain_name>
	LETSENCRYPT_HOST: <domain_name>

networks:
  default:
    external:
      name: <network_name>
	webproxy:
		external:
			name: webproxy
```