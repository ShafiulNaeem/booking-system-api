# Booking Sysytem

## Instruction
- Install or update all required dependencies using Composer:
      ```
      composer update
      ```
- Install JWT package
   ```
   composer require tymon/jwt-auth
   php artisan jwt:secret
   ```
- Run Database Migrations: ``` php artisan migrate ```
- Seed the Database: ``` php artisan db:seed ```
- Configure .env file
   ```
    QUEUE_CONNECTION=database
    # mail
    MAIL_MAILER=smtp
    #MAIL_SCHEME=null
    MAIL_HOST=sandbox.smtp.mailtrap.io
    MAIL_PORT=2525
    MAIL_USERNAME=your_username
    MAIL_PASSWORD=your_password
    MAIL_ENCRYPTION=null
    MAIL_FROM_ADDRESS="hello@example.com"
    MAIL_FROM_NAME="${APP_NAME}"
   ```

- ### Testing Instructions:
    - To test all features, reset the database and run the tests: 
        ```
            php artisan migrate:fresh
            php artisan db:seed
            php artisan test
        ```
    - or Run Specific Test ``` php artisan test --filter=your_test_function```
- [Api info and postman collection] (https://github.com/ShafiulNaeem/booking-system-api/blob/master/booking%20system.postman_collection.json) 


