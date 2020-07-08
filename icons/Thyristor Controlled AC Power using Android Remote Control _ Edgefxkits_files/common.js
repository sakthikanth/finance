var Common = Class.create();
Common.prototype = {
	sb : new SandBox(),
	initialize: function(){
		var category = $$('.categoryClick');
		this.sb.attachEvents(category, 'click', this.onClickCategory, this);
	},
	
	onClickCategory : function(event) {
		event.stop();
		window.location = event.currentTarget.readAttribute('href');
	}
};

document.observe("dom:loaded", function() {
	commonObject = new Common();
});
