<h1>{$page_title}</h1>

<h3>System Load</h3>

<p>
	{$server_load.0}, {$server_load.1}, {$server_load.2}
</p>

<h3>Running SQL Queries</h3>

<p>Total queries: {$running_queries|count}</p>

<h4>Top Queries</h4>
<ul class="list-unstyled">
	{foreach $top_running_queries as $item}
		<li>
			<ul>
			<li>started: {$item.query_start}</li>
			<li>duration: {$item.duration}</li>
			<li>pid: {$item.pid}</li>
			</ul>
			<hr>
			<pre><code>{!$item.query|replace:"\t":"  "|h}</code><pre>
		</li>
	{/foreach}
</ul>

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
