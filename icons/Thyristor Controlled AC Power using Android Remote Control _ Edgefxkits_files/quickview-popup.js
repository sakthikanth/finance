/**
 *
 * @theme    efk
 * @package     default
 * @copyright   edgefxteam@divami.com
 */
var QuickViewClass = Class.create(); 
QuickViewClass.prototype = {
	initialize : function(){
		var sb = this.sb;
		this.compare = (comparing)?comparing: new Compare();
		var quickViewIcons = $$('.edgefxQuickViewHolder');
		if(quickViewIcons.length){
			sb.attachEvents(quickViewIcons, 'click', this.getQuickViewOnClick, this);
		}
		document.onkeydown = function(e) {
    		if(e.keyCode == 27){
			this.closePopup();
		}}.bind(this);
	},
	sb : new SandBox(),
	compare : new Compare(),
	popupTemplateObject : new PopupTemplateClass(),
	quickViewComplete : function(response){
		//enable previous and next buttons
		$$('.btnposition').each(function(element){
			element.disabled = false;
			//reset image
			if(Element.hasClassName(element, 'prev-button-img-disabled')){
				element.removeClassName('prev-button-img-disabled');
				element.addClassName('prev-button-img');
			}
			else if(Element.hasClassName(element, 'next-button-img-disabled')){
				element.removeClassName('next-button-img-disabled');
				element.addClassName('next-button-img');
			}
		});
	},
	onSuccess : function(response){
		console.log('success');
	},
	onFailure : function(response){
		console.log('failure');
	},
	getQuickViewOnClick: function(event){
		this.sb.gaTrack('quick view', 'show quick view', 'clicked on quick view icon');
		this.getQuickView(event);
	},
	getQuickView : function(event){
		if(event.currentTarget){
			event.preventDefault();			
		}
		//disable previous and next buttons
		$$('.btnposition').each(function(element){
			element.disabled = true;
			//keep disabled images
			if(Element.hasClassName(element, 'prev-button-img')){
				element.removeClassName('prev-button-img');
				element.addClassName('prev-button-img-disabled');
			}
			else if(Element.hasClassName(element, 'next-button-img')){
				element.removeClassName('next-button-img');
				element.addClassName('next-button-img-disabled');
			}
		});

		var currentTarget = event.currentTarget || event;
		var url = currentTarget.readAttribute('href');
		var headerTitle = currentTarget.up('.edgefxProjectContentHolder').select('.edgefxProjectTitle')[0].textContent;
		
		this.popupTemplateObject.showPopUpOnPageLoad({
									"headerTitle": headerTitle,
									"minH": "520px",
									"commonPopupCls": ['quickViewContainer', 'quickview-title-ellipsis']
							});
		
		//book mark the current item with a class name
		var currentItem = currentTarget.up('.edgefxProjectContentHolder');
		$(currentItem).addClassName('current-quick-view');
		
		url = this.sb.removeHTTP(url);
		var request = new Ajax.Request(
            url,
            {
                method:'post',
                onComplete: this.quickViewComplete.bind(this),
                onSuccess: this.showQuickView.bind(this),
                onFailure: this.failure
            }
        );
	},
	showQuickView : function(data){
		var popupTemplateObject = this.popupTemplateObject;
		var domElement = new Element('div');
		domElement.insert(data.responseText);
		var quckView = $(domElement).select('.edgefxpopupContainer.QuickView')[0];
		popupTemplateObject.showPopup(quckView);
		this.attachEvents();
		this.sb.imagesPreloading();
		this.hideNavButtons();
		//show 2px border to the first image item in the image list.
		this.resetBorderStyle($$('.image-list-ul .image-list-item.default-highlight')[0]);
	},
	hideNavButtons: function(){
		//Hide nav button
		var projectsList = $$('.current-quick-view')[0].up('.edgefxProjectsHolder').select('.edgefxProject');
		var index = $$('.current-quick-view')[0].previousSiblings().size();
		var projectsListLength = projectsList.length;
		//elements
		var previous = $$('.prev-button-img')[0];
		var next = $$('.next-button-img')[0];
		if(index == 0){
			//hide previous nav button
			Element.hide(previous);
			//show next nav button
			Element.show(next);
		}
		else if(index == (projectsListLength-1)){
			//hide next nav button
			Element.hide(next);
			//show previous nav button
			Element.show(previous);
		}
		else{
			//show next nav button
			Element.show(next);
			//show previous nav button
			Element.show(previous);
		}
	},
	attachEvents : function(){
		var popup = $('popup-container');
		var sb = this.sb;
		var compare = this.compare;
		sb.attachEvents($(popup).select('.image-list'), 'click', this.showImageInImageViewer, this);
		sb.attachEvents($(popup).select('.video-list-link'), 'click', this.showVideoInPopup, this);
		sb.attachEvents($(popup).select('.notify-me'), 'click', this.showNotifyOverlay, this);
		sb.attachEvents($$('.edgefxpopupCloseHolder'), 'click', this.closePopup, this);
		sb.attachEvents($$('.prev-button-img'), 'click', this.openPreviousProduct, this);
		sb.attachEvents($$('.next-button-img'), 'click', this.openNextProduct, this);
		//sb.attachEvents($$('body'), 'click', this.hideOverlays, this);
		//compare related events
		var compareCheck = $(popup).down('.compare-chk');
		//detach compare check event
		sb.detachEvents(compareCheck, 'click', compare.addCompareProduct);
		//attach compare check event
		sb.attachEvents(compareCheck, 'click', compare.addCompareProduct, compare);
		compare.refreshCheck();
		//scrollbar
		this.scrollKit();
		popupCart.attachProjectDetailsEvents(popup);
	},
	scrollKit: function(){
		var scrollElement = $$('.quickSummaryWrapper')[0];
		var height = scrollElement.offsetHeight;
	    var scrollHeight = scrollElement.scrollHeight;
	    var scrollPercentage = (height / scrollHeight);
	    var scrollBarElement = $$('.scroll-bar')[0];
	    if(scrollHeight > height + 5){
		    scrollBarElement.setStyle({
		    	height: (height * scrollPercentage) + "px",
		    	top: "10px"
		    });
			this.sb.attachEvents(scrollElement,'scroll',this.scrollBar);
		}
		else{
			Element.hide(scrollBarElement);
		}
	},
	scrollBar: function (e) {
		var elem = e.currentTarget;
	    var height = elem.offsetHeight;
	    var scrollHeight = elem.scrollHeight;
	    var scrollTop = elem.scrollTop;
	    var percentage = (height / scrollHeight);
	    var barPosition = 10 + scrollTop * percentage;
	    var scrollBar = $$('.scroll-bar')[0];
	    scrollBar.setStyle({
	        top: barPosition + "px"
	    });
	},
	openPreviousProduct : function(){ 
		//hide video viewer
		var videoViewer = $$('.video-viewer')[0];
		Element.hide(videoViewer);
		var current = $$('.current-quick-view')[0];
		
		//Get previous element
		var prev = Element.previous($(current), 0);
		if(prev){  //run if there is previous element
			//remove if current class name is present already
			prev.removeClassName('current-quick-view');
			//remove current class name from current element
			current.removeClassName('current-quick-view');
			//get quick view component of previous element
			var quickView = prev.select('.edgefxQuickViewHolder')[0];
			if(quickView){
				this.getQuickView(quickView);
			}
			//enabling the next button
		}
		else{
			//disable the button
		}
	},
	openNextProduct : function(){
		//hide video viewer
		var videoViewer = $$('.video-viewer')[0];
		Element.hide(videoViewer);
		var current = $$('.current-quick-view')[0];
		//Get previous element
		var next = Element.next($(current), 0);
		if(next){  //run if there is previous element			
			//remove if current class name is present already
			next.removeClassName('current-quick-view');
			//remove current class name from current element
			current.removeClassName('current-quick-view');
			//get quick view component of previous element
			var quickView = next.select('.edgefxQuickViewHolder')[0];
			if(quickView){
				this.getQuickView(quickView);
			}
			//enabling the previous button
		}
		else{
			//disable the button
		}
	},
	closePopup : function(e){
		//remove quick view class name
		var currentQuickView = $$('.current-quick-view');
		var popUpContainerElem = $('popup-container');
		if(currentQuickView.length){
			$$('.current-quick-view').each(function(element){
				element.removeClassName('current-quick-view');
			});	
			//Clearing the content in the popup-container since everytime we are rendering the pop-up from scratch
			popUpContainerElem.update();
			//Hide element
			Element.hide(popUpContainerElem);
		}
	},
	showImageInImageViewer: function(e){
		this.sb.gaTrack('quick view', 'show image in image viewer', 'clicked on image list item');
		var sb = this.sb;
		var currentElem = e.currentTarget;
		var popup = currentElem.up('#popup-container');
		this.resetBorderStyle(currentElem.up('li'));
		//show image
		var image = $('image');
		Element.show(image);
		//hide video viewer
		var videoViewer = popup.down('.video-viewer');
		Element.hide(videoViewer);
		image.src = sb.getAttribute(e.currentTarget, 'data-smallsrc');

		var listItem = e.currentTarget && e.currentTarget.up().up();
		var index = $(listItem).previousSiblings().size();
		image.setAttribute('data-index', index);
	},
	showVideoInPopup: function(e){
		this.sb.gaTrack('quick view', 'show video in image viewer', 'clicked on video list item icon to show video in image viewer');
		var currentElem = e.currentTarget;
		var popup = currentElem.up('#popup-container');
		//reset border styling
		this.resetBorderStyle(currentElem.up('li'));
		//show image
		var image = $('image');
		Element.hide(image);
		//hide video viewer
		var videoViewer = popup.down('.video-viewer');
		Element.show(videoViewer);
		//resetting src to stop the video in image viewer
		var src = currentElem.readAttribute('data-href');
		videoViewer.setAttribute('src', src);
	},
	showNotifyOverlay: function(e){
		var notifyForm = $$('.notify-overlay')[0];
		var display = notifyForm.style && notifyForm.style.display;
        notifyForm.style.display = display == "none"?"block":"none";
	},
	resetBorderStyle: function(currentElem){
		$$(".more-views")[0].select("li").each(function(element){
			element.setStyle({"border":""});
		});
		currentElem.setStyle({"border":"2px solid #174762"});
	}
};
document.observe("dom:loaded", function() {
	var quickViewObject = new QuickViewClass();
});