# Development

- `docker build -t mkungla/swagger-editor-nginx .`
- `docker run -it -p8005:80 mkungla/swagger-editor-nginx`

# Release
- `docker build -t mkungla/swagger-editor-nginx:latest -t mkungla/swagger-editor-nginx:0.9.0 .`