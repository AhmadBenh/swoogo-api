## Welcome!!

This is a super powerful (and simple) implementation of a new command for Laravel. 

The command: `php artisan swoogo:stats`

You will notice a lot of Laravel features missing, that is because I have used the Lumen microframework, based on Laravel. 

The application has been built using a Repository Pattern and a Service-Oriented Architecture.

---
### Commands

Now to the fun part! 

To run the application, clone the repository and run the following commands in the root directory of the application.
You can either add the env variables in the following format or pass them as options to the swoogo:stats command:
`SWOOGO_KEY="key"`
`SWOOGO_SECRET="secret"`

Build the application: 
```docker-compose build```

Run the application in detached mode: 
```docker-compose up -d```

Get inside the php container:
```docker-compose exec app /bin/bash```

Start playing with the command:
```php artisan swoogo:stats -e {optional} -k {optional} -s {optional} -a {optional}```

---

### How could it be improved?

- The main thing that could be improved is error handling. 

- Because of the missing correct error handling, I did not implement tests since I always start by testing the failure conditions.
 > Tests would handle failures conditions, CRUD responses and API responses.

- Comments/documentation can and should be improved.
