var Coupon = Class.create();
Coupon.prototype = {
	initialize: function(noInitialize){
		var sb = this.sb;
		if(!noInitialize){
			Event.observe(document,'mousemove', function(){idleTime = 0;});
			Event.observe(document,'keypress', function(){idleTime = 0;});
			var customerService = $$('.show-customer-service-popup');
			if(customerService && customerService.length){
			    sb.attachEvents(customerService, 'click', this.customerServiceRequest.bind(this));
			}
			// this.couponPopupRequest();
			this.couponCheckup();
		}
	},
	cookie: new Cookie(),
	sb: new SandBox(),
	zopim: function(){ 
		if(typeof zopimChatClass !== "undefined") {
			return zopimChatClass;
		} 
		else {
			return new ZopimChatClass();
		}
	},
	couponCheckup: function(){
		//check the show coupon popup state
		var c = this.cookie;
		this.popupState = c.getCookie('coupon_popup');
		var couponCode = c.getCookie('coupon_code');
		if(this.popupState){
			if(this.popupState == "m"){ //mini-popup state
				if(couponCode && couponCode !== "removed"){
					// show mini-popup
	  				// call ajax function
					this.couponPopupRequest();
				}
				else{
					// coupon code is intentionally removed by customer
					// after the popup was shown
					// here couponCode value should be "removed"
				}
			}
			else if(this.popupState == "h"){ // hide mini-popup state
				// mini-popup must be in hidden state (default)
				// no verification of whether the coupon code is present or not.
			}
		}
		else{
			if(couponCode){
				// set timer which sends the coupon call after a particular time.
				this.idleCoupon();
			}
			else{
				// coupon code was intentionally removed by customer
				// before the popup was shown
			}
		}
	},
	popupTemplateObject : new PopupTemplateClass(),
	customerServiceRequest: function(e){
		e.stop();
		var cur = e.currentTarget;
		var url = cur.readAttribute('href');
		this.popupTemplateObject.showPopUpOnPageLoad({
				"headerTitle": '',
				"minH": "468px",
				"commonPopupCls": ['customer-popup-container']
		});
		this.ajax = new Ajax.Request(url, {
		  	onSuccess: function(response) {
		  		var obj = JSON.parse(response.responseText);
		  		if(obj.success){
	  				var template = new PopupTemplateClass();
  					template.showPopup(obj.html);	
  					// var zopim = this.zopim; 
  					// zopim().initialize();
  					var customerPopup = $$('.customer-popup-container');
  					if(customerPopup.length){
  						customerPopup = customerPopup[0];
	  					var chatLink = customerPopup.down('.chatWithUs');
	  					if(chatLink){
	  						chatLink.observe('click', this.showZopimChatWindow.bind(this, customerPopup));
	  					}
  					}
		  		}
		  	}.bind(this)
		});
	},
	showZopimChatWindow: function(customerPopup){
		//hide the popup
		var popup = customerPopup.up('#popup-container');
		popup.update('');
		popup.hide();
		// show zopim chat
		var efkBody = $$('.edgefxContainer')[0];
		var efkBodys = $$('.edgefxFooterContainer')[0];
		if($zopim){
			$zopim.livechat.window.show();
			this.setMiniPopupPosition();
			// $(efkBody).scrollTop = Math.abs(efkBody.scrollTop - efkBodys.offsetHeight);
			var chatBoxes = $$('.zopim');
			if(chatBoxes.length){
				for(var i = 0; i < chatBoxes.length; i++){
					var chat = chatBoxes[i];
					var iframe = chat.down('iframe');
					iframe.contentWindow.document.onclick = this.setMiniPopupPosition;
				}
			}
		}	
	},
	idleCoupon: function(){
		idleTime = 0;
		this.idleInterval = setInterval(this.timerIncrement, 1000, this);
	},
	timerIncrement: function(me) {
		idleTime = idleTime + 1;
		// console.log(idleTime);
		if (idleTime > 59) {
			// call coupon popup by ajax
			me.couponPopupRequest({'showPopup': true});
			idleTime = 0;
			if(me.idleInterval){
				clearInterval(me.idleInterval);
			}
		}
	},
	couponPopupRequest: function(obj){
		var el = $('autopopulate-url');
		if(el){
			var url = el.readAttribute('data-url');
			this.ajax = new Ajax.Request(url, {
				parameters: obj,
			  	onSuccess: function(response) {
			  		var obj = JSON.parse(response.responseText);
			  		if(response.statusText.toLowerCase() === "ok" && typeof obj.length !== "number"){
			  			if(obj.html !== ""){
				  			var template = new PopupTemplateClass();
				  			// var html = response.responseText;
				  			var couponPopup = $('coupon-popup-container');
				  			couponPopup.update(obj.html);
			  				var closeBtn = $$('.coupon-popup-close-button')[0];
				  			if(this.popupState == "m"){
				  				couponPopup.addClassName('no-animation');
				  				this.showMiniPopup(closeBtn);
				  				this.removeMiniPopupAnimation.delay(0.5, couponPopup);
				  			}
				  			else if(!this.popupState){				  				
				  				Event.observe(closeBtn, 'click', this.showMiniPopup.bind(this));
				  			}
			  				template.showOtherPopup(couponPopup, true);
			  			}
					}
			  	}.bind(this)
			});
		}
	},
	removeMiniPopupAnimation: function(coupon){ 
		coupon.removeClassName('no-animation'); 
	},
	showMiniPopup : function(e){
		var popup = $("coupon-popup-container");
		popup.removeClassName("popup");
		popup.style.visibility = "hidden";
		var edgefxContainer = $$('.edgefxContainer')[0];
		var left = (edgefxContainer.offsetWidth/2 - 90);
		var top = (edgefxContainer.offsetHeight/2 - 25);
		popup.style.right = left + "px";
		popup.style.bottom = top + "px";
		this.applyPopupStyles.delay(0.1, popup, this);
	},
	
	applyPopupStyles: function(popup, me){
		popup.style.visibility = "visible";
		popup.style.right = "20px";
		popup.style.bottom = "0px";
		popup.addClassName('mini-popup');
    	Event.observe($$('.mini-popup .coupon-popup-close-button')[0], 'click', me.closeMiniPopup.bind(me));
  		me.setMiniPopupPosition();
	},
	closeMiniPopup: function(e){
		var cur = e.currentTarget;
		var miniPopup = cur.up('.mini-popup');
		miniPopup.hide();
		// this.cookie.setCookie('coupon_popup','h');
		var url = cur.readAttribute('data-mini-url');
		this.setMiniPopupCloseCookie(url);
		this.setMiniPopupPosition();
	},
	setMiniPopupCloseCookie: function(url){
		new Ajax.Request(url);
	},
	
	setMiniPopupPosition: function(doresize) {
		
		//hide popups and dropdown oon chat window click
		if(doresize != true) {
			hidePopupsOnBodyClick();
		}
		
		//get all initial widths and elements
		var screenWidth = document.viewport.getWidth();
		var screenHeight = document.viewport.getHeight();
		var miniPopup = $('coupon-popup-container');
		var chatBoxes = $$('.zopim');
		var popup = chat = false;
		var totalWidth = popupWidth = chatWidth = 0;
		var scrollWidth = 20;
		var cur = null;
		var shareButtonsHeight = 0;
		var shareButtonsTop = 200;
		var zindex = '134';
		
		//minimum resolution to support resize is 960
		if(screenWidth < 960) {
			screenWidth = 960;
			zindex = '136';
		}
		
		//adjust share buttons position while chat window expanded or collapsed
		var shareBtns = $$('.share-buttons');
		if(shareBtns.length) {
			shareBtns = shareBtns[0];
			shareButtonsHeight = shareBtns.clientHeight;
		}
		
		//calculate side width to check whether coupon and chat fit in that position or not
		var contentWidth = document.getElementsByClassName('edgefxMainContentHolder')[0].offsetWidth;
		var sideWidth = (screenWidth - contentWidth) / 2;
		var elemWidth = 0;
		
		//calculate width if the coupon popup is present
		if(miniPopup && miniPopup.hasClassName('mini-popup')) {
			elemWidth = popupWidth = miniPopup.offsetWidth;
			popup = true;
		}
		
		//calculate width if the chat window is present
		for(var i = 0; i < chatBoxes.length; i++) {
			cur = chatBoxes[i];
			if(cur.style.display !== 'none') {
				chat = true;
				chatWidth = cur.offsetWidth;
				if(chatWidth > elemWidth) {
					elemWidth = chatWidth;
				}
				break;
			}
		}
		
		//calculate total width of chat and coupon popup
		if(popup && chat) {
			totalWidth = chatWidth +  popupWidth + scrollWidth + 5;
		} else {
			totalWidth = elemWidth + scrollWidth;
		}
		
		//adjust position of chat and coupon popup
		if(popup && chat) {
			//set zindex less than workshop popup, other wise it is hiding under chat popup
			cur.style.zIndex = zindex;
			miniPopup.style.zIndex = zindex;
			if(sideWidth >= totalWidth) {
				miniPopup.style.bottom = "0px";
				zopimChatClass.handleChatWindowPosition(popupWidth + 5 + scrollWidth, cur);
			} else {
				var curheight = cur.offsetHeight;
				zopimChatClass.handleChatWindowPosition(scrollWidth, cur);
				miniPopup.style.bottom =  curheight + "px";
				shareButtonsTop = screenHeight - curheight - miniPopup.offsetHeight - shareButtonsHeight - 20;
			}
		} else if(popup) {
			miniPopup.style.bottom = "0px";
			miniPopup.style.zIndex = zindex;
		} else if(chat) {
			zopimChatClass.handleChatWindowPosition(scrollWidth, cur);
			shareButtonsTop = screenHeight - cur.offsetHeight - shareButtonsHeight - 20;
			cur.style.zIndex = zindex;
		}
		
		//adjust share buttons position while chat window expanded or collapsed
		if(shareBtns) {
			if(shareButtonsTop > 200) {
				shareButtonsTop = 200;
			}
			shareBtns.style.top = shareButtonsTop + "px";
		}
				
		//adjust width of workshop small popup
		var smallPopup = $("smallPopup");
		if(smallPopup) {
			if((sideWidth >= totalWidth) || (sideWidth >= elemWidth + scrollWidth)) {
				smallPopup.style.width = contentWidth + "px";
				smallPopup.style.margin = "auto";
				document.getElementsByClassName('ppsml-edfxwrpr')[0].style.fontSize = "20px";
			} else {
				var remainingWidth = elemWidth + scrollWidth - sideWidth;
				var popupWidth = contentWidth - remainingWidth - 5;
				smallPopup.style.width = popupWidth + "px";
				smallPopup.style.marginLeft = sideWidth + "px";
				document.getElementsByClassName('ppsml-edfxwrpr')[0].style.fontSize = "12px";
			}
			var titleWidth = 420 + 20; //image and title width and 20 is right side padding
			var workshopTitleWidth = smallPopup.offsetWidth - titleWidth - 10;
			document.getElementsByClassName('ppsml-edfxdes')[0].style.width = workshopTitleWidth + "px";
		}
	},

	/**
	 *this function handle the coupon poistion on window resize
	 */
	resize: function() {
		this.setMiniPopupPosition(true);
	}
};

document.observe("dom:loaded", function() {
	coupon = new Coupon();
});