# API_RATP_SYMFONY

load csv file to database
requirements :
docker docker compose

Run the docker-compose

```bash
  docker-compose build
  docker-compose up -d
```

Log into the PHP container

```bash
  docker exec -it php8-sf6 bash
```


```bash
  symfony new new-project --full
  cd new-project
  symfony serve -d
```

Create an account (identical to your local session)

```bash
  adduser username
  chown username:username -R .
```

*application is available at http://127.0.0.1:8888*

database, :
```bash
  command symfony console CsvToDatabase
```


*You can also see database  in pgadmin http://127.0.0.1:5050*







