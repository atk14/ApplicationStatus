<?php
class ExceptionReportsController extends ApplicationController {

	function index(){
		$this->page_title = "Exception Reports";
		$reports = $this->_read_reports();
		$this->tpl_data["reports"] = $reports;
	}

	function detail(){
		$report = $this->report;
		$this->render_template = false;
		$this->response->setContenTtype("text/html");
		$this->response->buffer->addFile($report["filename"]);
	}

	function destroy(){
		if(!$this->request->post()){
			return $this->_execute_action("error404");
		}

		$report = $this->report;
		Files::Unlink($report["filename"]);
		
		if($this->request->xhr()){
			$this->template_name = "application/destroy";
			return;
		}

		$this->flash->success("Report has been deleted");
		$this->_redirect_to("index");
	}

	function _before_filter(){
		if(in_array($this->action,["detail","destroy"])){
			$name = $this->params->getString("name");
			$reports = $this->_read_reports();

			if(!isset($reports[$name])){
				return $this->_execute_action("error404");
			}

			$this->report = $reports[$name];
		}
	}

	function _read_reports(){
		$files = Files::FindFiles(ATK14_DOCUMENT_ROOT."/log/",[
			"pattern" => '/^exception--.*\.html$/'
		]);

		$reports = [];
		foreach($files as $filename){
			$name = preg_replace('/^.*\//','',$filename); // "/home/john/apps/foobar/log/exception--2018-05-04--16-48--ac61a358d6.html" -> "exception--2018-05-04--16-48--ac61a358d6.html"
			$size = filesize($filename);
			$reports[$name] = [
				"name" => $name,
				"filename" => $filename,
				"date" => date("Y-m-d H:i:s",filectime($filename)),
				"size" => $size,
			];
		}

		$reports = array_reverse($reports);

		return $reports;
	}

}
