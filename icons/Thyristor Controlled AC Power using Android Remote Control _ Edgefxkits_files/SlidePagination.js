/**
 * 
 * @param {Object} rDiv
 */
function SlidePagination(container, paginationDiv, nextBtn, prevBtn, pageCount, activePage, callbackFn, isCorosalReq, imageBaseUrl) {
	this.container = container;
	this.paginationContainer = paginationDiv;
	this.nextBtn = nextBtn;
	this.previousBtn = prevBtn;
	this.pages = pageCount;
	this.callback = callbackFn;
	this.activeNode = activePage;
	this.corosalReq = isCorosalReq;
	this.imageBaseUrl = imageBaseUrl;
	
	if (this.corosalReq == undefined || this.corosalReq == 'undefined') {
		this.corosalReq = true;
	}
	
	
	this.initComp = function() {
		if (this.corosalReq) {
			this.container.insert(edgefx.sliderPages({pages: this.pages, activeNode: this.activeNode, imageBaseUrl: this.imageBaseUrl}));
		}
		this.registerActions();
		this.setElementStates();
	};
	
	/**
	 * To handle resize call
	 */
	this.resize = function() {
	};	
	
	/**
	 * this method simply sets the states of the UI elements correctly based on the currently selected page.
	 */
	this.setElementStates = function() {
		if (this.activeNode == 0){
			//left nav button is disabled
			this.previousBtn.removeClassName("edgefxLeftNavigationEnable").addClassName("edgefxLeftNavigationDisable");
		} else {
			// left nav button should always be enabled!!
			this.previousBtn.addClassName("edgefxLeftNavigationEnable").removeClassName("edgefxLeftNavigationDisable");
		}
		
		if (this.activeNode == this.pages - 1) {
			// if this is the last page, disable right nav button.
			this.nextBtn.removeClassName("edgefxRightNavigationEnable").addClassName("edgefxRightNavigationDisable");
		} else {
			// we should always enable going to next page.
			this.nextBtn.addClassName("edgefxRightNavigationEnable").removeClassName("edgefxRightNavigationDisable");
		}
		
		if (this.corosalReq) {
			for (var i = 0; i < pageCount; i++) {
				this.container.select(".sliderPageNode")[i].update("<img width='10px' height='10px' src='"+this.imageBaseUrl+"skinning-images/assets/pageNavNormal.png'/>");
			}
			var sliderPageNode = this.container.select('.sliderPageNode')[this.activeNode];
			if(sliderPageNode){
				sliderPageNode.update("<img width='10px' height='10px' src='"+this.imageBaseUrl+"skinning-images/assets/pageNavActive.png'/>");
			}
		}
	};
	
	/**
	 * this method just sets up the actions.
	 */
	this.registerActions = function() {
		var _this = this;
		
		if (this.corosalReq) {
			this.registerPageIndexActions();
		}
		
		this.previousBtn.observe("click",function() {
			if (_this.activeNode != 0) {
				_this.activeNode --;
				_this.setElementStates();
				if (_this.callback) {
					_this.callback(_this.activeNode);
				}
			}
		});
		
		this.nextBtn.observe("click",function(){
			if(_this.activeNode != (_this.pages - 1)) {
				_this.activeNode ++;
				_this.setElementStates();
				if (_this.callback) {
					_this.callback(_this.activeNode);
				}
			}
		});		
	};
	
	
	/**
	 * this method registers the actions on the slider pagination buttons. The actions on next/previous buttons are registered separately.
	 * This method only controls the actions on the direct page index buttons.
	 */
	this.registerPageIndexActions = function() {
		var _this = this;
		var sPageNodes = this.container.select(".sliderPageNode");
		for(var i=0; i<sPageNodes.length; i++){
		sPageNodes[i].observe("click", function() {
			//get its page ID
			_this.activeNode = parseInt($(this).readAttribute("rel"));
			_this.setElementStates();
			if (_this.callback)
				_this.callback(_this.activeNode);
		});
		}
	};
	
	
	/**
	 * this method sets the pagination to the correct state when pagination needs to happen externally (programmatically)
	 */
	this.navigateToPage = function(pageIndex) {
		if (pageIndex >= this.pages) {
			return;
		}
		
		this.activeNode = pageIndex;
		this.setElementStates();
		if (this.callback) {
			this.callback(this.activeNode);
		}
	};
	
	/**
	 * this method adds a new page to the pagination control.
	 */
	this.addNewPage = function() {
		var paginationElement = this.paginationContainer.select(".sliderPages")[0];
		paginationElement.append(edgefx.addNewPage({pageIndex: this.pages, active: false}));
		this.pages++;
		this.registerPageIndexActions();
		this.setElementStates();
	};
	
	/**
	 * this method removes a page from the pagination control.
	 */
	this.removePage = function(pageIndex) {
		var pageElement = this.paginationContainer.select('.sliderPageNode[rel="' + pageIndex + '"]')[0];
		pageElement.remove();
		
		if ((this.activeNode == pageIndex && pageIndex == (this.pages - 1))
			|| (this.activeNode > pageIndex)) {
			this.activeNode --;
		}
		
		for (var i = pageIndex + 1; i < this.pages; i++) {
			pageElement = this.paginationContainer.select('.sliderPageNode[rel="' + i + '"]')[0];
			pageElement.attr("rel", (i-1));
		}
		
		this.pages--;
		this.registerPageIndexActions();
		this.setElementStates();
	};
}
