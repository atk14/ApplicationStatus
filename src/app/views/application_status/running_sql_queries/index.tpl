<h1>{$page_title}</h1>

<p>Total queries: {$running_queries|count}</p>

<ul class="list-unstyled">
	{foreach $running_queries as $item}
		<li>
			<ul>
				<li>started: {$item.query_start}</li>
				<li>duration: {$item.duration}</li>
				<li>pid: {$item.pid} ({a_remote action="terminate_backend" token=$item.token _method=post _confirm="Are you sure?"}terminate backend{/a_remote})</li>
			</ul>
			<hr>
			<pre><code>{!$item.query|replace:"\t":"  "|h}</code></pre>
		</li>
	{/foreach}
</ul>
