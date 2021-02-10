# FBC

FBC (Footballi Backend Challenge) is an application, allowing you to manage your github starred repositories by adding tags to them. you can add your own tags, edit them, and search among defined tags to retrieve repositories.

FBC is developed using "Soda" framework

# Soda
A simple PHP MVC framework

*Includes just the basics and a few helper classes and functions*

You can understand how it works by simply configuring your webserver to run Soda and start browsing the included `app.sample.config.php` and overall project structure (folder structure).


# Requirements
to run FBC, you need to install requirements. to do so, execute `composer update` at root folder using command prompt.

# Application Configuration
At Soda root folder you can find the `app.sample.config.php` file.
to configure this file, follow these steps:

1- rename `app.sample.config.php` to `app.config.php`

2- in line 6, define `MAIN_DOMAIN` according to settings of your apache virtual host

3- in line 23, enter the application path for `PROJECT_ROOT_ABS_PATH`

4- in line 34, enter your database username for `SQL_DB_USERNAME`

5- in line 35, enter your database password for `SQL_DB_PASSWORD`

6- in line 36, enter your database name for `SQL_DB_DEFAULT_NAME`

# Configuring the SQL database
to run the migration:

execute `vendor\bin\phinx migrate -c phinx.config.php` at root folder using command prompt.

# Testing Application Functionality
import the `api.postman_collection.json` to `postman`. this collection includes 
"get user starred repositories", "get current user repositories", "add tag", "edit tag", "delete tag", and "search repository by tag" API requests.

