## Welcome!!

This is a super powerful (and simple) implementation of a new command for Laravel. 

The command: `php artisan swoogo:stats`

Due to a lack of time, you will appreciate that the error handling could be improved and that it is lacking tests. The option -a only retrieves the records from the database for now.
Due to the simplicity of the command and the time constraints I decided not to implement those features for now.

If implemented, the tests (in PHPUnit) would check the error handling, the correct retrieval of the Swoogo api data and the correct CRUD in DB.

Also, you will notice a lot of Laravel features missing, that is because I have used the Lumen microframework, based on Laravel.

---
Now to the fun part! 

To run the application, clone the repository and run the following commands in the root directory of the application.

**Commands**

Build the application: 
```docker-compose build```

Run the application in detached mode: 
```docker-compose up -d```

Get inside the php container:
```docker-compose exec app /bin/bash```

Run a migration:
```php artisan migrate```

Start playing with the command:
```php artisan swoogo:stats -e {optional} -k {optional} -s {optional} -a {optional}```