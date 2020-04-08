<h1>{$page_title}</h1>

<h3>Application</h3>

<p>
	HEAD: {$head|default:$mdash}
</p>

<h3>Gitmodules</h3>

{foreach $gitmodules as $gitmodule}
	<h4>{$gitmodule.name}</h4>
	<ul>
		<li>path: {$gitmodule.path}</li>
		<li>head: {$gitmodule.head}</li>
	</ul>
{/foreach}
