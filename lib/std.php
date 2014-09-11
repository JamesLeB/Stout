<?php

	function renderTable($headings,$mdataArray){
		$echo = '';
		$echo .= "<table class='queryTable'>";
		$echo .= "<tr class='tableHeading'>";
		foreach($headings as $h){
			$echo .= "<td>$h</td>";
		}
		#$echo .= "<td></td>";
		$echo .= "</tr>";
		$count = 0;
		foreach($mdataArray as $mdata){
			$count++;
			$echo .= "<tr class='tableData'>";
				foreach($mdata as $data){
					$echo .= "<td>$data</td>";
				}
				#$echo .= "<td><button>00</button></td>";
				$echo .= "</tr>";
		}
		$echo .= "</table>";
		#$echo = $count == 0 ? 'No records' : $echo;
		return $echo;
	}
	function processResultSet($rs){
		$headings = array();
		$records = array();
		$count = 0;
		foreach($rs->result_array() as $row){
			$line = array();
			$headings = array_keys($row);
			foreach($headings as $key){
				$line[] = $row[$key];
			}
			$records[] = $line;
			$count++;
		}
		return array($headings,$records,$count);
	}

?>
