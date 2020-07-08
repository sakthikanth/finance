/**
 * @theme    	efk
 * @package     default
 * @copyright   edgefxteam@divami.com
 */
var Search = Class.create();
Search.prototype = {
	initialize: function(){
		var sb = this.sb;
		//sb.attachEvents($('search'), 'keypress', this.checkForCategory, this);
		$('search_mini_form').onsubmit =  this.submitForm.bind(this); //used pure javascript as there are conflicts with prototype event
		sb.attachEvents($$('.serachTips'), 'click', this.showSearchTipsPopup, this);
	},
	sb : new SandBox(),
	//popupTemplateObject: new PopupTemplateClass(),
	submitForm : function(e){
		this.sb.gaTrack('search', 'submit search query', 'clicked on submit button to search for the query');
		if(e.currentTarget){
			e.stop();
		}
		var form = e.currentTarget || e;
		var cat = "";
		var q = "";
		var value = form.q.value;
		if(!value){
			return false;
		}
		//check whether the value is category name
		var select = form.cat;
		var searchTerms = value.split(":");
		if(searchTerms.length >= 2){
			var options = select.select('option');
			var selectedIndex = this.getCategoryIndex(options, searchTerms[0]);
			if(selectedIndex){
				// cat = options[selectedIndex].value;
				form.cat.selectedIndex = selectedIndex;
				// var queryText = searchTerms.splice(1).join(":");
				// form.q.value = queryText?queryText:"EMB";
			}
		}
		//submit form
		form.submit();
		// var href = e.currentTarget.action + "?cat=" + cat + "&q=" + q;
		// window.location.href = href;
	},
	getCategoryIndex: function(options, value){
		for(var i = 0; i < options.length; i++){
			var option = options[i];
			if(option.text.toLowerCase() == value.toLowerCase()){
				return i;
			}
		}
		return 0;
	},
	showSearchTipsPopup: function(e){
		e.stop();
		var popup = new PopupTemplateClass();
		var container = $('popup-container-searchtips');
		popup.showOtherPopup(container);
		// var sb = this.sb;
		// sb.attachEvents($$('.edgefxpopupCloseHolder'), 'click', this.closeSearchTipsPopup, this);
	},
	closeSearchTipsPopup: function(){
		var popupContainer = $('popup-container');
		popupContainer.hide();
	}
};
document.observe("dom:loaded", function() {
	search = new Search();
});