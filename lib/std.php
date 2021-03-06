<?php
	# These are utility functions that stout uses

	function custSort($a,$b){
		# sorts the price time series from mintpal
		if($a['time'] == $b['time']){
			return 0;
		}
		return ($a['time'] < $b['time']) ? -1 : 1;
	}
	function renderTable($headings,$mdataArray){
		# this gets used a lot, a quick little way to get sql data to html
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
	} # END of renderTable function
	function processResultSet($rs){
		# another utility that get used offten
		# as part of a quick way to get sql data to the screen
		# takes the result set returned from the query and
		# turns it into something the rendertable fuuntion can use
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
