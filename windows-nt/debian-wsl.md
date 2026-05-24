## Install docker on debian (wsl2)
prerequisites:
- `sudo apt remove docker docker-engine docker.io containerd runc` remove old package
- `sudo apt update` update
- `sudo apt install -y ca-certificates curl` dependencies

- `sudo install -m 0755 -d /etc/apt/keyrings` create folder GPG Key
- `sudo curl -fsSL https://download.docker.com/linux/debian/gpg -o /etc/apt/keyrings/docker.asc` docker GPG Key
- `sudo chmod a+r /etc/apt/keyrings/docker.asc`
- add the repository to apt sources:
	```
	sudo tee /etc/apt/sources.list.d/docker.sources <<EOF
	Types: deb
	URIs: https://download.docker.com/linux/debian
	Suites: $(. /etc/os-release && echo "$VERSION_CODENAME")
	Components: stable
	Architectures: $(dpkg --print-architecture)
	Signed-By: /etc/apt/keyrings/docker.asc
	EOF
	```

- `sudo apt update`
- `sudo apt install -y docker-ce docker-ce-cli containerd.io docker-buildx-plugin docker-compose-plugin`
- `sudo usermod -aG docker $USER` docker without `sudo`
- `newgrp docker`

service:
```
$ sudo systemctl status docker
$ sudo systemctl start docker
```