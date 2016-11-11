# Swagger Editor NGINX

Image contains [nginx][link-nginx] web server, [Swagger Editor][link-swagger-editor] and backend for it to make it easy to **mount** your 
[OpenAPI][link-openapi-spec] API definitions [swagger yaml][link-swagger] into it.

- **Mounted `.yaml` will be auto saved as you type in editor.**

[![Build Status][travis-img]][link-travis]


## Permissions
*Your API definitions file to be mounted should have `0666` permissions so that docker user can write it.*

`chmod 0666 docs/swagger.yaml`

## Usage

Simplest way to use it is with `docker-compose`

- **Create your swagger.yaml or copy contents `docs/swagger.yaml` from this repo**

```sh
touch docs/swagger.yaml
```

- **Create `docker-compose.yaml`**

```yaml
version: '2'

services:

  swagger-editor:

    # For this example we use latest tag
    image: mkungla/swagger-editor-nginx:latest

    # Let's map in-container web server port 80 to your computers port 8005
    # So after running (docker-compose up) You can access swagger-editor from http://localhost:8005
    # You are free to choose any free port instead of 8005.
    ports:
      - "8005:80"

    # Lets attach your api definitions yaml file
    volumes:
      - ../docs/swagger.yaml:/var/www/localhost/htdocs/mount/swagger.yaml
```

- **Start docker container**

```sh
docker-compose up
```

- **Open your browser and navigate to http://localhost:8005**

*You should see swagger editor with your definitions file loaded*

- **Edit the file in editor and your changes are written to mounted file.**


<!-- swagger.io -->
[link-swagger]: http://swagger.io/
[link-swagger-editor]: http://swagger.io/swagger-editor/

<!-- Travis -->
[link-travis]: https://travis-ci.org/mkungla/swagger-editor-nginx
[travis-img]: https://travis-ci.org/mkungla/swagger-editor-nginx.svg?branch=master

<!-- Open API -->
[link-openapi-spec]: https://www.openapis.org/

<!-- nginx -->
[link-nginx]: http://nginx.org/
