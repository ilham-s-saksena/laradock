# Laravel With Docker

## About
Running the Laravel App with Docker

## Requirements
- Docker

## Installation

1. Clone the repository to your local machine:

   ```bash
   git clone https://github.com/ilham-s-saksena/laradock.git
    ```

3. Change directory to laradock: 

    ```bash
    cd laradock
    ```

5. Run the initialization script 

    ```bash
    ./install.sh 
    ```
    
7. Start the docker compose service
    
    ```bash
    docker compose up --build -d
    ```

8. Open The Browser 
   <p align="center">Go To <a href="http://localhost:8088" target="_blank">localhost:8088</a></p>


## Development
if you want to run the migration or 'php artisan command', you only can run the command in the container,

### Docker Compose

To access each containers, you should have knowledge about interacting with docker and docker compose. E.g if you want to interact with php inside the Laravel container, you may want to run the command like:

```bash
docker exec laradock-task-php-1 php artisan migrate
```
