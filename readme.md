# NHTSA-API

API built to consume response from  [`NHTSA original API`](https://one.nhtsa.gov/webapi/api/SafetyRatings/)

# Installation
- First, you need clone the repository:
```git clone https://github.com/marcoaraujojunior/nhtsa-api.git```
- Secondly, inside the repository directory copy the file .env.example to .env:
```cp .env.example .env```
- Then turn up the server:
```docker-compose up -d```
- To conclude install composer third-party packages:
```docker-compose exec nhtsa-api composer install```

# API Documentation:
To visualize and interact with the API’s resources go to
http://localhost:8080/swagger/

## License
MIT