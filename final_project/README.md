### MVC Concept

User <-> View <-> Controller <-> Model

### to rebuild tailwind css

```bash
npx tailwindcss -i .\public\style\input.css -o .\public\style\style.css --watch
```

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