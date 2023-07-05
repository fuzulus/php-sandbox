DOCKER_PATH=docker

cp $DOCKER_PATH/.env.dist $DOCKER_PATH/.env

cp $DOCKER_PATH/docker-compose.override.yaml.dist $DOCKER_PATH/docker-compose.override.yaml

docker compose -f $DOCKER_PATH/docker-compose.yaml -f $DOCKER_PATH/docker-compose.override.yaml up -d

docker compose -f $DOCKER_PATH/docker-compose.yaml -f $DOCKER_PATH/docker-compose.override.yaml exec php composer install