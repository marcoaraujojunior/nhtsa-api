# NHTSA-API
---
[![Codacy Badge](https://api.codacy.com/project/badge/Grade/59d68735bdd74e09a13dce43b0692619)](https://www.codacy.com/app/marco-araujo-junior/nhtsa-api?utm_source=github.com&amp;utm_medium=referral&amp;utm_content=marcoaraujojunior/nhtsa-api&amp;utm_campaign=Badge_Grade) [![Codacy Badge](https://api.codacy.com/project/badge/Coverage/59d68735bdd74e09a13dce43b0692619)](https://www.codacy.com/app/marco-araujo-junior/nhtsa-api?utm_source=github.com&amp;utm_medium=referral&amp;utm_content=marcoaraujojunior/nhtsa-api&amp;utm_campaign=Badge_Coverage) [![Build Status](https://travis-ci.org/marcoaraujojunior/nhtsa-api.svg?branch=master)](https://travis-ci.org/marcoaraujojunior/nhtsa-api)

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
