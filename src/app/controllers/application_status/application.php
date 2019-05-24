<?php
definedef("APPLICATION_STATUS_ALLOW_FROM","");

class ApplicationController extends Atk14Controller {

	function _initialize(){
		$this->_prepend_before_filter("application_before_filter");
	}

	function _application_before_filter(){
		$allow_from = APPLICATION_STATUS_ALLOW_FROM;
		$allow_from = preg_replace('/\s/','',$allow_from);
		if($allow_from){
			$something_matched = false;
			$ips = explode(",",$allow_from);
			$matched = array_filter($ips,function($ip){ return IP::Match($this->request->getRemoteAddr(),$ip); });
			if(!$matched){ return $this->_execute_action("error403"); }
		}
	}
}
