{if is_null($var)}
	<em>NULL</em>
{elseif is_array($var)}
	{if sizeof($var)==0}
		<em>[]</em>
	{else}
		<ul>
			{foreach $var as $k => $v}
				<li>{$k}: {render partial="dump_var" var=$v}</li>
			{/foreach}
		</ul>
	{/if}
{else}
	{$var}
{/if}
