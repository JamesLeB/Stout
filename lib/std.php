<?php

	function renderTable($headings,$mdataArray){
		echo "<table>";
		echo "<tr class='heading'>";
		foreach($headings as $h){
			echo "<td>$h</td>";
		}
		echo "</tr>";
		foreach($mdataArray as $mdata){
			echo "<tr>";
				foreach($mdata as $data){
					echo "<td>$data</td>";
				}
				echo "</tr>";
		}
		echo "</table>";
	}

?>
