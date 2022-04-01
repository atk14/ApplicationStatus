<?php
class MainController extends ApplicationController {

	function index(){
		$this->page_title = "Application Status";

		// System Load
		$this->tpl_data["server_load"] = sys_getloadavg();

		// Uptime
		$this->tpl_data["uptime"] = $this->_uptime();
	
		// Logs 
		$log_dir = ATK14_DOCUMENT_ROOT . "/log";
		$exception_file = "$log_dir/exception.log";
		$exception_file_exists = file_exists($exception_file);
		$error_file = "$log_dir/error.log";
		$error_file_exists = file_exists($error_file);
		//
		$this->tpl_data["exception_file_exists"] = $exception_file_exists;
		$this->tpl_data["end_of_exception_file"] = $this->_read_end_of($exception_file);
		$this->tpl_data["error_file_exists"] = $error_file_exists;
		$this->tpl_data["end_of_error_file"] = $this->_read_end_of($error_file);

		// System Info
		if(function_exists("posix_uname")){
			$this->tpl_data["uname"] = posix_uname();
		}
		if(function_exists("posix_getpwuid")){
			$this->tpl_data["pwuid"] = posix_getpwuid(posix_getuid());
		}
	}

	function phpinfo(){
		ob_start();
		phpinfo();
		$content = ob_get_clean();
		$this->render_template = false;
		$this->response->write($content);
	}

	function _read_end_of($file,$chunk_size = 2048){
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

	function _uptime(){
		$str = @file_get_contents("/proc/uptime");
		if(!$str){ return null; }

		$num = floatval($str);
		$secs = ceil(fmod($num, 60));

		$num = intdiv($num, 60);
		$mins = $num % 60;

		$num = intdiv($num, 60);
		$hours = $num % 24;

		$num = intdiv($num, 24);
		$days = $num;

		return array(
			"days" => $days,
			"hours" => $hours,
			"mins" => $mins,
			"secs" => $secs,
		);
	}
}
