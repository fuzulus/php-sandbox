DOCKER_COMPOSE = docker compose -f docker/docker-compose.yaml -f docker/docker-compose.override.yaml

start:
	$(DOCKER_COMPOSE) up -d
stop:
	$(DOCKER_COMPOSE) stop
ssh-php:
	$(DOCKER_COMPOSE) exec php bash
ssh-nginx:
	$(DOCKER_COMPOSE) exec nginx bash
ssh-db:
	$(DOCKER_COMPOSE) exec db bash