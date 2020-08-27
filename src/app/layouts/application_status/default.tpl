<!doctype html>
<html lang="en">
	<head>
		<!-- Required meta tags -->
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
		<meta name="robots" content="noindex,nofollow,noarchive">

		<!-- Bootstrap CSS -->
		<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
		<link href="data:image/x-icon;base64,iVBORw0KGgoAAAANSUhEUgAAABAAAAAQEAYAAABPYyMiAAAABmJLR0T///////8JWPfcAAAACXBIWXMAAABIAAAASABGyWs+AAAAF0lEQVRIx2NgGAWjYBSMglEwCkbBSAcACBAAAeaR9cIAAAAASUVORK5CYII=" rel="icon" type="image/x-icon">

		{if $controller=="robots_timeline"}
		<script src='https://unpkg.com/timelines-chart'></script>
		{/if}

		<title>{$page_title}</title>
	</head>
	<body>
	
		<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
			<div class="container">
				<a class="navbar-brand" href="{link_to action="main/index"}">ApplicationStatus{if $hostname}@{$hostname}{/if}</a>
				<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
					<span class="navbar-toggler-icon"></span>
				</button>
				<div class="collapse navbar-collapse" id="navbarNav">
					<ul class="navbar-nav">
						<li class="nav-item">
							<a class="nav-link" href="{link_to action="main/phpinfo"}">PHP Info</a>
						</li>
						<li class="nav-item{if $controller=="running_sql_queries"} active{/if}">
							<a class="nav-link" href="{link_to action="running_sql_queries/index"}">Running SQL queries</a>
						</li>
						<li class="nav-item{if $controller=="exception_reports"} active{/if}">
							<a class="nav-link" href="{link_to action="exception_reports/index"}">Exception reports</a>
						</li>
						<li class="nav-item{if $controller=="source_code"} active{/if}">
							<a class="nav-link" href="{link_to action="source_code/index"}">Source code</a>
						</li>
						<li class="nav-item{if $controller=="robots_timeline"} active{/if}">
							<a class="nav-link" href="{link_to action="robots_timeline/index"}">Robots</a>
						</li>
					</ul>
				</div>
			</div>
		</nav>
		<div class="container">
			{render partial="shared/layout/flash_message"}
			{placeholder}
		</div>

		<!-- Optional JavaScript -->
		<!-- jQuery first, then Popper.js, then Bootstrap JS -->
		<script src="https://code.jquery.com/jquery-3.3.1.min.js" integrity="sha384-tsQFqpEReu7ZLhBV2VZlAu7zcOV+rXbYlF2cqB8txI/8aZajjp4Bqd+V6D5IgvKT" crossorigin="anonymous"></script>
		<script src="https://www.atk14.net/public/dist/scripts/atk14.js" crossorigin="anonymous"></scripts>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
		<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
	</body>
</html>
