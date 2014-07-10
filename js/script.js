/* 
	This is my base java script
*/

$(document).ready(function(){

	$('#tabs').tabs();

/*
	$('#test').click(function(){
		//$('#mainDisplay').html('Test Disabled');
		$('#mainMenu').css('background','yellow');
		var target = 'index.php?/action/test';
		var request=$.post(target,'',function(data){
			$('#mainMenu').css('background','lightgreen');
			$('#mainDisplay').html(data);
			//var debug = request.getResponseHeader('debug');
			//$('#debug').html(debug);
			//var kara = request.getResponseHeader('kara');
			//if( kara == 1 ){goKara();}else{}
		});
	});
*/
});
// END document.ready funcion

/*
	Function used as a running feedback loop to browser
function goKara(){
	var target = 'index.php?/action/kara'
	var request=$.post(target,'',function(data){
		$('#debug').html(data);
		var kara = request.getResponseHeader('kara');
		if( kara == 1 ){goKara();}else{}
	});
}
// END goKara function
*/
