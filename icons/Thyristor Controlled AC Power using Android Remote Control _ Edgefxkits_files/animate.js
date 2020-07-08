/**
 * @author venkat
 */
var Animate = Class.create();
Animate.prototype = {
	initialize : function(skinUrl){
		this.testAnimateFunction();
	},
	
	firstElemHeight : 0,
	statusContainer :{"findProject": "closed", "hotDeals":"closed"},
	isCategoryOpen: false,
	testAnimateFunction : function() {
		var rDiv = $$("body")[0].select('.headerItem');
		if(!rDiv.length){
			return;
		}
		firstElemHeight = rDiv[0].next('.contentSection').getHeight();
		for ( var i = 0; i < rDiv.length; i++) {
			var height = rDiv[i].next('.contentSection').getHeight();
			rDiv[i].next('.contentSection').setStyle({top: '-' + height + 'px', display: 'none'});
			Event.observe(rDiv[i], "click", this.handleOverlayHeaderItem.bind(this));
		}		
	},
	
	
	handleOverlayHeaderItem : function(e) {
		try{
			var element = e.currentTarget;
			this.animateCurrentItem(element, element.readAttribute('overlayType'), element.readAttribute('status')).bind(this);
		}
		catch(ex){
			//console.log(ex);
		}
	},
	
	
	/**
	 * This function animastes the the item based on the type
	 * it receives.
	 */
	animateCurrentItem : function(element, overlayType, status) {
		try{
			if (overlayType == 'categories') {
				this.animateCategoriesSection(element, status).bind(this);
			} else {
				var nextElem = element.next('.contentSection');
				
				var toggleElem = nextElem.select('.toggleImage');
				Event.observe(toggleElem[0], "click", this.handleInnerHeaderItem.bind(this));
				this.animateRightSection(element, status, nextElem, overlayType).bind(this);
				
				
			} 
		}
		catch(ex){
			//console.log(ex);
		}
	},
	
	
	/**
	 * This function changes the state of the image.
	 */
	toggleImage: function(element){
		var imgElement = $(element).select('.allCatImgHolder')[0];
		if(/allCatImgCollapse/g.test(imgElement.className)){
			imgElement.removeClassName('allCatImgCollapse');
			imgElement.addClassName('allCatImgExpand');
		}
		else if(/allCatImgExpand/g.test(imgElement.className)){
			imgElement.addClassName('allCatImgCollapse');
			imgElement.removeClassName('allCatImgExpand');
		}
		else if(/rightHeaderImgExpand/g.test(imgElement.className)){
			imgElement.addClassName('rightHeaderImgCollapse');
			imgElement.removeClassName('rightHeaderImgExpand');
		}
		else if(/rightHeaderImgCollapse/g.test(imgElement.className)){
			imgElement.addClassName('rightHeaderImgExpand');
			imgElement.removeClassName('rightHeaderImgCollapse');
		}
	},
	
	/**
	 * This function animates the categories section 
	 */
	
	animateCategoriesSection: function(element, status) {
		var nextElem = element.next('.categorySection');
		var edgefxContainer = $$('.edgefxMainContentHolder.edgefxCenterContainer')[0];
		var me = this;
		if (status == 'closed') {
			if(!me.isCategoryOpen) {
				this.toggleImage(element);
				element.writeAttribute('status', 'opened');
			} else {
				return;
			}
			this.edgefxContainerAction(edgefxContainer, 'hidden');
			new Effect.Appear(nextElem, {afterSetup:function(){
				nextElem.morph({top: 35 + 'px'}, {duration:0.5, afterFinish: function(){
					me.edgefxContainerAction(edgefxContainer, 'visible');
					me.isCategoryOpen = true;
				}});
			}});
			// this.edgefxContainerAction.delay(0.6, edgefxContainer, 'visible');
			// this.isCategoryOpen = true;
		}			
		else {
			if(me.isCategoryOpen) {
				this.toggleImage(element);
				element.writeAttribute('status', 'closed');
			} else {
				return;
			}
			this.edgefxContainerAction(edgefxContainer, 'hidden');
			new Effect.Morph(nextElem, {style:{top: '-' + firstElemHeight + 'px'}, duration:0.5, afterFinish:function(){
				new Effect.Fade(nextElem, {duration:0, afterFinish:function(){
					me.isCategoryOpen = false;
				}});
			}});
		}		
	},
	edgefxContainerAction: function(edgefxContainer, overflowValue){
		edgefxContainer.setStyle({
			'overflow': overflowValue
		});
	},
	
	
	/**
	 * This function animates the right section
	 */
	animateRightSection: function(element, status, nextElement, overlayType) {
		var nextElem = nextElement;
		var edgefxContainer = $$('.edgefxMainContentHolder.edgefxCenterContainer')[0];
		var me = this;
		if (status == 'closed') {
			this.edgefxContainerAction(edgefxContainer, 'hidden');
			new Effect.Appear(nextElem, {duration:0, afterUpdate:function(){
				//new Effect.Fade(element);
			},afterFinish:function(){ 
			new Effect.Morph(nextElem,{style:{top: 0 + 'px'}, duration:0.5, afterFinish:function(){
					nextElem.addClassName('animatedBorder');
					me.statusContainer[overlayType] = 'opened';
					if (me.statusContainer.findProject == 'opened' && me.statusContainer.hotDeals == 'opened'){
						$$('.dealsSection')[0].addClassName('noBorderLeft');
						$$('.dealsSection')[0].setStyle({width: $$('.dealsSection')[0].getWidth()  + 'px'});
					}
					var action = me.isCategoryOpen?"visible":"hidden";
					me.edgefxContainerAction(edgefxContainer, action);
				}});
			}});
		}					
		else {
			this.edgefxContainerAction(edgefxContainer, 'hidden');
			new Effect.Morph(nextElem, {style:{top: '-' + 360 + 'px'}, duration:0.5, afterUpdate:function(){
				//new Effect.Appear(element,{duration:0.5});
			},
				afterFinish:function(){
				new Effect.Fade(nextElem, {duration:0, afterFinish:function(){
					if (me.statusContainer.findProject == 'opened' || me.statusContainer.hotDeals == 'opened'){
						$$('.dealsSection')[0].removeClassName('noBorderLeft');
						$$('.dealsSection')[0].setStyle({width: 236 + 'px'});
					} 
					//element.writeAttribute('status', 'closed');
					var action = me.isCategoryOpen?"visible":"hidden";
					me.edgefxContainerAction(edgefxContainer, action);
				}});
			}});
		}		
	},
	
	
	/**
	 * This function gets triggered when user clicks on the overlay toggler.
	 */
	handleInnerHeaderItem:function(e) {
		var me = this;
		try {
			var element = e.currentTarget;
			var status = element.readAttribute('status');
			var nextElement = element.up('.contentSection');
			var headerElem = nextElement.previousSiblings('.rightHeaderItem');
			var type = element.readAttribute('overlayType');
			me.statusContainer[type] = 'closed';
			me.animateRightSection(headerElem[0], status, nextElement, type).bind(this);
			
		} 
		catch(e) {
			
		}
		
	}
};

document.observe("dom:loaded", function() {
	animate = new Animate();
});