// This file contains the Global Data for project
// Global Array - these will eventually be stored in a database
var openBids  = createOpenBids();
var openAsks  = createOpenAsks();
var inventory = createInventory();
var sales     = createSales();

// Functions to create globals

// SALES OBJECT
function createSales(){
	headings = [];
	headings.push('Id');
	headings.push('Time');
	headings.push('Cost');
	headings.push('Price');
	headings.push('Amount');
	headings.push('Net');
	data = [];
	htmlId = '#sales';
	return [headings,data,htmlId];
}
function loadSales(){
	$(sales[2]).html(renderTable(sales[0],sales[1]));
}

// INVENTORY OBJECT
function createInventory(){
	headings = [];
	headings.push('Lot');
	headings.push('Time');
	headings.push('Cost');
	headings.push('Amount');
	headings.push('Status');
	data = [];
	htmlId = '#inventory';
	
	return [headings,data,htmlId];
}
function loadInventory(){
	var askId = '#postAskId';
	$(askId).empty();
	$.each(inventory[1],function(index){
		this[0] = index;
		$(askId).append('<option value='+index+'>'+index+'</option>');
	});
	$(inventory[2]).html(renderTable(inventory[0],inventory[1]));
}

// OPEN BIDS OBJECT
function createOpenBids(){
	headings = [];
	headings.push('Id');
	headings.push('Price');
	headings.push('Amount');
	data = [];
	htmlId    = '#openBids';
	cancelId  = '#cancelBidId';
	confirmId = '#confirmBidId';
	return [headings,data,htmlId,cancelId,confirmId];
}
function loadOpenBids(){
	$(openBids[3]).empty();
	$(openBids[4]).empty();
	$.each(openBids[1],function(index){
		this[0] = index;
		$(openBids[3]).append('<option value='+index+'>'+index+'</option>');
		$(openBids[4]).append('<option value='+index+'>'+index+'</option>');
	});
	$(openBids[2]).html(renderTable(openBids[0],openBids[1]));
}

// OPEN ASKS OBJECT
function createOpenAsks(){
	headings = [];
	headings.push('Id');
	headings.push('Lot');
	headings.push('Time');
	headings.push('Price');
	headings.push('Amount');
	data = [];
	htmlId    = '#openBids';
	cancelId  = '#cancelAskId';
	confirmId = '#confirmAskId';
	return [headings,data,htmlId,cancelId,confirmId];
}
function loadOpenAsks(){
	$(openAsks[3]).empty();
	$(openAsks[4]).empty();
	$.each(openAsks[1],function(index){
		this[0] = index;
		$(openAsks[3]).append('<option value='+index+'>'+index+'</option>');
		$(openAsks[4]).append('<option value='+index+'>'+index+'</option>');
	});
//FIX ME NO TEXT IN METHOD
	$('#openAsks').html(renderTable(openAsks[0],openAsks[1]));
}
