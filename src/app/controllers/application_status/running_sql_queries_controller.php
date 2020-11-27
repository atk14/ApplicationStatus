<?php
class RunningSqlQueriesController extends ApplicationController {

	function index(){
		$this->page_title = "Running SQL Queries";

		$running_queries = $this->_get_running_queries();
		$summary = array();
		foreach($running_queries as $item){
			$datname = $item["datname"];
			if(!isset($summary[$datname])){ $summary[$datname] = 0; }
			$summary[$datname]++;
		}
		
		$this->tpl_data["running_queries"] = $running_queries;
		$this->tpl_data["summary"] = $summary;
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

		$status = $this->dbmole->doQuery("SELECT PG_TERMINATE_BACKEND(:pid)",[":pid" => $query["pid"]]);
		if($status){
			$this->flash->success("Process terminated");
		}else{
			$this->flash->warning("Process was not terminated");
		}
		$this->_redirect_to("index");
	}

	function _get_running_queries(){
		$rows = $this->dbmole->selectRows("
			SELECT pid, datname, query_start, AGE(CLOCK_TIMESTAMP(), query_start) AS duration, query
			FROM pg_stat_activity
			WHERE query != '<IDLE>' AND query!='<insufficient privilege>' AND query NOT ILIKE '%pg_stat_activity%'
			ORDER BY query_start
		");
		foreach($rows as $k => $row){
			unset($row["duration"]);
			$rows[$k]["token"] = $row["pid"].".".md5(serialize($row));
		}
		return $rows;
	}
}
