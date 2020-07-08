/**
 * @theme    	efk
 * @package     default
 * @copyright   edgefxteam@divami.com
 */
var TestimonialClass = Class.create();
TestimonialClass.prototype = {
	initialize: function() {
		//Calling other class variables
		var sb = new SandBox();
		this.stop = false;
		
		sb.attachEvents($('load-more-testimonials'), 'click', this.loadMoreProducts, this);
		
		/* Show Load-more button if there are more products to load */
		if($$('.nextUrl')[0]) {
	    	if($('load-more-testimonials')) {
	    		$('load-more-testimonials').style.display = "block";
	    	}
	    } else {
	    	if($('load-more-testimonials')) {
	    		$('load-more-testimonials').style.display = "none";
	    	}
	    }
	},
	sb : new SandBox(),
	cookie : new Cookie(),
	
	checkLoadMoreButton: function() {
		if($$('.nextUrl')[0]) {
	    	if($('load-more-testimonials')) {
	    		$('load-more-testimonials').style.display = "block";
	    	}
	    } else {
	    	if($('load-more-testimonials')) {
	    		$('load-more-testimonials').style.display = "none";
	    	}
	    }
	},
	
	loadMoreProducts: function(e) {
		if($$('.nextUrl')[0]){
			
			var elementToBlock = $('load-more-testimonials');
			this.sb.screenBlocker.hide(elementToBlock);
			this.sb.screenBlocker.show(elementToBlock);
			
			var nextPageUrl = $$('.nextUrl')[0].readAttribute('href');
			//var nextPage = nextPageUrl.split('?')[1];
			var nextPage = nextPageUrl.match(/(p=[\d]+)/g)[0];
			var separator = (document.location.href.indexOf('?') != -1) ? '&' : '?';
			var loadMoreProductsUrl = document.location.href + separator + nextPage;
			this.sendLoadMoreProductsRequest(nextPageUrl);
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
		  			var elementToBlock = $('load-more-testimonials');
					sb.screenBlocker.hide(elementToBlock);
					
			  		//Create dummy element
			  		var div = document.createElement('div');
			  		div.innerHTML = response.responseText.evalJSON().listing;
			  		//refresh the page class element
			  		var dynamicPages = $(div).select('.pages');
			  		if(dynamicPages.length){
			  			$$('.pages')[0].innerHTML = dynamicPages[0].innerHTML;	
		  			} else {
		  				$$('.pages')[0].innerHTML = '';
		  			}	  			
			  		var elementToLoad;
			  		if($$('.custom_testimonials').length) {
			  			elementToLoad = $$('.custom_testimonials')[0]; 
			  		} else {
			  			elementToLoad = $$('.custom_testimonials')[0];
			  		}
			  		
			  		//append the list to the existing product list
			  		if($(div).select('.fullProjectListingHolder').length) {
			  			elementToLoad.innerHTML += $(div).select('.custom_testimonials')[0].innerHTML;
			  		} else {
			  			elementToLoad.innerHTML += $(div).select('.custom_testimonials')[0].innerHTML;
			  		}
			  		//check if there are more products to be loaded or not
			  		if(!$(div).select('.nextUrl')[0]){
			  			$('load-more-testimonials').style.display = "none";
					}
					
					me.checkLoadMoreButton();
					//me.refreshProductEvents();
				}
		  	}
		});	
	},
	
};

document.observe("dom:loaded", function() {
	testimonial = new TestimonialClass();
});