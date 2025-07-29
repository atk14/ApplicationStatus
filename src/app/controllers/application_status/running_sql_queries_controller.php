<?php
class RunningSqlQueriesController extends ApplicationController {

	function index(){
		$this->page_title = "Running SQL Queries";

		($d = $this->form->validate($this->params)) || ($d = $this->form->get_initial());

		$running_queries = $this->_get_running_queries($d["search"]);
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

		$status = $this->_terminate_backed($query["pid"]);
		if($status){
			$this->flash->success("Process terminated");
		}else{
			$this->flash->warning("Process was not terminated");
		}
		$this->_redirect_to("index");
	}

	function terminate_selected_backends(){
		if(!$this->request->post()){ return $this->_execute_action("error404"); }

		$tokens = $this->params->getArray("tokens");
		// if(!$tokens){ return $this->_execute_action("error404"); }

		$queries = $this->_get_running_queries();
		$queries = array_filter($queries,function($item) use($tokens){ return in_array($item["token"],$tokens); });

		$terminated = 0;
		foreach($queries as $query){
			$status = $this->_terminate_backed($query["pid"]);
			if($status){
				$terminated++;
			}
		}

		$this->flash->success(sprintf("Backends terminated: %d",$terminated));
		$this->_redirect_to("index");
	}

	function _get_running_queries($search = ""){
		$bind_ar = [];
		$q_search = "";
		if($search){
			$q_search = " AND query LIKE '%'||:search||'%'";
			$bind_ar[":search"] = $search;
		}
		$rows = $this->dbmole->selectRows("
			SELECT pid, datname, query_start, AGE(CLOCK_TIMESTAMP(), query_start) AS duration, query, state
			FROM pg_stat_activity
			WHERE query != '<IDLE>' AND query!='<insufficient privilege>' AND query NOT ILIKE '%pg_stat_activity%'$q_search
			ORDER BY state='active' DESC, query_start
		",$bind_ar);
		foreach($rows as $k => $row){
			unset($row["duration"]);
			$rows[$k]["token"] = $row["pid"].".".md5(serialize($row));
		}
		return $rows;
	}

	function _terminate_backed($pid){
		return $this->dbmole->doQuery("SELECT PG_TERMINATE_BACKEND(:pid)",[":pid" => $pid]);
	}
}
