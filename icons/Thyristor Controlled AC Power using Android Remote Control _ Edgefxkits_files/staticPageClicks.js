var DomReady =  Class.create();
DomReady.prototype = {
	initialize : function(){
		var sb = this.sb;
		sb.attachEvents($$('.static-click'), 'click', this.staticClick, this);
	},
	sb: new SandBox(),
	staticClick: function(e){
		var elem = e.currentTarget;
		//To enable user intentional clicks
		if($('static-page-indicator') && elem && !e.altKey && !e.ctrlKey && !e.metaKey && !e.shiftKey){
			hidePopupsOnBodyClick();
			e.stop();
			window.location.href = elem.href;
		}
	}
};
document.observe("dom:loaded", function() {
	domReady = new DomReady();
});