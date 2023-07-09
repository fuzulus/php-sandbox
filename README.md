# PHP Sandbox
<img alt="Release" src="https://img.shields.io/github/v/release/fuzulus/php-sandbox"> <img alt="PHP version" src="https://img.shields.io/badge/php-%5E8.1-blue"> <img alt="Symfony version" src="https://img.shields.io/badge/symfony-%5E6.3-violet">
<br>
<img alt="Commit activity" src="https://img.shields.io/github/commit-activity/m/fuzulus/php-sandbox">
<img alt="Last commit" src="https://img.shields.io/github/last-commit/fuzulus/php-sandbox">

This repository contains sandbox code for various PHP implementations (e.g. OAuth2, GraphQL, etc.).

## Implementations

* [x] OAuth2
* [ ] GraphQL
* [ ] Mutation testing using [Infection](https://infection.github.io/)
* [ ] Behavioral testing using [Behat](https://docs.behat.org/en/latest/)

## Prerequisites

1. An IDE (e.g. PhpStorm, VS Code, etc.)
2. Docker

## Software used - 2023-07-05

1. Docker Desktop 4.15.0 (93002)
2. Docker version 20.10.21, build baeda1f
3. PhpStorm 2022.3.1, Build #PS-223.8214.64, built on December 22, 2022

## Setup

1. `git clone git@github.com:fuzulus/php-sandbox.git`
2. Run `sh scripts/setup.sh` from the root of the repository. This script will:
   1. Setup Docker environment
   2. Setup Docker override
   3. Run Docker compose up
   4. Install all PHP dependencies via Composer
3. SSH into the PHP container to run all the below available commands: `docker compose exec php bash` or `docker compose exec php sh`

## Project description

The project is consisted of a small API for management of a [Pokémon Pokédex](https://www.pokemon.com/us/pokedex).

The Pokémon data is currently inside `src/Infrastructure/Driven/Persistence/Doctrine/Fixtures/Data/pokemon.json`.
In the future, a 3rd party API like [PokéAPI](https://pokeapi.co/docs/v2), might be used to expand the functionalities and tests.

### Directory structure

The directory structure is based on a combination of ([read for reference](https://herbertograca.com/2017/11/16/explicit-architecture-01-ddd-hexagonal-onion-clean-cqrs-how-i-put-it-all-together/)):

* hexagonal architecture 
* onion architecture 
* Domain-Driven Design
* Command Query Responsibility Segregation

```
.
├── Application
│   ├── Bus                        # Command/Query/Event bus interfaces
│   ├── Command                    # Command objects for making changes to the system
│   ├── CommandHandler             # Handler classes for command objects
│   ├── Query                      # Query objects for retrieving data from the system
│   ├── QueryHandler               # Handler interfaces and abstract classes for query handlers
│   ├── Repository                 # Read/write repository interfaces for entity management
│   └── Service                    # Various services executing business logic
├── Domain
│   ├── Common                     # Commonly used models between all classes (e.g. Clock for time)
│   ├── Pokedex                    # Pokédex related models
│   └── Pokemon                    # Pokémon related models
├── Infrastructure
│   ├── Driven
│   │   ├── Bus                    # Symfony messenger bus implementations of Application\Bus
│   │   ├── EventSubscriber        # Symfony event subscribers (e.g. ExceptionSubscriber)
│   │   ├── JsonApi                # JSON:API related implementations (e.g. ErrorHandler) 
│   │   ├── ParamConverter         # Symfony parameters conversion (e.g. PokemonId)
│   │   ├── Persistence            # Persistence related implementations (e.g. repositories, fixtures, migrations, etc.)
│   │   ├── QueryHandler           # Handler classes for query objects
│   │   ├── Request                # Request classes for endpoints in Driving
│   │   ├── Response               # Response classes for endpoints in Driving
│   │   └── Service                # Application\Service implementations
│   └── Driving
│       └── Common
│           └── v1
│               ├── ApiResponder   # Mapping for Undabot JSON:API library of objects being returned from the API
│               ├── Endpoint       # Symfony controllers, the entrance points of the application
│               └── Model          # Create/update/read models for endpoints
```

## Tests

This section describes the types of tests covered in the project, their goals and covered targets.
All types of tests have two commands: the Test command and the Coverage command.

The Test command runs all the tests inside a single testsuite.

The Coverage command runs all the tests inside a single testsuite and generates a coverage report.

Available test suites are:

* Unit
* Integration
* Functional

**NOTICE** 

It is recommended to run all the commands inside the PHP Docker container provided.
The container is equipped with all the dependencies necessary to execute the commands. 

### Unit

#### Test command

```shell
composer test:unit
```

#### Coverage command: 

```shell
composer test:coverage:unit
```

The Unit test suite covers mostly the Domain folder. It is a showcase of examples on how to test: entities, value objects, utility services, etc.
The Unit test suite uses mocks for various service dependencies and therefor does not test the integration of the services with the infrastructural layer (e.g. connection to the database).

### Integration

The Integration test suite covers mostly the Application folder. It showcases examples of testing: application level services, command/query handlers, etc.
The Integration test suite does not use mocks (unless connecting to a 3rd party API). It uses all the infrastructure services available to test their integration and cooperation. 

#### Test command

```shell
composer test:integration
```

#### Coverage command:

```shell
composer test:coverage:integration
```

### Functional

#### Test command

```shell
composer test:functional
```

#### Coverage command:

```shell
composer test:coverage:functional
```

The Functional test suite covers mostly the Infrastructure folder. It showcases examples of testing endpoints - the main entrance points to our application.
The Functional test suite does not use mocks (unless connecting to a 3rd party API). It uses all the infrastructure services available to validate that for a given input the endpoint will return an expected output.