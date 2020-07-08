/**
 *
 * @theme    efk
 * @package     default
 * @copyright   edgefxteam@divami.com
 */

var PopupQuickBuyClass = Class.create();
PopupQuickBuyClass.prototype = {
	params : {},
    initialize : function(){
    	var sb = this.sb;
		this.success = this.onSuccess.bind(this);
		this.complete = this.onComplete.bind(this);
		this.failure = this.onFailure.bind(this);
		this.onquickbuy = this.onQuickBuy.bind(this);
		sb.attachEvents($$('.quick-buy'), 'click', this.showQuickBuyPopup, this);
	},
	
	sb : new SandBox(),
    popupTemplateObject : new PopupTemplateClass(),
    validation: new UserValidation(),
	
	showQuickBuyPopup : function(event){
		event.preventDefault();
		this.sb.gaTrack('Quick Buy','click','Clicked quick buy in header');
		var element = event.currentTarget;
		var url = element.readAttribute('href');
		this.popupTemplateObject.showPopUpOnPageLoad({
									"headerTitle": 'QUICK BUY',
									"minH": "354px",
									"commonPopupCls": ['quickbuypopupContainer']
							});
		
		url = this.sb.removeHTTP(url);
		var request = new Ajax.Request(
            url,
            {
                method:'post',
                onComplete: this.complete,
                onSuccess: this.success,
                onFailure: this.failure
            }
        );
	},
	
	onSuccess : function(data) {
		var popupTemplateObject = this.popupTemplateObject;
		var domElement = new Element('div');
		var result = data.responseText.evalJSON();
		if(result.success) {
			domElement.insert(result.data.html);
			var quickBuy = $(domElement).select('.efk-quick-buy')[0];
			var body = $$('body')[0];
			this.sb.screenBlocker.hide(body);
			popupTemplateObject.showPopup(quickBuy);
			this.resetErrorField();
		} else {
			this.popupTemplateObject.closePopup();
		}
	},
	
	onComplete : function(data) {
		var sb = this.sb;
		var quickBuyPopup = $('popup-container');
		var buyNowBtn = $(quickBuyPopup).select('.buy-now-action')[0];
		var modelNumberFields = $(quickBuyPopup).select('.modelnumber');
		var qtyFields = $(quickBuyPopup).select('.qty');
		
		sb.attachEvents(buyNowBtn, 'click', this.onClickBuyNow, this);
		sb.attachEvents(modelNumberFields, 'blur', this.onBlur_From_Model_Number_Field, this);
		sb.attachEvents(qtyFields, 'click', this.selectTextValue, this);
		$$('#quick-buy-table #modelnumber1')[0].focus();
	},
	
	onFailure : function(data) {
		console.log('onFailure');
		this.popupTemplateObject.closePopup();
	},
	
	//Select the text field when focus on it or click on it 
	selectTextValue: function(event) {
		var me = event.currentTarget;
		me.select();
	},
	
	onClickBuyNow : function(event) {
		event.preventDefault();
		var element = event.currentTarget;
		var url = element.select('button')[0].readAttribute('url');
		var form = element.up('form');
		var me = this;
		//this.removeErrorMessage();
		
		//var validator = new Validation(form.id);
		//validator.validate()
		
		if(!me.checkModelNumbers()) {
			return;
		} else {
			var elementToBlock = $$('.efk-quick-buy-body')[0];
			me.sb.screenBlocker.hide(elementToBlock);
			me.sb.screenBlocker.show(elementToBlock, true);
			url = this.sb.removeHTTP(url);
        	var request = new Ajax.Request(
	            url,
	            {
	                method:'post',
	                parameters: {
	                    'modelnums[]' : me.getFieldArray('modelnumber'),
	                    'kittypes[]' : me.getFieldArray('kittype'),
	                    'qtys[]' : me.getFieldArray('qty')
	                },
	                onSuccess: me.onquickbuy,
	            }
	        );
        }
	},
	
	onQuickBuy : function(response) {
		var data = response.responseText.evalJSON();
		var quickBuyPopup = $('popup-container');
		this.resetErrorField();
		var sb = this.sb;
		var elementToBlock = $$('.efk-quick-buy-body')[0];
		sb.screenBlocker.hide(elementToBlock);
		var me = this;
		
		//reset errors to all the fields
		var textFields = $(quickBuyPopup).select('.modelnumber');
		textFields.forEach(function(field){
			me.resetErrorAttribute(field);
		});
		$$('.validate-number.qty').each(function(element){
			me.resetErrorAttribute(element);
		});
		var blnSuccess = !me.checkDuplicateRows();
		if(data.type && data.type.length){
			for(var l=0;l<data.type.length;l++){
				var type = data.type[l];
				if(type == "Invalid Model Number") {
					var num = data.modelnums[l];
					// invalidModelNums.forEach(function(num) {
						//set errors to the error field
						var errorTextFields = $(quickBuyPopup).select('.modelnumber[value=' + num + ']');
						errorTextFields.forEach(function(modelField) {
							me.setErrorAttribute(modelField, 'invalid_model_number');
							me.emptyQuantity(modelField);
						});
					// });
					//me.updateErrorMessage('Invalid Model Number(s) ' + invalidModelNums.join(', '));
				} else if(type == "Beyond Quantity") {
					//reset errors on quantity fields
					var modelQuantity = data.modelwithquantity;
					var tempModels = [];
					modelQuantity.forEach(function(obj) {
						if(obj){
							var modelNum = obj.modelnum?obj.modelnum:obj[0].modelnum;
							var kittype = obj.kittype?obj.kittype:obj[0].kittype;
							tempModels.push(modelNum);
							var qty = obj.quantity;
							var modelFields = $(quickBuyPopup).select('.modelnumber[value=' + modelNum + ']');
							var modelFieldName = modelFields.findAll(function(el){
								return el.up('tr').down('.kittype').value == kittype;
							})[0].name;
							me.setErrorAttribute($(quickBuyPopup).select('#qty' + modelFieldName.charAt(modelFieldName.length - 1))[0], "beyond_quantity", true);
						}
					});
					
					//me.updateErrorMessage('Quantity you have given is beyond for the model number(s) ' + tempModels.join(', '));
				}
				this.validation.setFocus();
			}
		}
		else if(blnSuccess){
			sb.gaTrack('Quick Buy','buy','Redirecting to checkout');
			quickBuyPopup.hide();
			var body = $$('body')[0];
			me.sb.screenBlocker.show(body);
			window.location.href = data.redirecturl;
		}
	},
	setErrorAttribute : function(field, msg, bln){
		this.validation.setErrorColor(field, bln);
		this.writeAttribute(field, msg);
	},
	emptyQuantity: function(field){
		var qty = field && field.up('tr').down('.quantity-wrapper').down('input');
		if(qty){qty.value = "";}
	},
	resetErrorAttribute: function(field){
		this.validation.resetColor(field);
		this.removeErrorAttribute(field);
	},
	writeAttribute: function(field, msg){
		var tr = field.up('tr');
		var td = field.up('td');
		var index = td.previousSiblings().size();
		var nextTr = tr.next();
		var message = this.validation.emsg[msg];
		if(!message){message = msg;}
		if((nextTr && !nextTr.hasClassName('tr-error-holder')) || !nextTr){
			var newTr = new Element('tr', {'class': 'tr-error-holder'});
			tr.insert({
			  	after: newTr
			});
			if(index == "0"){
				newTr.update("<td></td>");	
			}
			else{
				newTr.update("<td colspan='3' style='padding-right:15px;'></td>");
			}
			newTr.down('td').update(message);
			console.log("Index: " + index);
		}
		else{
			//nextTr.update(message);
			nextTr.down('td',index).update(message);
		}
	},
	removeErrorAttribute: function(field){
		var tr = field.up('tr');
		var nextTr = tr.next();
		if(nextTr && nextTr.hasClassName('tr-error-holder')){
			nextTr.remove();
		}
	},
	/* Make sure that user enter atleast one model number */
	checkModelNumbers : function() {
		var quickBuyPopup = $('popup-container');
		var modelNumberFields = $(quickBuyPopup).select('.modelnumber');
		var msg = 'Please enter model number';
		this.resetErrorField();
		for(var i = 0; i < modelNumberFields.length; i++){
			this.validation.resetErrorAttribute(modelNumberFields[i]);
			this.resetErrorAttribute(modelNumberFields[i]);
		}
		var count = 0;
		for(var j=0; j< modelNumberFields.length; j++){
			var modelnumber = modelNumberFields[j];
			var qty = modelnumber && modelnumber.up('tr').down('.quantity-wrapper').down('input');
			if(modelnumber.value.length !== 0) {
				count++;
			}
			else if(qty.value.length !== 0){
				this.setErrorAttribute(modelnumber, msg);
				return false;
			}
		}
		// modelNumberFields.forEach(function(modelnumber) {
		// 	var qty = modelnumber && modelnumber.up('tr').down('.quantity-wrapper').down('input');
		// 	if(modelnumber.value != "") {
		// 		count++;
		// 	}
		// 	else if(qty.value !== ""){
		// 		this.setErrorAttribute(modelnumber, msg);
		// 		return false;
		// 	}
		// }.bind(this));
		if(count == 0) {
			this.setOnlyFirstFieldErrorMessage(msg);
			// this.setErrorField(msg);
			return false;
		} else {
			return true;
		}
	},
	setOnlyFirstFieldErrorMessage: function(msg){
		var value = "";
		var qtyWrappers = $('quick-buy-table').select('.quantity-wrapper');
		if(qtyWrappers.length){
			var qty, blnQty = false;
			for(var i = 0; i < qtyWrappers.length; i++){
				qty = qtyWrappers[i].down('input');
				if(qty.value !== ""){
					index = i;
					value = qty.value;
					blnQty = true;
					break;
				}
			}
			qtyWrappers.each(function(el){
				el.down('input').value = "";
			});
			qty.value = value;
			if(qty && blnQty){
				var field = qty && qty.up('tr').down('.quickBuyFirstCol').down('input');
				this.validation.setErrorAttribute(field, msg);
			}
			else{
				this.setErrorField(msg);
			}
		}
	},
	getFieldArray : function(type) {
		var quickBuyPopup = $('popup-container');
		var fields = $(quickBuyPopup).select('.' + type);
		var modelFields = null;
		if(type != 'modelnumber') {
			modelFields = $(quickBuyPopup).select('.modelnumber');
		}
		var fieldArray = [];
		fields.forEach(function(field, index) {
			if(type != 'modelnumber' && modelFields[index].value != "") {
				
				//Getting the value from customized combo based on selection backgorund 
				if(type =='kittype') {
					field.value= $(field).querySelector('.selectionBackground').getAttribute('listid');
				}
				
				fieldArray.push(field.value);
			}
			else if(field.value != '' && type == 'modelnumber') {
				fieldArray.push(field.value);
			}
		});
		return fieldArray;
	},
	setErrorField: function(msg){
		var errMessageElement = $('popup-container').down('.err-message');
		if(errMessageElement){
			Element.show(errMessageElement);
			errMessageElement.update(msg);
		}
	},
	resetErrorField: function(){
		var errMessageElement = $('popup-container').down('.err-message');
		if(errMessageElement){
			Element.hide(errMessageElement);
		}
	},
	checkDuplicateRows : function() {
		var quickBuyPopup = $('popup-container');
		var modelNumberFields = $(quickBuyPopup).select('.modelnumber');
		var kitTypeFields = $(quickBuyPopup).select('.kittype');
		var length = modelNumberFields.length;
		var index = -1;
		var value = '';
		var me = this;
		var checked = [];
		modelNumberFields.forEach(function(field){
			me.resetErrorAttribute(field);
		});
		var bln = false;
		for(var i = 0; i < length; i++) {
			var firstField = modelNumberFields[i];
			var firstKit = kitTypeFields[i];
			for(var k = 0;k < checked.length;k++){
				if(firstField.value == checked[k]){
					i++;
					firstField = modelNumberFields[i];
				}
			}
			for(var j = i + 1; j < length; j++) {
				var secondField = modelNumberFields[j];
				var secondKit = kitTypeFields[j];
				var kitValue = firstKit.querySelector('.selectionBackground').textContent;
				if(firstField.value && firstField.value == secondField.value && firstKit.value == secondKit.value) {
					// index = i;
					checked.push(firstField.value);
					var msg =  'Model no. <i>' + firstField.value  + '</i>   with ' +  kitValue + ' has repeated.';
					me.setErrorAttribute(secondField, msg);
					me.emptyQuantity(secondField);
					bln = true;
					// break;
				}
			}
			// if(index >= 0) {
			// 	break;
			// }
		}
		return bln;
		/* @TODO: Display error message near CORRESPONDING model number field. */
		
		// if(index >= 0) {
		// 	var msg =  'Model no. <i>' + modelNumberFields[index].value + '</i>  with ' + kitTypeFields[index][kitTypeFields[index].selectedIndex].title + ' has repeated.';
		// 	this.setErrorField(msg);
		// 	$(quickBuyPopup).select('.modelnumber[value=' + value + ']').forEach(function(element, index) {
		// 		element.up('.text-wrapper').addClassName('error-field');
		// 		element.up('.text-wrapper').addClassName('error-field-right');
		// 	});
		// 	return false;
		// } else {
		// 	return true;
		// }
	},
	
	onBlur_From_Model_Number_Field : function(event) {
		var quickBuyPopup = $('popup-container');
		var element = event.currentTarget;
		var value = element.value;
		var hasErrorField = element.up().hasClassName('error-field');
		if(value != "") {
			var index = element.id.charAt(element.id.length - 1);
			var qtyElement = $(quickBuyPopup).select('#qty' + index)[0];
			if(qtyElement.value.length == 0){
				qtyElement.value = 1;
			}
		}
		else if(hasErrorField && value.length == 0){
			var index = element.id.charAt(element.id.length - 1);
			var qtyElement = $(quickBuyPopup).select('#qty' + index)[0];
			qtyElement.value = "";
		}
	},
	
	allowNumbersInQty : function(event) {
		var element = event.currentTarget;
		var value = element.value;
		//element.value = value.replace(/[^1-9]/g,'');
	},
    
    // removeErrorMessage : function() {
    // 	var quickBuyPopup = $('popup-container');
    // 	$(quickBuyPopup).down('.err-message').update('');
    // },
    
    // updateErrorMessage : function(msg) {
    // 	var quickBuyPopup = $('popup-container');
    // 	$(quickBuyPopup).down('.err-message').update(msg);
    // }
};

document.observe("dom:loaded", function() {
    quickbuy = new PopupQuickBuyClass();
});