/**
 * @theme    	efk
 * @package     default
 * @copyright   edgefxteam@divami.com
 */
var PopupClicksClass = Class.create();
PopupClicksClass.prototype = {
	initialize : function(){
		this.sb.attachEvents($$('.popup-video-link'),'click',this.showVideo,this);
	},
	sb : new SandBox(),
	popupTemplateObject : new PopupTemplateClass(),
	showVideo : function(e){
		e.preventDefault();
		var element = e.currentTarget;
		var url = element.readAttribute('href');
		this.sb.gaTrack('Video Popup','click','Showing video for '+url);
		var title = e && element.up('.edgefxProject').down('.product-image').readAttribute('alt');
		this.popupTemplateObject.getVideoPopupTemplate(url, title);
	}
};
document.observe("dom:loaded", function() {
	var popupClicksObject = new PopupClicksClass();
});