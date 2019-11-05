<?php
definedef("APPLICATION_STATUS_ALLOW_FROM",""); // e.g. "127.0.0.1,10.20.30.40/30"
definedef("APPLICATION_STATUS_AUTH_USERNAME","");
definedef("APPLICATION_STATUS_AUTH_PASSWORD","");
definedef("APPLICATION_STATUS_REDIRECT_TO_SSL_AUTOMATICALLY",defined("REDIRECT_TO_SSL_AUTOMATICALLY") ? constant("REDIRECT_TO_SSL_AUTOMATICALLY") : PRODUCTION);

class ApplicationController extends Atk14Controller {

	function _initialize(){
		$this->_prepend_before_filter("application_before_filter");
	}

	function _application_before_filter(){
		if(strlen(APPLICATION_STATUS_ALLOW_FROM.APPLICATION_STATUS_AUTH_USERNAME.APPLICATION_STATUS_AUTH_PASSWORD)==0){
			return $this->_execute_action("confinguration_missing");
		}

		if(APPLICATION_STATUS_REDIRECT_TO_SSL_AUTOMATICALLY && !$this->request->ssl()){
			return $this->_redirect_to_ssl();
		}

		$allow_from = APPLICATION_STATUS_ALLOW_FROM;
		$allow_from = preg_replace('/\s/','',$allow_from);
		if($allow_from){
			$something_matched = false;
			$ips = explode(",",$allow_from);
			$matched = array_filter($ips,function($ip){ return IP::Match($this->request->getRemoteAddr(),$ip); });
			if(!$matched){ return $this->_execute_action("error403"); }
		}

		if(strlen(APPLICATION_STATUS_AUTH_USERNAME) || strlen(APPLICATION_STATUS_AUTH_PASSWORD)){
			if($this->request->getBasicAuthString()!==APPLICATION_STATUS_AUTH_USERNAME.":".APPLICATION_STATUS_AUTH_PASSWORD){
				return $this->_execute_action("error401");
			}
		}
	}

	function confinguration_missing(){
    $this->response->setStatusCode("403");
		$this->page_title = "Configuration missing";
		$this->template_name = "application/confinguration_missing";
	}
}
