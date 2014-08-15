
	// Initialize Global Variables
	var spaceNumber = 0;
	var activeSpaceIndex = 0;
	var selectedSpaceIndex = -1;
	var currentMode = 'normal';

	// Create Map Array
	var map = new Array();
	for ( var i = 0; i < 121; i++ ){
		var space = new Object();
			space['terrain'] = 'Tree';
			space['character'] = 'no';
		map[i] = space;
	}
	map[10]['terrain'] = 'Hill';
	map[110]['terrain'] = 'Plain';
	map[60]['character'] = 'yes';

	// Set Cursor Colors 
	var mapCursor  = 'yellow';
	var mapActive  = 'yellow';

	function LoadInformation(){
		$('#Information').html(       'Mode : '     +currentMode                       );
		$('#Information').append('<br/>space : '    +activeSpaceIndex                  );
		$('#Information').append('<br/>Terrain : '  +map[activeSpaceIndex]['terrain']  );
		$('#Information').append('<br/>character : '+map[activeSpaceIndex]['character']);
		$('#Information').append('<br/>selectedIndex : '+selectedSpaceIndex);
		$('#Information').append('<br/>next...');
	};
	function LoadMap(){
		$('#Information').html('Loading map...');
		for ( var i = 0; i < map.length; i++ ){
			var terrain = map[i]['terrain'];
			var color = getMapColor(terrain);
			$('#space'+i).css({'background':color});
			$('#space'+i).css({'border-color':color});
			if ( map[i]['character'] == "yes" ){
				$('#space'+i).html('<img src="pic3.png"/>');
			}
		}
	}
	function getMapColor(x){
		var newColor = 'gray';
		     if ( x == 'Plain' ) { newColor = 'green'; }
		else if ( x == 'Hill' )  { newColor = 'gray'; }
		else if ( x == 'Tree' )  { newColor = 'darkgreen'; }
		return newColor;
	}
	$(document).ready(function(){

		// Build Map HTML
		var mapHTML = '<table>';
		for ( var i = 0; i < 11; i++ ){
			mapHTML += '<tr>';
			for ( var j = 0; j < 11; j++ ){
				mapHTML += '<td id = "space'+spaceNumber+'" class="space"></td>';
				spaceNumber++;
			}
			mapHTML += '</tr>';
		}
		mapHTML += '</table>';
		$('#Map').html(mapHTML);

		// Cursor Control Functions
		$('.space').mouseover(function(){
			// Change active space
			activeSpaceIndex = $(this).attr('id').slice(5);
			// highlight new active space if it is not the selected space
			if( activeSpaceIndex != selectedSpaceIndex ){
				$(this).css({'border-color':mapCursor});
			}
			LoadInformation();
		});
		$('.space').mouseout(function(){
			var currentSpace = $(this).attr('id');
			var currentIndex = currentSpace.slice(5);
			// if leaving space that is not the selected space clear space highlite
			if ( currentIndex != selectedSpaceIndex ) {
				var newColor = getMapColor(map[currentIndex]['terrain']);
				$(this).css({'border-color':newColor});
			}
		});
		$('.space').click(function(){
			if ( currentMode == 'normal' ){
				// Switch from normal mode to target mode
				currentMode = 'target';
				mapCursor  = 'red';
				$('#Map table').css({'border-color':'yellow'});
				selectedSpaceIndex = $(this).attr('id').slice(5);
			} else if ( currentMode == 'target' ){
				// Switch from target to normal mode
				currentMode = 'normal';
				mapCursor  = 'yellow';
				$('#Map table').css({'border-color':'green'});
				// clear previous selected
				var newColor = getMapColor(map[selectedSpaceIndex]['terrain']);
				$('#space'+selectedSpaceIndex).css({'border-color':newColor});
				selectedSpaceIndex = -1;
				$(this).css({'border-color':mapCursor});
			}
			LoadInformation();
		});
		LoadMap();
	});// End document ready function
