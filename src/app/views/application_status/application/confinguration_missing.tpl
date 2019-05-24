<h1>{$page_title}</h1>

<p>
Application sensitive data are being shown on this page. You have to set up IP-based authentication or HTTP basic authentication. Or you can set up both.
</p>

<pre><code>
    // file: config/settings.php
    
    // IP-based authentication
    define("APPLICATION_STATUS_ALLOW_FROM","84.42.130.122,84.42.130.123,84.42.121.123/24");

    // HTTP basic authentication
    define("APPLICATION_STATUS_AUTH_USERNAME","john");
    define("APPLICATION_STATUS_AUTH_PASSWORD","the_C4ctuss!");
</code></pre>


