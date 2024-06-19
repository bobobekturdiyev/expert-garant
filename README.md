## Expert-Garant Task

First you need to migrate to make all tables
```shell
php artisan make:migrate
```

Then you may run seeder to store fake data to the table
```shell
php artisan make:migrate
```

There are two endpoints

PUT: documents/{id}

DELETE: documents/{id}

## MAIL
Sending mail takes time. That's why I have used queue job. It means, JSON response will be returned immediately when you request
to the API endpoint. In the background, server itself sends all mails.

In order to work, you need to run queue
```shell
php artisan queue:work
```

If ssl error occurs, then you may run ngrok.exe, and make the project public with ssl protocol.
Make sure to configure SMTP properly.

I tested it with GOOGLE SMTP. My .env snippet:
```dotenv
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=465
MAIL_USERNAME=MYEMAIL
MAIL_PASSWORD=MYPASSWORD
MAIL_ENCRYPTION=starttls
MAIL_FROM_ADDRESS="MYEMAIL"
MAIL_FROM_NAME="${APP_NAME}"
```
