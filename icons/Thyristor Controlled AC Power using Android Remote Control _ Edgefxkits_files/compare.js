/**
 * @theme    	efk
 * @package     default
 * @copyright   edgefxteam@divami.com
 */
var Compare = Class.create();
Compare.prototype = {
	comPareItemsCount : 0,
	initialize: function(){
		var sb = this.sb;
		var compareChk = $$('.compare-chk');
		var cmpContainer = $('compare-section');
		if(cmpContainer){
			var cmpLi = $(cmpContainer).select('.compareProduct');
			this.comPareItemsCount = cmpLi.length;
		}
		//detach events
		sb.detachEvents(compareChk, 'click', this.addCompareProduct);
		sb.detachEvents($$('.btn-remove'), 'click', this.removeCompareProductOnClick);
		sb.detachEvents($$('.clear-compare-window'), 'click', this.clearCompareWindow);
		//attachevents
		sb.attachEvents(compareChk, 'click', this.addCompareProduct, this);
		//For static elements
		sb.attachEvents($$('.btn-remove'), 'click', this.removeCompareProductOnClick, this);
		sb.attachEvents($$('.clear-compare-window'), 'click', this.clearCompareWindow, this);	
		//
		this.refreshCheck();
	},
	sb : new SandBox(),
	cookie : new Cookie(),
	checkArray: [],
	// blnShowInfo : true,
	refreshCheck : function(){
		var compareChk = $$('.compare-chk');
		var cmpSection = $('compare-section');
		if(cmpSection){
			var btns = cmpSection.select('.btn-remove');
			var kitArr = [];
			for(var i = 0; i < btns.length; i++){
				var kitId = btns[i].readAttribute('data-id');
				kitArr.push(kitId);
			}
			for(var j = 0; j < compareChk.length; j++){
				var com = compareChk[j];
				var id = com.readAttribute('data-id');
				for(k = 0;k < kitArr.length; k++){
					if(id == kitArr[k]){
						com.checked = true;
					}
				}
			}
		}
	},
	clearCompareWindow : function(e){
		this.sb.gaTrack('compare', 'clear compare section', 'clicked on remove button of compare section');
		this.comPareItemsCount = 0;
		var win = e.currentTarget;
		if(!comparing){
			comparing = this;
		}
		var compare = comparing;
		var ajaxData = {
			'url' : win.readAttribute('data-clear-url')
		}
		compare.sendCompareRequest(ajaxData);
		//if success
		//uncheck all checkboxes
		compare.uncheckBoxAll();
	},
	addCompareProduct : function(e){
		var sb = this.sb;
		var chk = e.currentTarget;
		if(chk.checked){
			this.checkSameProduct(chk);
			this.sb.gaTrack('compare', 'add to compare section', 'checked the compare checkbox related to a product' );
			//var cmpLi = $('compare-section').select('.compareProduct');
			var itemsCount = this.comPareItemsCount;
			if(itemsCount > 3){
				e.stop();
				if(this.interval){
					clearInterval(this.interval);
				}
				this.resetCheckInfo();
				var div = new Element('div');
				div.addClassName("compare-chk-info");
				div.update("Maximum of 4 projects can be compared. Please remove a project from the Compared List shown on top of the page and try again");
				chk.parentElement.appendChild(div);
				this.interval = this.resetCheckInfo.delay(7);
			}
			else{
				this.checkArray.push(chk);
				chk.disabled = true;
				var bgMask = chk.parentElement.next('.bgMask');
				bgMask.style.display = "block";
				this.comPareItemsCount++;
				var dataid = chk.readAttribute('data-id');
				dataid = dataid.split('-');
				var ajaxData = {
					'url' : chk.readAttribute('data-add-url'),
					'product' : dataid[0],	
					'kittype' : dataid[1]
				}
				this.sendCompareRequest(ajaxData);
				//if success
				if(itemsCount == 0){
					this.setCheckInfo(chk);
				}else{
					this.resetCheckInfo();
				}
			}
		}
		else{
			this.sb.gaTrack('compare', 'remove product from compare section', 'unchecked the checkbox related to a product');
			// this.removeCheckedProduct(id);	
			this.checkArray.push(chk);
			chk.disabled = true;
			var bgMask = chk.parentElement.next('.bgMask');
			bgMask.style.display = "block";	
			this.removeCompareProduct(e);		
			this.comPareItemsCount--;
		}
		//this.refreshCheck();
	},
	setCheckInfo: function(chk){
		if(this.interval){
			clearInterval(this.interval);
		}
		this.resetCheckInfo();
		var div = new Element('div');
		div.addClassName("compare-chk-info");
		div.update("Project is added to the compared list on top of the page");
		chk.parentElement.appendChild(div);
		// this.blnShowInfo = false;
		//hide it after some time
		this.interval = this.resetCheckInfo.delay(7);
	},
	resetCheckInfo : function(){
		var chk = $$('.compare-chk-info');
		if(chk.length > 0){
			for(var i = 0; i < chk.length; i++){
				Element.remove(chk[i]);
			}
		}
	},
	sendCompareRequest : function(payload){
		var me = this;
		var target, chkParent, chkLabel, bgMask;
		
		if(this.ajax){
			this.ajax.transport.abort();
		}
		
		this.sb.screenBlocker.show($('compare-items'), true);
		var url = this.sb.removeHTTP(payload.url);
		this.ajax = new Ajax.Request(url, {
			parameters : Object.toQueryString(payload),
		  	onSuccess: function(response) {
		  		if(response.statusText.toLowerCase() == "ok"){
		  			if(me.checkArray != null) {
		  				for(i=0; i< me.checkArray.length; i++) {
		  					target = me.checkArray[i];
		  					bgMask = target.parentElement.next('.bgMask');
							bgMask.style.display = "none";
							target.disabled = false;
		  				}
		  			}
		  			me.checkArray = [];
			  		//Erase previous elements click events
			  		me.sb.detachEvents($$('.btn-remove'), 'click', me.removeCompareProductOnClick);
			  		me.sb.detachEvents($$('.clear-compare-window'), 'click', me.clearCompareWindow);
		    		//Create dummy element
			  		$('compare-section').update(response.responseText);
			  		//re-assign click events to btn-remove elements
					me.sb.attachEvents($$('.btn-remove'), 'click', me.removeCompareProductOnClick, me);
					me.sb.attachEvents($$('.clear-compare-window'), 'click', me.clearCompareWindow, me);
				}
		  	},
		  	onComplete: function(){
		  		this.sb.screenBlocker.hide($('compare-items'));
		  	}.bind(this)
		});
	},
	removeCheckedProduct : function(id){		
		var btnRemove = $('compare-section').select('.btn-remove');		
		if(btnRemove){
			for(var i = 0 ; i < btnRemove.length; i++){
				var btn = btnRemove[i];
				var dataId = btn.readAttribute('data-id');
				if(dataId == id){
					this.removeCompareProduct(btn);
					//break;
				}
			}
			//decrementing at last to fix for compare product which is still loading.
			this.comPareItemsCount--;
		}
	},
	removeCompareProductOnClick: function(e){
		this.sb.gaTrack('compare', 'remove compare product', 'clicked on close button of a product in compare section');
		this.comPareItemsCount--;
		this.removeCompareProduct(e);
	},
	removeCompareProduct : function(e){
		if(this.comPareItemsCount < 0){
			this.comPareItemsCount = 0;
		}
		var remove = e.currentTarget;
		this.checkSameProduct(remove);
		var dataid = remove.readAttribute('data-id');
		dataid = dataid.split('-');
		var ajaxData = {
			'url' : remove.readAttribute('data-remove-url'),
			'product' : dataid[0],	
			'kittype' : dataid[1]
		}	
		if(!comparing){
			comparing = this;
		}
		this.sendCompareRequest(ajaxData);
		this.resetCheckInfo();
		//if success
		//run for loop for each product of product listing
		this.uncheckBox(ajaxData.product);

	},
	uncheckBox : function(id){
		var checks = $$('.compare-chk');
		if(checks.length){
			for(var i = 0 ; i < checks.length; i++){
				var check = checks[i];
				var dataId = check.readAttribute('data-id');
				if(dataId == id){
					check.checked = false;
				}
			}
		}
	},
	uncheckBoxAll : function(){
		var checks = $$('.compare-chk');
		if(checks.length){
			for(var i = 0 ; i < checks.length; i++){
				var check = checks[i];
				check.checked = false;
			}
		}
	},
	checkSameProduct: function(chk){
		var checks = $$('.compare-chk');
		var dataId = chk.readAttribute('data-id');
		if(checks.length){
			for(var i=0; i<checks.length; i++){
				var curChk = checks[i];
				var id = curChk.readAttribute('data-id');
				if(id == dataId){
					curChk.checked = chk.checked;
				}
			}
		}
	}
};
document.observe("dom:loaded", function() {
	comparing = new Compare();
});