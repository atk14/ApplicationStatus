<h1>{$page_title}</h1>


{if !$reports}

	<p>Congratulations! There are currently no exception reports.</p>

{else}

	<p>Total reports: {$reports|count}</p>

	<table class="table">

		<thead>
			<tr>
				<th>Title</th>
				<th>Date</th>
				<th>Size</th>
				<th></th>
			</tr>
		</thead>

		<tbody>
			{foreach $reports as $report}
				<tr>
					<td>{a action=detail name=$report.name}{$report.title|truncate:200}{/a}</td>
					<td>{$report.date|format_datetime}</td>
					<td>{$report.size}</td>
					<td>{a_remote action=destroy _method=post name=$report.name _confirm="Are you sure you want to delete this report?" _class="btn btn-danger btn-sm" _title="Delete report"}<strong>&times;</strong>{/a_remote}</td>
				</tr>
			{/foreach}
		</tbody>

	</table>

{/if}
