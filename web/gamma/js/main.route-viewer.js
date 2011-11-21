/********************************************

	main.route-viewer.JS
	
	VERSION 0.1
	
	LOADS JS FILES

*********************************************/

var loadFiles = [
	'jquery',
	
	'order!helpers/zeega.helpers',
	'order!helpers/zeega.extends',
	'order!libraries/underscore',
	
	'order!layers/zeega._layer',
	'order!layers/zeega.video',
	'order!layers/zeega.image',
	'order!layers/zeega.geo',
	'order!layers/zeega.text',
	'order!layers/zeega.rdio',
	       
	'order!core/player'
	];

require(loadFiles, function($) {
	var nodeId = window.location.hash.substr(1);
	//this url needs to change
	$.get(sessionStorage.getItem('hostname')+sessionStorage.getItem('directory')+'projects/'+sessionStorage.getItem('projectId')+'/all',function(data){
		Player.init(data);
	});

});
