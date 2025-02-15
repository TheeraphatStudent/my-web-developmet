# Event management

PHP event management system

## MVC Concept

User <-> View <-> Controller <-> Model


### Php syntax

`<?php ?>` To create php structure
```
<?php 
echo "Hello World";

?>
```

`?> <?php` To create chide php process inside parent
```
<?php 
echo "Hello World";

    ?> 
        echo "This is an child!"

    <?php
?>
```

## To rebuild tailwind css

```bash
npx tailwindcss -i .\public\style\input.css -o .\public\style\style.css --watch
```

delay watch for 3 second

```bash
npx tailwindcss -i .\public\style\input.css -o .\public\style\style.css --watch --poll 3000
```

## Basic docker

### to check file in directory

```bash
docker exec -it <container_name> ls -l /var/www/html/pages/php/submitted.php
```

### to run docker

```bash
docker compose up -d
```

### to stop docker container

```bash
docker compose down
```

## Deploy with koyeb

1. Test docker image

```bash
docker run -p 8080:80 th33raphat/web-final_act-gate:latest
```

2. Pull to docker hub

```bash
docker build -t web-final_act-gate -f .\DockerFile . ;& docker tag web-final_act-gate th33raphat/web-final_act-gate:latest ;& docker push th33raphat/web-final_act-gate:latest
```

3. Go to koyeb and redeploy
