/**
 * @author venkat
 */
var Skinning = Class.create();
Skinning.prototype = {
	initialize : function(skinUrl){
		this.imageBaseUrl = skinUrl;
	},
	isAnimationCompleted : true,
	testFunction : function() {
		//alert("prototype loadded successfully");
		var rDiv = $$("body")[0] && $$("body")[0].select('.edgefxDealsSection')[0];
		if(rDiv){
			var paginationDiv = rDiv.select('.edgefxDealsHolder')[0];
			var dealsValueHolder = rDiv.select('.dealsTopRightValue')[0];
			var nextBtn = rDiv.select('.edgefxRightNavigationButton')[0];
			var prevBtn = rDiv.select('.edgefxLeftNavigationButton ')[0];
			var deals = paginationDiv.select('.deals');
			var pageCnt = deals?deals.length:0;
		}
		if(rDiv && paginationDiv && nextBtn && prevBtn){
			var slidePagination = new SlidePagination(rDiv, paginationDiv, nextBtn, prevBtn, pageCnt, 0, function(pageIndex){
				this.activePage = pageIndex;
			
				var leftX = 0 - (240 * pageIndex) ;
				var dealsPer = 0 - (60 * pageIndex);
				new Effect.Parallel([
					new Effect.Morph(paginationDiv, {style:{marginLeft:leftX + "px"}}),
					new Effect.Morph(dealsValueHolder, {style:{marginLeft:dealsPer + "px"}})],
				{
					duration:0.5
				});
				//paginationDiv.morph({});
				//$('id_of_element').morph({ height: '50px', width: '200px' },
			}, null,this.imageBaseUrl);
		slidePagination.initComp();
		}
		
		//this.drawHeaderLine();
		
	},

	drawHeaderLine : function() {
		var projectHeader = $$("body")[0].select('.edgefxProjectCategoryHeader');
		for ( var i = 0; i < projectHeader.length; i++) {
			var projHeaderW = $(projectHeader)[i].getWidth();
			var categoryLabel = $(projectHeader)[i].select('.edgefxProjectCategoryLabel')[0];
			var showAll = $(projectHeader)[i].select('.edgefxShowAll')[0];
			if (showAll != undefined && showAll != 'undefined') {
				var remainingW = projHeaderW - (categoryLabel.getWidth()+ showAll.getWidth() + 8); 
			} else {
				var remainingW = projHeaderW - (categoryLabel.getWidth());
			}
			$(projectHeader)[i].select('.edgefxLineContainer')[0].setStyle({width:remainingW - 9 + 'px'});
		}
	},


	testAnimateFunction : function() {
		var rDiv = $$("body")[0] && $$("body")[0].select('.headerItem');
		if(rDiv){
			rDiv[0].next('.categorySection').setStyle({display: 'none'});
			for ( var i = 0; i < rDiv.length; i++) {
				rDiv[i].observe("click", this.handleOverlayHeaderItem);
			}
		}
		
	},

	handleOverlayHeaderItem : function(e) {
		var element = e.currentTarget;
		this.animateCurrentItem(element, element.readAttribute('overlayType'), element.readAttribute('status'));
	},


	animateCurrentItem : function(element, overlayType, status) {
	
		if (overlayType == 'categories') {
			this.animateCategoriesSection(element, status);
		} else {
			animateProjectHotDealsSection(status, type);
		}
	},

	animateCategoriesSection : function(element, status) {
		var nextElem = element.next('.categorySection');
		
		if (status == 'closed') {
			new Effect.Appear(nextElem, {afterSetup:function(){
				nextElem.morph({top: 0 + 'px'}, {duration:0.5});
				element.writeAttribute('status', 'opened');
			}});
		
		}else {
			this.isAnimationCompleted = false;
			new Effect.Morph(nextElem, {style:{top: '-' + 543 + 'px'}, duration:0.5, afterFinish:function(){
				new Effect.Fade(nextElem, {duration:0, afterFinish:function(){
					element.writeAttribute('status', 'closed');
					this.isAnimationCompleted = true;
				}});
			}});
		}
		
	},

	doOperations : function() {
		//this.drawHeaderLine();
		var rDiv = $$("body")[0] && $$("body")[0].select('.relatedProjectsHolder ');
		if(rDiv && rDiv.length){
			rDiv.each(function(element){
				var paginationDiv = element.select('.projectSectionsHolder')[0];
				var nextBtn = element.select('.edgefxRightNavigationButton')[0];
				var prevBtn = element.select('.edgefxLeftNavigationButton ')[0];
				var fixedWidth = element.getWidth();
				if(!!nextBtn && !!prevBtn){
					var pageSize = element.select('.relatedProjectsSectionHolder').length;
					element.select('.projectSectionsHolder')[0].style.width = (pageSize * fixedWidth) + "px"; 
					var isCorosalReq = false;
					var slidePagination = new SlidePagination(element, paginationDiv, nextBtn, prevBtn, pageSize, 0, function(pageIndex){
						this.activePage = pageIndex;
						
						var leftX = 0 - (fixedWidth * pageIndex) ;
						paginationDiv.morph({marginLeft:leftX + "px"});
						//$('id_of_element').morph({ height: '50px', width: '200px' },
					}, isCorosalReq);
					slidePagination.initComp();
				}
			});
		}
	}
};
