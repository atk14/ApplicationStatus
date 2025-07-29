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
    ln -s ../../vendor/atk14/application-status/src/app/forms/application_status/ app/forms/application_status
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
    define("APPLICATION_STATUS_AUTH_USERNAME","status");
    define("APPLICATION_STATUS_AUTH_PASSWORD",'$2a$04$fRdoV2rr6IOmf83E5eH83Oqw8yR5k9HtRWvBSd2pOwev6yoDxKX3W');

It is expected that the password is either a blowfish hash or it is set in plain text.

    define("APPLICATION_STATUS_AUTH_PASSWORD","secret");

The blowfish hash can be calculated using the ATK14 console. Because the correct password is compared with the hash in every HTTP request,
it is a good idea not to generate too complex hash (with too high rounds value).
    
    $ echo 'echo MyBlowfish::GetHash("secret","",["rounds" => 4]),"\n";' | ./scripts/console
    $2a$04$fRdoV2rr6IOmf83E5eH83Oqw8yR5k9HtRWvBSd2pOwev6yoDxKX3W

By default, there is automatic redirection to ssl in production environment.
It can be suppressed by setting constant APPLICATION_STATUS_REDIRECT_TO_SSL_AUTOMATICALLY to false:

    define("APPLICATION_STATUS_REDIRECT_TO_SSL_AUTOMATICALLY",false);

[//]: # ( vim: set ts=2 et: )
