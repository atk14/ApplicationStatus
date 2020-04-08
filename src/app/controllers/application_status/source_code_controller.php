<?php
class SourceCodeController extends ApplicationController {

	function index(){
		$this->page_title = "Source Code";

		$root = ATK14_DOCUMENT_ROOT;
		$this->tpl_data["head"] = $this->_get_git_head_commit($root);

		// Gitmodules
		$gitmodules_src = Files::GetFileContent("$root/.gitmodules");
		preg_match_all('/\[submodule "(?<name>.*?)"\].*?path\s*=\s*(?<path>[^\s]*)/s',$gitmodules_src,$matches);

		$gitmodules = [];
		foreach($matches["name"] as $i => $name){
			$path = $matches["path"][$i];
			$gitmodules[] = [
				"name" => $name,
				"path" => $path,
				"head" =>  $this->_get_git_head_commit("$root/$path"),
			];
		}

		$this->tpl_data["gitmodules"] = $gitmodules;
	}

	function _get_git_head_commit($root){
		if(is_file("$root/.git")){
			$content = Files::GetFileContent("$root/.git"); // "../.git/modules/atk14/HEAD"
			if(!preg_match('/gitdir: (.*)/',$content,$matches)){
				return;
			}
			$gitdir = trim($matches[1]);
			$content = Files::GetFileContent("$root/$gitdir/HEAD");
			if(!preg_match('/^ref: (.*)/',$content,$matches)){
				return $content;
			}
			$ref = $matches[1];
			$content = Files::GetFileContent("$root/$gitdir/$ref");
			return $content;
		}

		if(!file_exists("$root/.git/HEAD")){
			return;
		}

		$content = Files::GetFileContent("$root/.git/HEAD");
		if(!preg_match('/^ref: (.*)/',$content,$matches)){
			return $content;
		}

		$ref = $matches[1];
		$content = Files::GetFileContent("$root/.git/$ref");
		return $content;
	}
}
