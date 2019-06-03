<?php
class RunningSqlQueriesController extends ApplicationController {

	function index(){
		$this->page_title = "Running SQL Queries";
		$this->tpl_data["running_queries"] = $this->_get_running_queries();
	}

	function terminate_backend(){
		if(!$this->request->post()){ return $this->_execute_action("error404"); }

		$token = $this->params->getString("token");
		if(!$token){ return $this->_execute_action("error404"); }

		$queries = $this->_get_running_queries();
		$queries = array_filter($queries,function($item) use($token){ return $item["token"]==$token; });

		if(!$queries){
			$this->flash->notice("This process no longer exists");
			$this->_redirect_to("index");
			return;
		}

		$queries = array_values($queries);
		$query = $queries[0];

		$this->dbmole->doQuery("SELECT PG_TERMINATE_BACKEND(:pid)",[":pid" => $query["pid"]]);
		$this->flash->success("Process terminated");
		$this->_redirect_to("index");
	}

	function _get_running_queries(){
		$rows = $this->dbmole->selectRows("
			SELECT pid, query_start, AGE(CLOCK_TIMESTAMP(), query_start) AS duration, query
			FROM pg_stat_activity
			WHERE query != '<IDLE>' AND query!='<insufficient privilege>' AND query NOT ILIKE '%pg_stat_activity%'
			ORDER BY query_start
		");
		$rows = $this->dbmole->selectRows("
			SELECT pid, query_start, AGE(CLOCK_TIMESTAMP(), query_start) AS duration, query
			FROM pg_stat_activity
			ORDER BY query_start
		");
		foreach($rows as $k => $row){
			unset($row["duration"]);
			$rows[$k]["token"] = $row["pid"].".".md5(serialize($row));
		}
		return $rows;
	}
}
