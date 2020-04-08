<h1>{$page_title}</h1>

<h3>System Load</h3>

<p>
	{$server_load.0}, {$server_load.1}, {$server_load.2}
</p>

<h3>Exception log file</h3>

{if !$exception_file_exists}
	<p>Exception log file doesn't exist.</p>
{else}
	<pre></code>{!$end_of_exception_file}</code></pre>
{/if}

<h3>Error log file</h3>

{if !$error_file_exists}
	<p>Error log file doesn't exist.</p>
{else}
	<pre></code>{!$end_of_error_file}</code></pre>
{/if}

<h3>System Info</h3>

<ul>
	<li>Hostname: {$hostname|default:$mdash}</li>
	<li>Pwuid: {render partial="dump_var" var=$pwuid}</li>
	<li>Uname: {render partial="dump_var" var=$uname}</li>
</ul>
