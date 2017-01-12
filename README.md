# README #

### Requirements ###
- PHP >= 5.3
- Apache httpd 2.x (for Nginx please [contact me](mailto:marcelloverona@gmail.com))
    - mod_rewrite ON
    - AllowOverride All
- MySQL 5.x


### Installation ###

- Create a new database
- Restore the DB with the sql script (_sql/db_export.sql)
- Copy the file conf/conf.dist.php to conf/conf.php 
- Adjust conf/conf.php with the database connection and the other parameters
- Fill the GOOGLE_ANALYTICS_CODE definition with the right value to activate the monitoring

### Folders permissions ###

Set the folders _log_ and _tmp_ writable from the Apache user


