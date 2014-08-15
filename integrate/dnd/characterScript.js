	// Global Variables
	var characterName = 'default';

	function james(x){
		$('#characterSheet').append('<button id="reset">reset</button>');
	}
	function kara(x){
	}
	$(document).ready(function(){

		james(1);

		$('.space').click(function(){
			kara(1);
		});

	});// End document ready function
