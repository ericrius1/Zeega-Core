
/************************************

	VIDEO LAYER CHILD CLASS

************************************/

var YoutubeLayer = VideoLayer.extend({
	
	defaultAttributes : {
		'title' : 'Video Layer',
		'url' : 'none',
		'left' : 0,
		'top' : 0,
		'height' : 100,
		'width' : 100,
		'volume' : 50,
		'in'  : 0,
		'out' : 0,
		'opacity' : 1,
		'dimension' : 1.33
	},
	
	onControlsOpen: function(){
		if( !this.editorLoaded ){
			var _this = this;
			
			var html = $('<div>').addClass('clearfix')
				.css( 'height' , '140px' ) //this should moved out
				.html( this.getTemplate() );
			this.layerControls.prepend( html );
			
			//this.layerControls.prepend( this.getTemplate() );
			this.player = new ZeegaYoutubeEditor(_this.model.id,_this.attr.url,_this.attr.in,_this.attr.out,_this.attr.volume,'layer-preview-wrapper-'+_this.model.id,'layer-'+_this.model.id);
		
			this.layerControls.bind( 'updated' , function(){
				var properties = {
					inPoint : {
						property : 'in',
						value : _this.player.getInPoint(),
						css : false
					},
					outPoint : {
						property : 'out',
						value : _this.player.getOutPoint(),
						css : false
					},
					volume : {
						property : 'volume',
						value : _this.player.getVolume(),
						css : false
					}
				};
				_this.layerControls.trigger( 'update' , [ properties ]);
			});
			
			_this.editorLoaded=true;
		}
	},
	
	visual : function(){
		var _this  = this;

		var h = Math.floor( this.attr.w * 1.5 / this.attr.dimension );
		var cssObj = {
			'backgroundImage':'url('  + sessionStorage.getItem('hostname') + sessionStorage.getItem('directory') + 'images/items/'+this.attr.item_id+'_s.jpg)',
			'backgroundSize': '100px 100px',
			'position' : 'absolute',
			'top' : this.attr.top +"%",
			'left' : this.attr.left +"%",
			'z-index' : this.zIndex,
			'width' : this.attr.width +"%",
			'height' : this.attr.height +"%",
			'opacity' : this.attr.opacity
		};
		
		this.visualEditorElement.addClass('media editable draggable')
			.attr({
				'id' : 'layer-preview-'+this.model.id,
				'data-layer-id' : this.model.id
			})
			.css(cssObj);
		
		var wrapper = $('<div>').css({'width':'100%','height':'100%'}).attr('id','layer-preview-wrapper-'+this.model.id);

		
				
		this.visualEditorElement.bind( 'slide' , function(){
			
			var height = Math.floor($('#layer-edit-'+_this.model.id).find('#Scale-slider').slider('value')*1.5/_this.attr.dimension);
			$(this).css({
				'opacity': $('#layer-edit-'+_this.model.id).find('#Opacity-slider').slider('value'),
				'width' : $('#layer-edit-'+_this.model.id).find('#Scale-slider').slider('value')+'%',
				'height' : height+'%'
			});
		});
		
		this.visualEditorElement.append(wrapper);
	},
	
	thumb : function()
	{
		var cssObj = {
			'backgroundImage':'url('  + sessionStorage.getItem('hostname') + sessionStorage.getItem('directory') + 'images/items/'+this.attr.item_id+'_s.jpg)',
			'backgroundSize': '100px 100px',
		};
		
		this.thumbnail.css( cssObj );
	},
	
	
	
	preload : function()
	{
		
		var h = Math.floor( this.attr.width  / this.attr.dimension );

		var cssObj = {
			'position' : 'absolute',
			'top' : "-1000%",
			'left' : "-1000%",
			'z-index' : this.zIndex,
			'width' : this.attr.width+"%",
			'height' : h+"%",
			'opacity' : this.attr.opacity
		};

		var wrapper = $('<div>')
			.css({'width':'100%','height':'100%','background':'transparent'})
			.attr('id','layer-publish-wrapper-'+this.model.id)

		this.display
			.attr({
				'id' : 'layer-publish-'+this.model.id,
				'data-layer-id' : this.model.id
			})
			.css( cssObj )
			.append( wrapper );
		
		this.player = new ZeegaYoutubePlayer(this.model.id,this.attr.url,this.attr.in,this.attr.out,this.attr.volume,'layer-publish-wrapper-'+this.model.id,'zeega-player');
	},
	
	play : function(z)
	{
		this.display.css({ 'z-index':z,'top': this.attr.top + '%','left':this.attr.left +'%'});
		this.player.play();
	},
	
	stash :function()
	{
		
		this.display.css({'top':"-1000%",'left':"-1000%"});
		this.player.pause();
	},

	exit: function(){
		
		this.player.pause();
	}
	
});