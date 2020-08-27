<?php
class RobotsTimelineController extends ApplicationController {
	function index() {
		$this->page_title = "Robots timeline";
		global $ATK14_GLOBAL;

		ini_set("memory_limit", "512M");
		$filename = $ATK14_GLOBAL->getDocumentRoot()."log/robots.log";

		$stat = $this->_parse_log($filename);
		$this->tpl_data["timeline_data"] = $this->_prepare_json_for_chart($stat);
	}

	protected function _parse_log($filename, $options=[]) {
		$options += [
			"interval" => "10 minutes",
		];

		$header = [
			"date",
			"time",
			"robot_name",
			"action",
			"rt1", "rt2", "rt3", "rt4", "rt5", "rt6",
			"dummy1",
			"dummy2",
			"dummy3",
			"dummy4",
			"dummy5",
			"dummy6",
			"\n",
		];

		$data = join(" ", $header);
		$data .= file_get_contents($filename);
		$imp = CsvImport::FromData($data, ["delimiter" => " "]);

		$stat = [];

#		$from_start_time = $options["interval"] ? strtotime($options["interval"]) : null;

		$last_robot_start_time = null;

		foreach($imp->associative() as $idx=>$row) {

			$robot_name = $row["robot_name"];
			$action = $row["action"];
			if(!preg_match("/(START|STOP)/", $action, $m)) {
				continue;
			}
			$action = Translate::Lower($m[1]);
			$date = $row["date"];
			$time = $row["time"];
			$running_time = null;

			if (!isset($stat[$robot_name])) {
				$stat[$robot_name] = [
					"start" => null,
					"stop" => null,
					"running_time" => null,
					"robot_name" => null,
				];
			}

			$stat[$robot_name][$action] = "{$date} {$time}";

			if (isset($row["rt1"]) && isset($row["rt2"]) && isset($row["rt3"]) && isset($row["rt4"]) && isset($row["rt5"]) && isset($row["rt6"]) &&
				($row["rt1"] == "running") && ($row["rt2"] == "time:")
			) {
				$running_time = (int)$row["rt3"] * 60 + (int)$row["rt5"];
			}

			if (!is_null($running_time)) {
				$stat[$robot_name]["running_time"] = $running_time;
			}

			if (isset($stat[$robot_name]["start"])) {
				$robot_start_time = strtotime($stat[$robot_name]["start"]);
				if ($robot_start_time > $last_robot_start_time) {
					$last_robot_start_time = $robot_start_time;
				}
			}
		}

		$from_time_string = date("Y-m-d H:i:s", $last_robot_start_time);
		if ($options["interval"]) {
			$from_time_string = sprintf("%s - %s", $from_time_string, $options["interval"]);
		}

		$from_start_time = strtotime($from_time_string);

		if ($from_start_time) {
			$stat = array_filter($stat, function($el) use ($from_start_time) {
				# zaznam od robota startujiciho pred danym casem nechceme
				$robot_start_time = strtotime($el["start"]);
				if ( $robot_start_time<$from_start_time ) {
					return false;
				}
				return true;
			});
		}

		return $stat;
	}

	function _prepare_json_for_chart($ar) {
		$out = [
			[
				"group" => "",
				"group" => "group 1",
				"data" => [ ],
			]
		];

		foreach($ar as $robot_name => $data) {
			preg_match("/(.+)\[(\d+)\]/", $robot_name, $m);
			$_robot_name = $m[1];
			$_robot_pid = $m[2];
			$_from = $data["start"];
			$_to = $data["stop"];
			$_value = sprintf("%ds", $data["running_time"]);
			$item = [
				"label" => "${_robot_name}",
				"label" => "${_robot_name} (pid ${_robot_pid})",
				"data" => [
					[
						"timeRange" => [
							"${_from}",
							"${_to}",
						],
						"val" => "${_robot_name}",
						"runtime" => "${_value}",
					],
				],
			];
			$out[0]["data"][] = $item;
		}
		return json_encode($out);
	}
}
