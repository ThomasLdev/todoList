<h1>Audit TODOLIST</h1>

<a href="https://codeclimate.com/github/ThomasLdev/todoList/maintainability"><img src="https://api.codeclimate.com/v1/badges/9d881c1841aa5ab01b3d/maintainability" /></a>

<h2>Install Using Docker :</h2>
After pulling the project :

<br>
<h3>Build and Run the containers</h3>

```
docker-compose up -d
```

<h3>Enter the app container</h3>

```
docker exec -it php_todolist_2 bash cd html
 ```
 
<h3>Install the vendors</h3>

 ```
composer install
 ```
 
<h3>Create your local .env settings</h3>

 ```
touch .env.local
 ```
 
Then for test purposes, add in the .env.local :

 ```
DATABASE_URL="mysql://root:@database:3306/todolist_2" <br>
APP_SECRET=471a62e2d601a8952deb186e44186cb3 <br>
APP_ENV=dev
 ```
 
<h3>Then create the database</h3>

 ```
php bin/console doctrine:database:create
 ```
 
<h3>Run Doctrine Migrations on your fresh database</h3>

 ```
bin/console doctrine:migrations:migrate
 ```
 
<h3>Populate the database with fixtures</h3>

 ```
bin/console doctrine:fixtures:load
 ```
 
<h3>Outside of docker, at the project's root, restore the user permissions</h3>


 ```
sudo chown -R $USER ./
 ```
 
 <h3>Its Done !</h3>

You can now navigate to localhost:8000
