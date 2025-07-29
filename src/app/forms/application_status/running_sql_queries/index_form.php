<?php
class IndexForm extends ApplicationStatusForm {

	function set_up(){
		$this->add_field("search", new CharField([
			"label" => "Search in queries",
			"required" => false,
		]));
	}
}
