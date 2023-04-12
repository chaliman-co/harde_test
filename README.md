

## About This Application

This is a solution to the assessment by Harde Business School


## Setup
This application requires PHP version 8.2.4, node version 18 and composer version 2.5.4.  
To set up the laravel installation, execute the following:
- composer install
- rename the .env.example file to .env and edit the database url and credentials
- php artisan migrate (to set up database structure)


To set up the vue frontend, execute:
- npm install
- npm run build
## Run
To run the application, execute:
- php artisan serve
- visit the url printed on the console
## Test
To test the application, execute:
- php artisan test
## Certificate Error
You may encounter an error about curl certificates. Please refer to [this stack overflow question](https://stackoverflow.com/questions/55204210/curl-error-77-error-setting-certificate-verify-locations-cafile) for the solutions.
## Inquiries
Please feel free to contact me for any clarifications.