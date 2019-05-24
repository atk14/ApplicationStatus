<?php
class MainController extends ApplicationController {

	function index(){
		$this->page_title = "Application Status";

		$server_load = sys_getloadavg();
		$running_queries = $this->_get_running_queries();
		$top_running_queries = array_slice($running_queries,0,10);
	
		// logs
		$log_dir = ATK14_DOCUMENT_ROOT . "/log";
		$exception_file = "$log_dir/exception.log";
		$exception_file_exists = file_exists($exception_file);
		$error_file = "$log_dir/error.log";
		$error_file_exists = file_exists($error_file);
		
		$this->tpl_data["server_load"] = $server_load;
		$this->tpl_data["running_queries"] = $running_queries;
		$this->tpl_data["top_running_queries"] = $top_running_queries;

		// logs
		$this->tpl_data["exception_file_exists"] = $exception_file_exists;
		$this->tpl_data["end_of_exception_file"] = $this->_read_end_of($exception_file);
		$this->tpl_data["error_file_exists"] = $error_file_exists;
		$this->tpl_data["end_of_error_file"] = $this->_read_end_of($error_file);
	}

	function _get_running_queries(){
		$rows = $this->dbmole->selectRows("
			SELECT pid, query_start, AGE(CLOCK_TIMESTAMP(), query_start) AS duration, query
			FROM pg_stat_activity 
			WHERE query != '<IDLE>' AND query!='<insufficient privilege>' AND query NOT ILIKE '%pg_stat_activity%' 
			ORDER BY query_start DESC
		");
		return $rows;
	}

	function _read_end_of($file,$chunk_size = 1024){
		if(!file_exists($file)){
			return null;
		}

		$fsize = filesize($file);
		$offset = $fsize - $chunk_size;
		if($offset<0){ $offset = 0; }

		if($fsize==0){ return ""; }

		$f = fopen($file,"r");
		if(!$f){ return null; }
		if($offset){
			fseek($f,$offset);
		}
		$content = fread($f,$chunk_size);
		fclose($f);

		return $content;
	}
}
