Application Status
==================

The ATK14 application status monitor.

Application Status provides:

- system load information
- access to error logs
- list of currently running SQL queries ordered by duration
- access to exception reports produced by [Tracy](https://packagist.org/packages/tracy/tracy)

Installation
------------

    cd path/to/your/atk14/project/
    composer require atk14/application-status

    ln -s ../../vendor/atk14/application-status/src/app/controllers/application_status/ app/controllers/application_status
    ln -s ../../vendor/atk14/application-status/src/app/views/application_status/ app/views/application_status
    ln -s ../../vendor/atk14/application-status/src/app/layouts/application_status/ app/layouts/application_status

After deployment to the production, the Application Status will be accessible on address:

    http://your.project.com/application_status/

Configuration
-------------

Set up IP-based authentication or HTTP basic authentication. It's even ok to set up both.

    // file: config/settings.php
    
    // IP-based authentication
    define("APPLICATION_STATUS_ALLOW_FROM","84.42.130.122,84.42.130.123,84.42.121.123/24");

    // HTTP basic authentication
    define("APPLICATION_STATUS_AUTH_USERNAME","john");
    define("APPLICATION_STATUS_AUTH_PASSWORD","the_C4ctuss!");

By default, there is automatic redirection to ssl in production environment.
It can be suppressed by setting constant APPLICATION_STATUS_REDIRECT_TO_SSL_AUTOMATICALLY to false:

    define("APPLICATION_STATUS_REDIRECT_TO_SSL_AUTOMATICALLY",false);

[//]: # ( vim: set ts=2 et: )
