var PopupTemplateClass = Class.create();
PopupTemplateClass.prototype = {
	initialize : function(){
		
	},
	sb: new SandBox(),
	showPopUpOnPageLoad: function(popUpModelObj) {
		//This routine is used to display a default pop-up to user when UI is getting popup data from Middle-ware(PHTML)
		//This is routine is also used to show a blocker on the popup content when pop-up is refreshed with new data
		var popUpHolderElem = $('popup-container');
		popUpModelObj.emptyFlag = (popUpModelObj.emptyFlag != undefined) ?  popUpModelObj.emptyFlag : false;
		
		if(popUpHolderElem.empty() || popUpModelObj.emptyFlag) {
			//We reach here if the pop-up default display
			var domElement = new Element('div');
			
			domElement.insert(edgefx.popUpLayoutTemplate({
										titleText : popUpModelObj.headerTitle, 
										minH : popUpModelObj.minH,
										popupVarCls: popUpModelObj.commonPopupCls 
									}));
			var holderElem = $(domElement).select('.' + popUpModelObj.commonPopupCls[0])[0];
			var loaderElem = $(domElement).select('.screenLoaderHolder')[0];
			var closeElem = $(domElement).select('.edgefxpopupCloseHolder')[0];
			this.sb.screenBlocker.show(loaderElem, true);
			popUpHolderElem.show();
			this.showPopup(holderElem);
			
			this.sb.attachEvents(closeElem, 'click', this.closePopup, this);
		} else {
			//We reach here if the pop-up is not empty
			//Here we only change the header title
			//popUpHolderElem.select('.edgefxpopupTitle')[0].textContent = popUpModelObj.headerTitle;
			this.sb.screenBlocker.show(popUpHolderElem.select('.popUpContentHolder')[0], true);
		}
	},
	getVideoPopupTemplate : function (url, title){
		var html = "";
		if(url.length > 1){
			html = '<div class="edgefxpopupContainer borderBottomRadius pRelative"><div class="edgefxpopupHeader"><div class="edgefxpopupTitle video-max-width-ellipsis fontOpenBold font_15 textColorEAF3F3 leftFloat">'+ title + '</div><div class="popup-close-button edgefxpopupCloseFunction edgefxSpriteImage curPointer rightFloat"></div></div><div class="video-popup"><iframe width="560" height="315" src="' + url + '" frameborder="0" allowfullscreen></iframe></div></div>';
		}
		else{
			html = '<div class="edgefxpopupContainer borderBottomRadius pRelative"><div class="edgefxpopupHeader"><div class="edgefxpopupTitle video-max-width-ellipsis fontOpenBold font_15 textColorEAF3F3 leftFloat">'+ title + '</div><div class="popup-close-button edgefxpopupCloseFunction edgefxSpriteImage curPointer rightFloat"></div></div><div class="video-popup"><div class="no-video-output">No video to show</div></div></div>';
		}
		$('popup-container').show();
		this.showPopup(html);
	},
	getLargeImagePopupTemplate : function(src, title){
		var html = '<div class="edgefxpopupContainer quickViewContainer borderBottomRadius pRelative"><div class="edgefxpopupHeader"><div class="edgefxpopupTitle image-popup-ellipsis fontOpenBold font_15 textColorEAF3F3 leftFloat" title="'+ title +'">'+ title +'</div><div class="popup-close-button edgefxpopupCloseFunction edgefxSpriteImage  curPointer rightFloat"></div></div><div class="prev-button-img prev-img curPointer btnposition quick-left-arrow edgefxSpriteImage"></div><div class="next-button-img next-img btnposition curPointer quick-right-arrow edgefxSpriteImage"></div><div class="image-popup-body popup-body"><img class="large-image popup-large-image" src="'+src+'"/><div class="zoom-status-holder expand curPointer" title="Expand image"></div></div></div>';
		//html += '<script>sb.attachEvents($$(".popup-close-button"), "click",this.openImagePopup, this);</script>'
		$('popup-container').show();
		this.showPopup(html);
	},	
	showPopup : function(html){
		var sb = this.sb;
		var popupContainer = $('popup-container');
		
		//Avoiding the display of the data from PHTML if the pop-up is closed by user before the success callback is triggered
		if(popupContainer.style.display != "none") {
			popupContainer.update(html);
			popupContainer.show();
			var dataContainer = popupContainer.select('.edgefxpopupContainer');
			sb.showPopupInMiddle(dataContainer[0]);
			this.attachPopupEvents(popupContainer);
		}	
	},
	showOtherPopup : function(popupContainer, isDelete){
		var sb = this.sb;
		// var popupContainer = $('popup-container');
		// popupContainer.update(html);
		popupContainer.show();
		var dataContainer = popupContainer.select('.edgefxpopupContainer');
		sb.showPopupInMiddle(dataContainer[0]);
		this.attachOtherPopupEvents(popupContainer, isDelete);
	},
	showAlertPopup : function(data){
		var buttons = data.buttons;
		var btnhtml = '';
		var hasHeaderCls = 'alertnoheader';
		for(var i=0; i<buttons.length; i++){
			btnhtml += '<div class="textAlignCen popupButton rightFloat borderRadius textColorFF font_16 fontOpenSemiBold curPointer '+buttons[i].classnames+'">'+buttons[i].text+'</div>';
		}
		var toolbar = data.toolbar;
		var toolbarhtml = '';
		for(var j=0; j<toolbar.length; j++){
			toolbarhtml += '<div class="popup-close-button edgefxpopupCloseFunction edgefxSpriteImage curPointer rightFloat '+toolbar[j].classnames+'">'+toolbar[j].text+'</div>';
		}
		var html = '<div class="edgefxpopupContainer borderRadius pRelative">';
		if(data.hasHeader){
			hasHeaderCls = '';
			html += '<div class="edgefxpopupHeader borderTopRadius">'+
							'<div class="edgefxpopupTitle image-popup-ellipsis fontOpenBold font_15 textColorEAF3F3 leftFloat">'+ data.title +'</div>'+
							toolbarhtml+
						'</div>';
		}
		html += '<div class="efx-content-holder borderBottomRadius '+hasHeaderCls+'">'+
					'<div class="errorMSGHolder displayInlineBlock higherCOD pRelative">' +
						'<div class="edgefxSpriteImage emptyCartIconHolder bigIconAlign"></div>'+
						'<div class="error-message errorMessage textColor47 font_16">'+data.message+'</div>'+
					'</div>'+
				'</div>'+
				'<div class="popupFooterButtonHolder displayInlineBlock">'+ btnhtml +'</div>'+
			'</div>';
		var sb = this.sb;
		var popupContainer = $('alert-container');
		popupContainer.update(html);
		popupContainer.show();
		var dataContainer = popupContainer.select('.edgefxpopupContainer');
		sb.showPopupInMiddle(dataContainer[0]);
		if(data.events){
			//popu specific events 
			this.attachAlertEvents(popupContainer, data.events);
		}else{
			//pop default events if there are no specific events
			this.attachPopupEvents(popupContainer);
		}
	},
	attachAlertEvents : function(popupContainer, events){
		var event = '';
		var sb = this.sb;
		var elements = ''; 
		for(var i=0; i<events.length; i++){
			event = events[i];
			elements = $(popupContainer).select('.'+event.classname);
			sb.attachEvents(elements,event.name,event.handler);
		}
	},
	attachPopupEvents : function(popupContainer){
		var sb = this.sb;
		if(popupContainer){
			var closePopupBtn = $(popupContainer).select('.popup-close-button');
			sb.attachEvents(closePopupBtn,'click',this.closePopup,this);
			sb.attachEvents(document, 'keydown', this.closePopupOnEsc, this.closePopup);
		}
	},
	attachOtherPopupEvents: function(popupContainer, isDelete){
		var sb = this.sb;
		var closePopupBtn = $(popupContainer).select('.popup-close-button');
		var func = isDelete?'closePopup':'hidePopup';
		sb.attachEvents(closePopupBtn,'click',this[func],this);
		sb.attachEvents(document, 'keydown', this.closePopupOnEsc, this[func]);
	},
	closePopupOnEsc: function(e){
		if(e.keyCode == 27){
			// layered priority wise
			var couponPopup = $('coupon-popup-container');
			var normalPopup = $('popup-container');
			var searchPopup = $('popup-container-searchtips');
			if(couponPopup && couponPopup.style.display !== "none" && !couponPopup.hasClassName('mini-popup')){
				couponPopup.down('.coupon-popup-close-button').click();
			}
			else if(normalPopup && normalPopup.style.display !== "none"){
				this(normalPopup.down('.popup-close-button'));
			}
			else if(searchPopup && searchPopup.style.display !== "none"){
				this(searchPopup.down('.popup-close-button'));
			}
		}
	},
	hidePopup: function(event){
		var elem = event.currentTarget || event;
		var popupContainer = elem.up('.popup');//$('popup-container');
		popupContainer.hide();
	},
	closePopup : function(event){
		if(event){
			var elem = event.currentTarget || event;
			var popUpHolder = $('popup-container');
			popUpHolder.update().hide();
		}
	},
};
