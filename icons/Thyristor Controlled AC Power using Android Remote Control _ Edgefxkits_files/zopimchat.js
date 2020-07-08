var ZopimChatClass = Class.create(); 
ZopimChatClass.prototype = {
	sb : new SandBox(),
	coupon : '',
	cookie : new Cookie(),
	initialize : function(){
		var elem = $$('.chatWithus');
		this.sb.attachEvents(elem, 'click', this.setChatPositionOnClick, this);
		if(typeof Coupon === 'function') {
			this.coupon = new Coupon(true);
		}
		
		// var efkBody = $$('.edgefxContainer')[0];
  		// efkBody.observe('scroll', this.setChatPosition.bind(this));
	},
	setChatPosition : function(event){
		var efkBody = $$('.edgefxContainer')[0];
		var efkBodys = $$('.edgefxFooterContainer')[0];
		var screenHeight = efkBody.clientHeight;
		var containerHeight = efkBody.scrollHeight;
		var footerHeight = efkBodys.offsetHeight;
		var scrolledHeight = efkBody.scrollTop;
		var caliculatedHeight = containerHeight - (screenHeight + footerHeight);
		var chatBoxes = $$('.zopim');
		var length = chatBoxes.length;
		if(caliculatedHeight < scrolledHeight){
			//set ottom fot chat box as scrolledHeight - caliculatedHeight
			for(var i=0; i<length; i++){
				chatBoxes[i].style.bottom = (scrolledHeight - caliculatedHeight) + 'px';
			}
			//$zopim.livechat.window.setOffsetVertical(20);
		}else{
			for(var i=0; i<length; i++){
				chatBoxes[i].style.bottom = 0 + 'px';
			}
		}
	},
	setChatPositionOnClick : function(){
		var me = this;
		var cookie = this.cookie;
		var hostName = window.location.hostname;
		var efkBody = $$('.edgefxContainer')[0];
		var efkBodys = $$('.edgefxFooterContainer')[0];
		if($zopim){
			$zopim.livechat.window.show();
			cookie.setCookie("chatStatus",true,1,hostName,"/");
			me.handleCouponPopup();
		}		
	},
	hideChatCompletely : function(e){
		var me = this;
		var cookie = this.cookie; 
		var checkStatus = cookie.getCookie("chatStatus"); 
		
		//Zopim chat is shown only when user clicks on chat us option,initially it should be in closed state
		if(!checkStatus) {
			var zopimChat = setInterval(function(){
				if(typeof $zopim !== 'undefined' && typeof $zopim !== undefined){
					var chatBoxes = $$('.zopim');
					if(chatBoxes.length){
						for(var i = 0; i < chatBoxes.length; i++){
							var chat = chatBoxes[i];
							chat.style.display = "none";
						}
					}
					if($zopim.livechat){
						me.handleChatWindowPosition(20);
						$zopim.livechat.hideAll();
						clearInterval(zopimChat);
					}
				}
			}, 100);
		} else {
			//Setting the coupon code position when zopim chat is in open state 
			var zopimChatResume = setInterval(function(){
				if(typeof $zopim !== 'undefined' && typeof $zopim !== undefined){
					if ($zopim.livechat) {
						$zopim.livechat.setOnConnected(function(){
							$zopim.livechat.button ? $zopim.livechat.button.show() : false;
							me.handleCouponPopup();
						});
						clearInterval(zopimChatResume);
					}
				}
			}, 100);
		}
	},
	
	handleChatWindowPosition: function(rightPos, elem) {
		if($zopim.livechat.window){
			$zopim.livechat.window.setOffsetHorizontal(rightPos);
		}
		if($zopim.livechat.button){
			$zopim.livechat.button.setOffsetHorizontal(rightPos);
		}
		if($zopim.livechat.badge) {
			elem ? elem.style.right = rightPos + "px" : false;
		}
	},
	
	handleCouponPopup: function() {
		this.coupon.setMiniPopupPosition();
		var chatBoxes = $$('.zopim');
		var me = this;
		if (chatBoxes.length) {
			for (var i = 0; i < chatBoxes.length; i++) {
				var chat = chatBoxes[i];
				var iframe = chat.down('iframe');
				iframe.contentWindow.document.onclick = this.coupon.setMiniPopupPosition;
				
				chat.onmouseover = function(event) {
					var closeIcon = iframe.contentWindow.document.getElementsByClassName('icon_font close');
					if(closeIcon.length) {
						for (var i = 0; i < closeIcon.length; i++) {
							closeIcon[i].removeEventListener('click', me.coupon.setMiniPopupPosition.bind(me));
							closeIcon[i].addEventListener('click', me.coupon.setMiniPopupPosition.bind(me));
						}
					}
				};
			}
		}
	},
	
};
document.observe("dom:loaded", function() {
	zopimChatClass = '';
	zopimChatClass = new ZopimChatClass();
	zopimChatClass.hideChatCompletely();
	
});
