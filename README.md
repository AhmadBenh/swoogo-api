## Welcome!!

This is a super powerful (and simple) implementation of a new command for Laravel. 

The command: `php artisan swoogo:stats`

You will notice a lot of Laravel features missing, that is because I have used the Lumen microframework, based on Laravel. 

The application has been built using a Repository Pattern and a Service-Oriented Architecture.

---
### Commands

Now to the fun part! 

To run the application, clone the repository and run the following commands in the root directory of the application.

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

---

### How could it be improved?

- The main thing that could be improved is error handling. I tried to apply it on the go but it requires careful planning so the tests can work.

- Because of this simple fact, I did not implement tests since I always start by testing the failure conditions.
 > Tests would handle failures conditions, CRUD responses and API responses.

- I did not understand the purpose of option -a. Should it be computing the mean, median and mode of the averages or from the titles counts? The aggregate top tens should be mixed or should it only display the top ten with the higher count?