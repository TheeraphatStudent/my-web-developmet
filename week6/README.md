### MVC Concept

User <-> View <-> Controller <-> Model

### to rebuild tailwind css

```
npx tailwindcss -i .\public\input.css -o .\public\style.css --watch
```

### when tailwind was not load

1. Check head was link to style.css
2. Disable cache on network
3. Restart workspace or computer
4. Docker rebuild

### to check file in directory

```
docker exec -it <container_name> ls -l /var/www/html/pages/php/submitted.php
```