/**
 * @theme    	efk
 * @package     default
 * @copyright   edgefxteam@divami.com
 */
var PListingClass = Class.create();
PListingClass.prototype = {
	initialize: function() {
		//Calling other class variables
		var sb = new SandBox();
		//click functions here	
		
		/*this.pushState({
                listing: $$('.product-list')[0].innerHTML,
                layer: $('layered-navigation').innerHTML
            }, document.location.href, true);
		*/        
		
		/*History.Adapter.bind(window, 'popstate', function(event) {
	        if (event.type == 'popstate') {
	            var State = History.getState();
	            if(State.data.listing) {
	            	$$('.product-list')[0].update(State.data.listing);	
	            } if(State.data.layer) {
	            	$('layered-navigation').update(State.data.layer);	
	            }
	        }                
	    });*/
		this.stop = false;
		
		sb.attachEvents($$('.fullProjectListSort'), 'click', this.performSort, this);
		sb.attachEvents($('load-more-products'), 'click', this.loadMoreProducts, this);
		sb.attachEvents($('sortVal'), 'click', this.sortListing, this);
		sb.attachEvents($$('.edgefxcategoryHolder'), 'mouseover', this.handleCategoriesHover, this);
		sb.attachEvents($$('.edgefxcategoryHolder .edgefxProjectCategoryListLabelNoPlus, .edgefxcategoryHolder .categoryNumHolder'), 'mouseout', this.handleCategoriesMouseoutFunc, this);
		sb.attachEvents($$('.edgefxcategoryHolder .categoriesSectionHolder'), 'mouseout', this.handleCategoriesMouseout, this);
		var narrowByList = $('narrow-by-list');
		if(narrowByList){
			this.filteringElements = narrowByList.select('input[type="checkbox"]');//$('narrow-by-list').down('dd', 2).select('a');
			sb.attachEvents(this.filteringElements, 'click', this.refreshListing, this);
			this.kitTypeElements = narrowByList.select('input[type="radio"]');
		}
		sb.detachEvents(this.kitTypeElements, 'click', this.refreshListing, this);
		sb.attachEvents(this.kitTypeElements, 'click', this.refreshListing, this);
		
		/* Scroll Top and Lazy loading */
		sb.attachEvents($$('.edgefxContainer'), 'scroll', this.testScroll, this);
		
		/* Show Load-more button if there are more products to load */
		if($$('.next.i-next')[0] && !$$('.fullProjectListingHolder').length) {
	    	if($('load-more-products')) {
	    		$('load-more-products').style.display = "block";
	    	}
	    } else {
	    	if($('load-more-products')) {
	    		$('load-more-products').style.display = "none";
	    	}
	    }
	},
	sb : new SandBox(),
	cookie : new Cookie(),
	
	testScroll : function() {
		var efkBody = $$('.edgefxContainer')[0];
		var screenHeight = efkBody.scrollTop;
        if($$('.scroll-to-top')[0]){
            if(screenHeight > 800){
                $$('.scroll-to-top')[0].style.display = "block";
            }
            else{
                $$('.scroll-to-top')[0].style.display = "none";
            }
        }
        
        /* Apply Lazy Loading */
        var isFullProjectListing = $$('.fullProjectListingHolder');
        if (isFullProjectListing.length && this.stop != true){
	        var totalContainerHeight = $$('.edgefxMainContentHolder')[0].getHeight();
	        var treshold = 75 * totalContainerHeight / 100;
	        if(screenHeight > treshold) {
	        	var isLazyLoad = $$('.next.i-next')[0];
	        	if(isLazyLoad) {
	        		this.stop = true;
	        		$('load-more-products').show();
	        		$('load-more-products').click();
	        	}
	        }
	    }
	},
	
	handleCategoriesHover:function(e) {
		//clear interval for any delay of mouseout
		clearInterval(this.mouseOutDelay);
		//call mouseout function
		this.handleCategoriesMouseout();
		var currentElem = e.currentTarget;
		var offsetVal = currentElem.cumulativeOffset().left;		
		var catSection = currentElem.select('.categoriesSectionHolder')[0];
		if(catSection) {
			if (offsetVal > 700) {
				var curElemW = currentElem.getWidth();
				var tipElem = catSection.select('.categoryTipLine')[0];
				//tipElem
				tipElem.removeClassName('categoriesRightLine');
				tipElem.addClassName('categoriesLeftLine');
				tipElem.setStyle({left: 142 +'px'});
				catSection.setStyle ({display:'block', left: - + (curElemW + 142 + 17)+'px'});
			} else  {
				catSection.setStyle({display: 'block'});
			}
			var catHolder = catSection.select('.projectCategoriesHolder')[0];
			var height = catHolder.getHeight();
			catHolder.setStyle({top: - + (height -20)/2 + 'px' });	
		}
	},
	handleCategoriesMouseoutFunc: function(e){
		this.mouseOutDelay = setInterval(this.handleCategoriesMouseout,700, e);
	},
	handleCategoriesMouseout:function(e) {
		// var currentElem = e.currentTarget;
		// var catSection = currentElem.select('.categoriesSectionHolder')[0];
		// //var catHolder = currentElem.select('.categoriesSectionHolder')[0].select('.projectCategoriesHolder')[0];
		// if(catSection) {
		// 	catSection.setStyle({display:"none"});	
		// }
		$$('.categoriesSectionHolder').each(function(e){
			Element.hide(e);
		});
	},
	
	sortListing : function(e){
		var target = e.currentTarget;
		var value = target.value;
		var mainUrl = value.replace(/&amp;/g, '&');
		var index = target.rel;
		var me = this;
		me.sendSortingRequest(mainUrl, index);
	},
	
	sendSortingRequest : function(url, index){
		var sortingUrl = this.getKitPriceSortOrder(url);

		var params = url.toQueryParams();
		/* Google Analytics for Sorting in project Listing Page */
		this.sb.gaTrack('Project Listing', 'Sort', 'Apply sort on ' + params.order + '-' + params.dir);
		
		var me = this;
		if(this.ajax) {
			this.ajax.transport.abort();
		}
		var elementToBlock = $$('.edgefxProjectCategorySection .product-list')[0];
		this.sb.screenBlocker.hide(elementToBlock);
		this.sb.screenBlocker.show(elementToBlock, true);
		var newSortingUrl = this.sb.removeHTTP(sortingUrl);
		this.ajax = new Ajax.Request(newSortingUrl, {
		  	onSuccess: function(response) {
		  		if(response.statusText == "OK") {
		    		// Handle the response content...
		    		var response = response.responseText.evalJSON().listing;
		    		//create dummy element
		    		var div = document.createElement('div');
		    		div.innerHTML = response;
		    		var html = $(div).select('.edgefxProjectsHolder.project-listing-section')[0].innerHTML;
		    		$$('.edgefxProjectsHolder.project-listing-section')[0].innerHTML = "";
		    		$$('.edgefxProjectsHolder.project-listing-section')[0].innerHTML = html;
		    		
		    		/*me.pushState({
	                    listing: response,
	                    layer: $('layered-navigation')
	                }, sortingUrl, false);*/
	               	me.pushState(null, sortingUrl, true);
	               	me.checkLoadMoreButton();
	               	me.refreshProductEvents();
	                
	                //sb.attachEvents($('sortVal'), 'click', this.sortListing, this);
	                me.sb.screenBlocker.hide(elementToBlock);
               }
		  	}
		});
	},
	
	getKitPriceSortOrder : function(url) {
		var order = decodeURIComponent((new RegExp('[?|&]order=' + '([^&;]+?)(&|#|;|$)').exec(url)||[,""])[1].replace(/\+/g, '%20'))||null;
		if(order && order.indexOf('price') != -1) {
			var cookie = new Cookie();
	    	var kit_type_Cookie = cookie.getCookie('kitTypeName');
	    	if(!kit_type_Cookie) {
				kit_type_Cookie = '126';
			}
	    	var sortPrice = {'125':'readymade_kit_price', '126':'diy_kit_price', '127':'project_kit_price'};
	    	return (url.replace(/order=[\w]+/g, "order=" + sortPrice[kit_type_Cookie]));
		} else {
			return url;
		}
	},
	
	checkLoadMoreButton: function() {
		if($$('.next.i-next')[0]) {
	    	if($('load-more-products')) {
	    		$('load-more-products').style.display = "block";
	    	}
	    } else {
	    	if($('load-more-products')) {
	    		$('load-more-products').style.display = "none";
	    	}
	    }
	},
	
	loadMoreProducts: function(e) {
		if($$('.next.i-next')[0]){
			var isFullProjectListing = $$('.fullProjectListingHolder');
			if (!isFullProjectListing.length) {
				var elementToBlock = $('load-more-products');
				this.sb.screenBlocker.hide(elementToBlock);
				this.sb.screenBlocker.show(elementToBlock);
			}
			
			var nextPageUrl = $$('.next.i-next')[0].readAttribute('href');
			//var nextPage = nextPageUrl.split('?')[1];
			var nextPage = nextPageUrl.match(/(p=[\d]+)/g)[0];
			var separator = (document.location.href.indexOf('?') != -1) ? '&' : '?';
			var loadMoreProductsUrl = document.location.href + separator + nextPage;
			this.sendLoadMoreProductsRequest(loadMoreProductsUrl);
		}
		else{
			//hide button
			$$(e.currentTarget).hide();
		}
	},
	
	sendLoadMoreProductsRequest : function(url){
		var sb = this.sb;
		var me = this;
		if(this.ajax) {
			this.ajax.transport.abort();
		}
		/* Google Analytics for Load more projects */
		this.sb.gaTrack('Project Listing', 'Load More Projects', 'Loading more projects');
		url = this.sb.removeHTTP(url);
		this.ajax = new Ajax.Request(url, {
		  	onSuccess: function(response) {
		  		if(response.statusText == "OK") {
			  		//Create dummy element
			  		var div = document.createElement('div');
			  		div.innerHTML = response.responseText.evalJSON().listing;
			  		//refresh the page class element
			  		var dynamicPages = $(div).select('.pages');
			  		if(dynamicPages.length){
			  			$$('.pages')[0].innerHTML = dynamicPages[0].innerHTML;	
		  			}		  			
			  		var elementToLoad;
			  		if($$('.project-listing-section #catalog-listing').length) {
			  			elementToLoad = $$('.project-listing-section #catalog-listing')[0]; 
			  		} else {
			  			elementToLoad = $$('.project-listing-section')[0];
			  		}
			  		
			  		//append the list to the existing product list
			  		if($(div).select('.fullProjectListingHolder').length) {
			  			elementToLoad.innerHTML += $(div).select('.project-listing-section #catalog-listing')[0].innerHTML;
			  		} else {
			  			elementToLoad.innerHTML += $(div).select('.project-listing-section')[0].innerHTML;
			  		}
			  		//check if there are more products to be loaded or not
			  		if(!$(div).select('.next.i-next')[0]){
			  			$('load-more-products').style.display = "none";
					}
					
					me.checkLoadMoreButton();
					me.refreshProductEvents();
					
					/* Core related to Full project listing Lazy loading */
					var isFullProjectListing = $$('.fullProjectListingHolder');
        			if (isFullProjectListing.length) {
		        		$('load-more-products').hide();
						me.stop = false;		        		
		        	} else {
		        		me.sb.screenBlocker.hide($('load-more-products'));
		        	}
				}
		  	}
		});	
	},
	
	pushState: function(data, link, replace) {
        var History = window.History;
        if ( !History.enabled ) {
            return false;
        }

        if (replace) {
            History.replaceState(data, document.title, link);
        } else {
            History.pushState(data, document.title, link);
        }
    },
		
	refreshListing: function(event) {
		var sb = this.sb;
		var element = event.currentTarget;
		
		var elementToBlock = null;
  		if(document.location.href.indexOf('q=') != -1) {
  			elementToBlock = $$('.edgefxProjectCategorySection .product-list .search_body_container')[0];
  		} else {
  			elementToBlock = $$('.edgefxProjectCategorySection .product-list')[0];
  		}
		sb.screenBlocker.hide(elementToBlock);
		sb.screenBlocker.show(elementToBlock, true);

		if(event.currentTarget.type == "radio") {
			var domain = event.currentTarget.up('#narrow-by-list').readAttribute('domain');
			this.cookie.setCookie('kitTypeName', event.currentTarget.value, 1, domain, '/');
			sb.gaTrack('Project Listing - Filters', element.readAttribute('name'), element.readAttribute('kit-name'));
		} else {
			sb.gaTrack('Project Listing - Filters', element.readAttribute('filter-name'), element.value);
		}
		//Get checked elements	
		var queryArray = this.addQueriesToArray();
		//Hardcoded URL Value
		//var url = $('narrow-by-list').readAttribute('data-filter-url');
		var url = decodeURIComponent(document.location.href);
		//this.sendRefreshListingRequest(url, Object.toQueryString(queryArray));
		this.sendRefreshListingRequest(url, queryArray);
	},
	
	sendRefreshListingRequest : function(url, data) {
		var me = this;
		var sb = this.sb;
		
		/* Modify Kit type price for Sorting */
		url = this.getKitPriceSortOrder(url);
		
		var filterParam = {};
		var urlParams = {};
		var parts = url.replace(/[?&]+([^=&]+)=([^&]*)/gi, function(m, key, value) {
			if(value){
				if(key == "q"){
					value = value.replace("+", " ");
				}
		    	urlParams[key] = value;
			}
		});
		
		//if(data.ratings) {
			filterParam.ratings = data.ratings;
		//} if(data.price) {
			filterParam.pricerange = data.pricerange;
		//} if(data.kittype) {
			filterParam.kittype = data.kittype;
		//}
		
		var parameters = {};
    	for (var attrname in filterParam) { 
    		parameters[attrname] = filterParam[attrname]; 
    	}
    	for (var attrname in urlParams) {
    		var key = parameters[attrname];
    		if(!key && (attrname!='pricerange' && attrname!='ratings' && attrname!='kitytpe')) {
    			parameters[attrname] = urlParams[attrname];
    		} 
    	}
		
		var filterUrl = me.prepareUrl(url, parameters);
		if(this.ajax) {
			this.ajax.transport.abort();
		}
		
		var kit_type_name = null;
		if(parameters['kittype'] == '126') {
			kit_type_name = 'DIY Kit';
		} else if(parameters['kittype'] == '125') {
			kit_type_name = 'Readymade Kit';
		} else if(parameters['kittype'] == '127') {
			kit_type_name = 'Project Kit';
		}
		url = url.split('?')[0];
		url = this.sb.removeHTTP(url);
		this.ajax = new Ajax.Request(url, {
			parameters: parameters,
			method : 'get',
		  	onSuccess: function(response) {
		  		if(response.statusText == "OK") {
		  			//Create dummy element
			  		var div = document.createElement('div');
			  		div.innerHTML = response.responseText.evalJSON().listing;
			  		var elementToBlock = null;
			  		if(document.location.href.indexOf('q=') != -1) {
			  			elementToBlock = $$('.edgefxProjectCategorySection .product-list .search_body_container')[0];
			  		} else {
			  			elementToBlock = $$('.edgefxProjectCategorySection .product-list')[0];
			  		}
			  		
			  		elementToBlock.innerHTML = div.innerHTML;
			  		var dropdownScript = document.getElementById('dropDownScript');
			  		if(dropdownScript){
				  		eval(dropdownScript.innerHTML);
				  	}
			  		me.pushState({
	                    listing: div.innerHTML,
	                    layer: $('layered-navigation').innerHTML
	                }, filterUrl, false);
	                me.checkLoadMoreButton();
	                
	                me.refreshProductEvents();	                
	                sb.attachEvents($('load-more-products'), 'click', me.loadMoreProducts, me);
					sb.attachEvents($('sortVal'), 'click', me.sortListing, me);
					sb.screenBlocker.hide(elementToBlock);
					
					sb.gaTrack('Project Listing - Filters', 'Results', kit_type_name + '; ' + parameters['pirce'] + '; ' + parameters['ratings']);
		  		}
		  	}
		});
	},
	
	performSort : function(event) {
		event.stop();
		var me = this;
		var sb = this.sb;
		var element = event.currentTarget;
		var sortIcon = element.down('.sortIcon');
		var order = sortIcon.readAttribute('order');
		var dir = null;
		if(sortIcon.hasClassName('fullProjectListAsc')) {
			dir = 'desc';
		} else {
			dir = 'asc';
		}
		var sortColumnName = element.classList[0];
		
		var elementToBlock = $$('.product-list')[0];
		sb.screenBlocker.hide(elementToBlock);
		sb.screenBlocker.show(elementToBlock, true);
		
		var url = $('fullprojecturl').readAttribute('url');
		var parameters = {};
		parameters['dir'] = dir;
		parameters['order'] = order;		
		
		var prepareUrl = url + '?dir=' + dir + '&order=' + order;
		/* Google Analytics for full project listing sorting */
		this.sb.gaTrack('Full Project Listing', 'Sort', 'Apply sort on ' + order + '-' + dir);
		url = this.sb.removeHTTP(url);
		this.ajax = new Ajax.Request(url, {
			parameters: parameters,
			method : 'get',
		  	onSuccess: function(response) {
		  		if(response.statusText == "OK") {
		  			//Create dummy element
			  		var div = document.createElement('div');
			  		div.innerHTML = response.responseText.evalJSON().listing;
			  		elementToBlock.innerHTML = div.innerHTML;

					sb.attachEvents($('load-more-products'), 'click', me.loadMoreProducts, me);
					sb.attachEvents($$('.fullProjectListSort'), 'click', me.performSort, me);
					sb.screenBlocker.hide(elementToBlock);
					var element = $$('.fullProjectListingHeader th.' + sortColumnName)[0];
					
					me.pushState(null, prepareUrl, true);
		  		}
		  	}
		});
	},
	
	refreshProductEvents : function() {
		var sb = this.sb;
		var compareCheck = new Compare();
		sb.detachEvents($$('.compare-chk'), 'click');
		sb.attachEvents($$('.compare-chk'), 'click', compareCheck.addCompareProduct, compareCheck);
		var quickView = new QuickViewClass();
		sb.detachEvents($$('.edgefxQuickViewHolder'), 'click');
		sb.attachEvents($$('.edgefxQuickViewHolder'), 'click', quickView.getQuickView, quickView);
		var video = new PopupClicksClass();
		sb.detachEvents($$('.popup-video-link'),'click');
		sb.attachEvents($$('.popup-video-link'),'click',video.showVideo, video);
		var cart = new PopupCartClass({codLimit:20000});
		sb.detachEvents($$('.product-add-to-cart'),'click');
		sb.attachEvents($$('.product-add-to-cart'),'click',cart.addToCart, cart);
		
		sb.attachEvents($$('.edgefxcategoryHolder'), 'mouseover', this.handleCategoriesHover, this);
		sb.attachEvents($$('.edgefxcategoryHolder .edgefxProjectCategoryListLabelNoPlus, .edgefxcategoryHolder .categoryNumHolder'), 'mouseout', this.handleCategoriesMouseoutFunc, this);
		sb.attachEvents($$('.edgefxcategoryHolder .categoriesSectionHolder'), 'mouseout', this.handleCategoriesMouseout, this);
	},
		
	prepareUrl: function(url, params) {
		url = url.split('?')[0] + '?';
		var i = 1;
		for (var attrname in params) {
			url += ((i++ > 1)?'&':'') + attrname + '=' + params[attrname];
		}
		return url;
	},
	
	getQueryString: function(url) {
		var splitUrl = url.match(/((?!\?).)*$/);
		return splitUrl[0]?splitUrl[0]:"";	
	},
	
	addQueriesToArray: function(){
		var obj = {};
		var checkedElements = this.getCheckedElements(this.filteringElements);
		var radioElements = this.getCheckedElements(this.kitTypeElements)[0];
		var price = '';
		var ratings = '';
		for(var i = 0; i < checkedElements.length; i++){
			var filterName = checkedElements[i].readAttribute('filter-name');
			var value = checkedElements[i].readAttribute('value');
			if(filterName == "Price") {
				price += (!price.length)? value : ',' + value;
			} else if(filterName == "Ratings") {
				ratings += (!ratings.length)? value : ',' + value;
			}
			obj.ratings = ratings;
			obj.pricerange = price;
		}
		if(!obj.pricerange) {
			obj.pricerange = '';
		}
		if(!obj.ratings) {
			obj.ratings = '';
		}
		obj.kittype = radioElements.value;
		return obj;
	},
	
	getCheckedElements: function(e) {
		//return e.filter(function(){return this.select('input[type="checkbox"')[0].checked;});
		var arr = [];
		for(var i=0; i < e.length; i++){
			var el = e[i];
			if(el.checked){
				arr.push(el);
			}
		}
		return arr;
	}
};

document.observe("dom:loaded", function() {
	ProjectListing = new PListingClass();
});