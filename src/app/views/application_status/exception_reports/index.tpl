<h1>{$page_title}</h1>

<p>Total reports: {$reports|count}</p>

<table class="table">

	<thead>
		<tr>
			<th>Name</th>
			<th>Date</th>
			<th>Size</th>
		</tr>
	</thead>

	<tbody>
		{foreach $reports as $report}
			<tr>
				<td>{a action=detail name=$report.name}{$report.name}{/a}</td>
				<td>{$report.date|format_datetime}</td>
				<td>{$report.size}</td>
			</tr>
		{/foreach}
	</tbody>

</table>
