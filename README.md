Application Status
==================

The application status monitor.

Installation
------------

    cd path/to/your/atk14/project/
    composer require atk14/application-status

    ln -s ../../vendor/atk14/application-status/src/app/controllers/application_status/ app/controllers/application_status
    ln -s ../../vendor/atk14/application-status/src/app/views/application_status/ app/views/application_status
    ln -s ../../vendor/atk14/application-status/src/app/layouts/application_status/ app/layouts/application_status

Configuration
-------------

    // file: config/settings.php

    define("APPLICATION_STATUS_ALLOW_FROM","84.42.130.122,84.42.130.123,84.42.121.123/24");
