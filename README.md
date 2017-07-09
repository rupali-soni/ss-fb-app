# ss-fb-app
App is a basic example of Fb login, Fb logout and Fb deauth calls

## Installation

```
- Clone git repository: https://github.com/rupali-soni/ss-fb-app.git
- Download the PHP composer and install it from [here](https://getcomposer.org/download/)
- Go to project root directory and run command **composer install**
- Create a database and dump SQL schema from `db/fb-app_2017-07-09.sql` file.
- Now create an app on facebook developer console: `https://developers.facebook.com/apps/`
- Add all the required settings, make sure you put your app in production mode so that other's can use it.
- Set this deauth URL: `https://localhost/fb-app/fbdeauth.php` Please note you must have to use `https` here. Also change host name accordingly.
- Make changes in `src/Config.php` for database and facebook app configurations.
```

## Execution

```
- Start server and run application using hostname.
```

## POC

```
- Screenshots are attaches in poc directory for reference
```