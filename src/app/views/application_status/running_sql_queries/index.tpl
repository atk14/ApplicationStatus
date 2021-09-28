<h1>{$page_title}</h1>

<p>Total queries: {$running_queries|count}</p>

{if $summary}
	<ul>
		{foreach $summary as $datname => $cnt}
			<li>{$datname}: {$cnt}</li>
		{/foreach}
	</ul>
{/if}

<ul class="list-unstyled">
	{foreach $running_queries as $item}
		<li>
			<ul>
				<li>database: {$item.datname}</li>
				<li>started: {$item.query_start}</li>
				<li>duration: {$item.duration}</li>
				<li>pid: {$item.pid} ({a_remote action="terminate_backend" token=$item.token _method=post _confirm="Are you sure?"}terminate backend{/a_remote})</li>
			</ul>
			<br>
			<pre><code>{!$item.query|replace:"\t":"  "|h}

</code></pre>
			<hr>
		</li>
	{/foreach}
</ul>

<hr>

<p>{a action="terminate_all_backends" _method=post _confirm="Are you sure?" _class="btn btn-sm btn-danger"}Terminate all backends{/a}</p>
