var KitTypeFilteringClass = Class.create();
KitTypeFilteringClass.prototype = {
	cookie : new Cookie(),
	sb : new SandBox(),
	initialize: function(){
		var kitTypeFilters = $$('.home-kittypefilter');
		if(kitTypeFilters){
			this.sb.attachEvents(kitTypeFilters, 'click', this.changeKitValues, this);
		}
		this.checkCookie();
	},
	changeKitValues: function(e){
		if(e.currentTarget.checked){
			var kitTypeNumber = e.currentTarget.value;
			kitTypeNumber = kitTypeNumber?kitTypeNumber:126;
			this.sb.gaTrack('Show prices for',e.currentTarget.readAttribute('kit-name'),'');
			var hostName = window.location.hostname;
			this.cookie.setCookie('kitTypeName', kitTypeNumber, 1, hostName, "/");
			//setLocation(window.location);
			this.sb.screenBlocker.show($$('body')[0]);
			document.location.reload();
		}
	},
	checkCookie : function() {
		var kitType = this.cookie.getCookie('kitTypeName');
		kitType = kitType?kitType:'126';
		var kitTypeId = 'kittype_' + kitType;
		var kitTypeSelected = $(kitTypeId);
		if(kitTypeSelected){
			kitTypeSelected.checked = true;
		}
	}
};

document.observe("dom:loaded", function() {
	var kitTypeFilteringObj = new KitTypeFilteringClass();
});