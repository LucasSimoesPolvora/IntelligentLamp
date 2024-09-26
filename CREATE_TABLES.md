# How to init database :

1. On your mysql server you need to create a new database 

2. Reset the database (to prevent issues) with the following command :<br> 
```cmd
php artisan migrate:reset
```

3. You can create the tables with this command: <br>
``` cmd
php artisan migrate
```
4. (Optional) If you need to test the database, with the next command you can seed it with test data: <br>
``` cmd
php artisan db:seed
``` 
