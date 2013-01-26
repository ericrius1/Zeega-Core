(function(Items) {

	Items.Model = Backbone.Model.extend({
		defaults : {
			title : 'Untitled'
		},

		url: function()
		{
			return sessionStorage.getItem('hostname') + sessionStorage.getItem('directory') + "api/items/" + this.id;
		},

		initialize : function()
		{
			this.databaseView = new Items.Views.List({model:this});
		}
	});

	Items.SearchModel = Backbone.Model.extend({
		defaults : {
			query : '',
			page : 1,
			content : '-Project',
			collection : '',
			site : sessionStorage.getItem('siteid'),
			add : false
		},

		initialize : function(){
			this.set({user : 1});
		},
		

		update : function( updates ){
			this.set(updates,{silent:true});
			this.trigger('search');
		},

		toggleUserFilter : function (isCommunity){
			if(this.get('user')){
				this.set('user',0);
			} else {
				this.set('user', 1);
			}
			this.reset();

			return this.get('user');
		},

		reset : function( options )
		{
			this.set(this.defaults,options);
			this.trigger('search');

			return this;
		},

		generateQueryURL : function (){
			var base = zeega.app.url_prefix + "api/items/search?sort=date-desc",
				queryTemplate = '&page=<%= page %><% if( query ){ %>&q=<%= query %><% } %><% if(content){ %>&type=<%= content %><% } %><% if(collection){ %>&collection=<%= collection %><% } %>';
			

			if(this.get("user")){
				base += "&user=-1";
			} else if(this.get('collection')==="") {
				base += "&collection=78702";
			}
			

			if(this.get('query') === '' && this.get('user') && this.get('content')==='-Project' || true) {
				base += "&data_source=db";
			}

			return base + _.template( queryTemplate, this.toJSON() );
		}
	});


	Items.Collection = Backbone.Collection.extend({

		model: Items.Model,
		totalItemsCount : 0,

		url: function()
		{
			return this.search.generateQueryURL();
		},

		initialize : function()
		{
			this.itemCollectionView = new Items.Views.ItemTrayCollectionView({collection:this});
			this.search = new Items.SearchModel();
			this.search.on('search', this.onSearch, this );
			this.on('reset', this.onSearchSuccess, this);
			this.on('preview_item',this.previewItem,this); // move this
		},
		
		onSearch : function()
		{
			console.log('onSearch');
			var _this = this;
			this.fetch({add: this.search.get('add')}).success(function(){
				_this.trigger('reset');
			});
		},
		
		incrementPage : function()
		{
			
			if(this.length < this.totalItemsCount)
			{

				var pageNo = this.search.get('page');
				pageNo++;
				this.search.set({ page:pageNo, add:true });
			}
		},

		refresh : function(){ this.fetch(); },

		///// move this ////////////
		previewItem : function(itemID)
		{
			var viewer = new Items.Views.Viewer({collection:this,start:itemID});
			$('body').append(viewer.render().el);
			viewer.renderItemView();
		},

		parse : function(response)
		{
			this.totalItemsCount = response.items_count;
			return response.items;
		}
	});

})(zeega.module("items"));
