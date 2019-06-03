<?php
class RunningSqlQueriesController extends ApplicationController {

	function index(){
		$this->page_title = "Running SQL Queries";
		$this->tpl_data["running_queries"] = $this->_get_running_queries();
	}

	function _get_running_queries(){
		$rows = $this->dbmole->selectRows("
			SELECT pid, query_start, AGE(CLOCK_TIMESTAMP(), query_start) AS duration, query
			FROM pg_stat_activity
			WHERE query != '<IDLE>' AND query!='<insufficient privilege>' AND query NOT ILIKE '%pg_stat_activity%'
			ORDER BY query_start
		");
		return $rows;
	}
}
