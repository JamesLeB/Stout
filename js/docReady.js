/*
*	Document Ready Fuction
*/
$(document).ready(function(){
	/*
	*	Stout Heading code
	*/
	setInterval(function(){
		var t = new Date();
		var M = t.getMonth()+1;
		var d = t.getDate();
		var y = t.getFullYear();
		var h = t.getHours();
		var m = t.getMinutes();
		var s = t.getSeconds();
		$('clock').html(y+'-'+M+'-'+d+'<br/>'+h+':'+m+':'+s); 
	},1000);
	/*
	*	END Stout Heading code
	*/
	$("#tabs").tabs();
	$("#accordion").accordion();
};
/*
*	END Document Ready Fuction
*/
