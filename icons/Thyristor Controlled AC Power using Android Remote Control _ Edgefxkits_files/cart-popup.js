/**
 *
 * @theme    efk
 * @package     default
 * @copyright   edgefxteam@divami.com
 */
var PopupCartClass = Class.create(); 
PopupCartClass.prototype = {
	params : '',
	shippingData : [],
	shippingDataAssoc : {},
	shippingModel: {
		'selectedCountryCode': ''	
	},
	initialize : function(data){
		var sb = this.sb;
		this.codLimit = data.codLimit;
		this.success = this.onSuccess.bind(this);
		this.complete = this.onComplete.bind(this);
		this.failure = this.onFailure.bind(this);
		this.topCartButton = $$('.top-link-cart')[0];
		sb.attachEvents($$('.top-link-cart'),'click',this.getCart,this);
		sb.detachEvents($$('.product-add-to-cart'),'click');
		sb.attachEvents($$('.product-add-to-cart'),'click',this.addToCart, this);
		this.attachProjectDetailsEvents();
	},
	sb : new SandBox(),
	validation: new UserValidation(),
	updateMess : 'Updating the cart details and summary...',
	popupTemplateObject : new PopupTemplateClass(),
	shipEstDomElems : {},
	addToCart : function(event){
		event.preventDefault();
		var sb = this.sb;
		sb.gaTrack('Cart','Add','Adding product to cart');
		var elem = event.currentTarget;
		this.incrementCartQty();
		if(elem.hasClassName('cart-product-add-to-cart')){
			var cart = $('popup-container');
			body = cart.down('.cart-container');
      			sb.screenBlocker.show(body, true);
		} else{
			var cartMeta = this.getCurrentCartMeta();
			this.popupTemplateObject.showPopUpOnPageLoad({
				"headerTitle": cartMeta.text,
				"minH": "475px",
				"commonPopupCls": ['cartpopup']
			});
    		}
		
        var url = elem.readAttribute('href');
        var form = elem.down('form');
		// console.log(form);
        url = this.sb.removeHTTP(url);
        var request = new Ajax.Request(
	        url,
	        {
	            method:'post',
	            parameters : Form.serialize(form.id),
	            onComplete: this.attachCartPopupEvents.bind(this),
	            onSuccess: this.showCart.bind(this),
	            onFailure: this.failure
	        }
        );
	},
	getCart : function(event, flag){
		event.preventDefault();
		if(!flag){
			var sb = this.sb;
			sb.gaTrack('Cart','Show','Viewing items in cart from top of the page');
			
			var cartMeta = this.getCurrentCartMeta();
			
			this.popupTemplateObject.showPopUpOnPageLoad({
									"headerTitle": cartMeta.text,
									"minH": "540px",
									"commonPopupCls": ['cartpopup']
							});
		}
		var element = event.currentTarget;
		var url = element.readAttribute('href');
		url = this.sb.removeHTTP(url);
		var request = new Ajax.Request(
            url,
            {
                method:'post',
                parameters:this.params,
                onComplete: this.attachCartPopupEvents.bind(this),
                onSuccess: this.showCart.bind(this),
                onFailure: this.failure
            }
        );
	},
	onComplete : function(data){
		
	},
	onSuccess : function(data){
		var response = JSON.parse(data.responseText);
		this.updateCartItems(response);
	},
	onFailure : function(data){
		alert('Server is not connecting: Please try again later.');
	},
	showCart : function(data){
		var response = JSON.parse(data.responseText);
		if(response.success){
			var popupTemplateObject = this.popupTemplateObject;
			var cartHtml = response.html;
			this.shippingData = response.data.shippingData;
			popupTemplateObject.showPopup(cartHtml);
		} else {}
		var body = $$('body')[0];
		this.sb.screenBlocker.hide(body);
	},
	attachCartPopupEvents : function(){
		this.attachCartFormEvents();
		couponObject.attachCouponEvents();
	},
	attachCartFormEvents : function(){
		var sb = this.sb;
		var cartPopup = $('popup-container');
		this.cartPopup = cartPopup;
		var updateCartBtn = $(cartPopup).select('.update_cart_action');
		sb.attachEvents(updateCartBtn,'click',this.updateOptions,this);
		var updateAllCartBtn = $(cartPopup).down('.update_all_cart_action');
		sb.attachEvents(updateAllCartBtn,'click',this.updateCart,this);
		var qtyFields = $(cartPopup).select('.qty');
		sb.attachEvents(qtyFields,'change', this.checkQtyChnage, this);
		sb.attachEvents(qtyFields,'keypress', sb.allowNumbersOnly, this);
		var removeBtns = $(cartPopup).select('.cart-item-remove');
		sb.attachEvents(removeBtns,'click', this.removeCartItem, this);
		var cartCloseBtns = $$('.cart-popup-close-button');
		sb.attachEvents(cartCloseBtns,'click', this.closeCart, this);
		var estimationLink = $(cartPopup).down('.deliveryTimeLink');
		sb.attachEvents(estimationLink,'click', this.toggleEstimationForm, this);
		var proceedToCheckoutBtn = $(cartPopup).down('.proceedToCheckoutBtn');
		sb.attachEvents(proceedToCheckoutBtn,'click', this.gotoCheckout, this);
		sb.attachEvents($(cartPopup).select('.cart-product-add-to-cart'),'click',this.addToCart, this);
		sb.attachEvents($$('.alertMSGClose '),'click',this.hideGlobalErrorMess, this);
		/* form submit cancel function */
		var form = $(cartPopup).down('#shopping-cart-form');
		if(form){
			form.onsubmit = this.formSubmit.bind(this);		
		}
			
	},
	formSubmit: function(e){
		e.stop();
	},
	checkQtyChnage : function(event){
		var currentTarget = event.currentTarget;
		this.sb.gaTrack('Cart','Change','Changing quantity of the product in cart');
		if(currentTarget.value == '0' || currentTarget.value == ''){
			currentTarget.value = currentTarget.readAttribute('oldValue');
			var rowElem = currentTarget.up('tr');
			var data = {
				'message' :'Minimum one item should be selected'
			};
			this.showInlineErrorMess(rowElem,data);
			rowElem.down('.update_cart_action').hide();
		}else{
			currentTarget.writeAttribute('oldValue',currentTarget.value);
			this.showUpdateButton(currentTarget, true);
		}
	},
	showUpdateButton : function(target, flag){
		if(!flag){
			this.sb.gaTrack('Cart','Change','Changing kit type option for product');
		}
		var currentRow = target.up('tr');
		var button = currentRow.down(".updateCartButton");
		var errorMess = currentRow.down('.errorMessageInline');
		errorMess.innerHTML = '';
		var errorMessIcon = currentRow.down('.errorMessageInlineIcon');
		errorMessIcon.hide();
		errorMess.hide();
		button.show();
	},
	toggleEstimationForm : function(element){
		this.sb.gaTrack('Cart','TimeEstimation','Delivery time estimation in cart');
		this.initializeShipEstDomElems();
		this.structureShipData();
		this.renderSelectableCountries();
		this.shipEstDomElems.holderElem.toggle();
		this.sb.attachEvents(this.shipEstDomElems.shipEstBtn, 'click', this.getEstimatedShippingTime, this);
	},
	updateOptions : function(event){
		event.stop();
		var updateButton = event.currentTarget;
		updateButton.hide();
		this.isUpdated = true;
		var rowElement = this.rowElement = $(updateButton).up('tr');
		rowElement.setAttribute('isUpdating', true);
		var cartContainer = rowElement.up('.cart-container');
		var sb = this.sb;
		sb.screenBlocker.show(cartContainer, true, this.updateMess);
		sb.gaTrack('Cart','Update','Updating product in the cart');
		var itemId = rowElement.readAttribute('itemId');
		var updateUrl = rowElement.readAttribute('updateUrl');
		var params = {};
		var kitTypeElement = $(rowElement).down('.cart-kit-type-select');
		var kitNumber = $(kitTypeElement).querySelector('.selectionBackground').getAttribute('listid');
		this.optionId = params[kitTypeElement.readAttribute('name')] = kitNumber;
		params['efk_kType'] = kitNumber;
		this.productId = params['product'] = rowElement.readAttribute('product');
		params['qty'] = $(rowElement).down('.qty').value;
		params['related_product'] = '';
		params['id'] = itemId;
		var url = this.sb.removeHTTP(updateUrl);
		var request = new Ajax.Request(
            url,
            {
                method:'post',
                parameters: Object.toQueryString(params),
                onComplete: this.complete,
                onSuccess: this.updateCartItems.bind(this),
                onFailure: this.failure
            }
        );
	},
	updateCartItems : function(data){
		var response = JSON.parse(data.responseText);
		var data = response.data;
		var rowElem = this.rowElement;
		var cart = rowElem.up('#popup-container');
		if(response.success){
			rowElem.down('.del-price').innerHTML =  '<del><span class="webRupee">Rs. </span>' + data.oldPrice + '</del>';
			rowElem.down('.unit-price').innerHTML = '<span class="webRupee">Rs. </span>' + data.itemPrice;
			rowElem.down('.row-total').innerHTML = '<span class="webRupee">Rs. </span>' + data.rowTotal;
			this.checkSameProjectExists();
			rowElem.writeAttribute('itemid', data.itemId);
			
			//change the id of cart item and remove updatinf attribute
			var itemId = 'item-' + this.productId + '-' + this.optionId;
			rowElem.writeAttribute('id', itemId);
			$(itemId).removeAttribute('isUpdating');
			
			rowElem.down('.qty').value = data.qty;
			rowElem.down('.qty').setAttribute('oldValue', data.qty);
			rowElem.down('.cart-item-remove').writeAttribute('href',data.removeUrl);
			this.updateTotals(cart, data);
		}
		this.showGlobalErrorMess(cart, data);
		this.showInlineErrorMess(rowElem, data);
		this.sb.screenBlocker.hide(cart);
	},
	checkSameProjectExists : function(){
		var itemId = 'item-' + this.productId + '-' + this.optionId;
		var item = $(itemId);
		
		//if there is same item exists as udpated item then remove the duplicate item 
		if(item && ! item.hasAttribute('isUpdating')) {
			item.remove();
		}
	},
	showInlineErrorMess : function(rowElem, data){
		var errorMess = rowElem.down('.errorMessageInline');
		errorMess.innerHTML = data.message;
		var errorMessIcon = rowElem.down('.errorMessageInlineIcon');
		if(data.updated){
			errorMessIcon.removeClassName('smallAlertIcon');
			errorMessIcon.addClassName('smallUpdateIcon');
		}else{ //if(data.revised){
			errorMessIcon.removeClassName('smallUpdateIcon');
			errorMessIcon.addClassName('smallAlertIcon');
		}
		errorMessIcon.show();
		errorMess.show();
	},
	showGlobalErrorMess : function(cart, data){
		//Checking for COD overflow
		var totalAmt = data.totalAmt;
		var popupMsg = cart.down('.popupErrorMsg');
		var codElem = cart.down('.higherCOD');
		var globalMess = popupMsg.down('.globalMess');
		if(!popupMsg){
			//console.log('Check for error message div in cart');
			return;
		}
		if(totalAmt >= this.codLimit || data.globalMess){
			popupMsg.show();
		}else{
			popupMsg.hide();
		}
		//Checking for COD over limit
		if(codElem){
			if(totalAmt >= this.codLimit){
				codElem.show();
			}else{
				codElem.hide();
			}
		}
		//Showing global message regarding items update
		if(globalMess){
			if(data.globalMess){
				var errorMess = globalMess.down('.error-message');
				errorMess.innerHTML = data.globalMess;
				globalMess.show();
			}else{
				globalMess.hide();
			}
		}
	},
	hideGlobalErrorMess : function(event){
		var currElem = event.currentTarget;
		var popupMsg = currElem.up('.popupErrorMsg');
		if(popupMsg){
			var globalMess = popupMsg.down('.globalMess');
			var codMess = popupMsg.down('.higherCOD');
			if(globalMess){
				var errorMess = globalMess.down('.error-message');
				errorMess.innerHTML = '';
				globalMess.hide();
			}
			if(codMess){
				codMess.hide();
			}
			popupMsg.hide();
		}
	},
	updateTotals : function(cart, data){
		cart.down('.original-price').innerHTML = '<span class="webRupee">Rs. </span>' + data.orgCost;
		cart.down('.price-deduction').innerHTML = '<span class="webRupee">Rs. </span>' + data.deduction;
		cart.down('.total-savings').innerHTML = '<span class="webRupee">Rs. </span>' + data.savings;
		cart.down('.special-price').innerHTML = '<span class="webRupee">Rs. </span>' + data.specialdiscount;
		cart.down('.discount-price').innerHTML = '<span class="webRupee">Rs. </span>' + data.discount;
		cart.down('.grand-total-price').innerHTML = '<span class="webRupee">Rs. </span>' + data.grandTotal;
		cart.down('.cart-total-items').innerHTML = data.totalItems;
		this.topCartButton.down('.edgefxCartCount').innerHTML = data.totalItems;
	},
	removeCartItem : function(event){
		event.stop();
		this.isUpdated = true;
		var removeBtn = event.currentTarget;
		var url = removeBtn.readAttribute('href');
		rowElement = this.removeElement = removeBtn.up('tr');
		var cartContainer = rowElement.up('.cart-container');
		var sb = this.sb;
		sb.screenBlocker.show(cartContainer, true, this.updateMess);
		sb.gaTrack('Cart','Remove','Removing product from cart');
		url = this.sb.removeHTTP(url);
		var request = new Ajax.Request(
            url,
            {
                method:'post',
                onComplete: this.complete,
                onSuccess: this.removeCartItemHandle.bind(this),
                onFailure: this.failure
            }
        );
		
	},
	removeCartItemHandle : function(data){
		var response = JSON.parse(data.responseText);
		var respData = response.data;
		var removeElem = this.removeElement;
		var cart = removeElem.up('#popup-container');
		if(response.success){
			if(!respData.totalItems){
				if(respData.html){
					var popupTemplateObject = this.popupTemplateObject;
					popupTemplateObject.showPopup(respData.html);
					this.attachCartFormEvents();
				}else{
					this.getEmptyCart();
				}
				this.topCartButton.down('.edgefxCartCount').innerHTML = 0;
				return;
			}else{
				removeElem.remove();
				this.updateTotals(cart, respData);
			}
			this.showGlobalErrorMess(cart, respData);
		}
		//cart.down('.error-message').innerHTML = data.message;
		//cart.down('.error-message').show();
		this.sb.screenBlocker.hide(cart);
		
	},
	updateCartItemHandle : function(data){
		var response = JSON.parse(data.responseText);
		var data = response.data;
		var removeElem = this.removeElement;
		var cart = removeElem.up('#popup-container');
		if(response.success){
			this.updateTotals(cart, data);
		} 
	},
	getEmptyCart : function(data){
		var cartLink = $$('.top-link-cart')[0];
		var event = {
			stop : function(){},
			currentTarget : cartLink
		};
		this.getCart(event, true);
	},
	//TO update quantity only from default code..
	updateCart : function(event){
		event.stop();
		var sb = this.sb;
		sb.gaTrack('Cart','Update','Updating cart');
		/*var cartForm = new VarienForm('shopping-cart-form');
		var form = cartForm.form;
		//cartForm.submit();
		var request = new Ajax.Request(
            form.action,
            {
                method:'post',
                parameters: Form.serialize('shopping-cart-form'),
                onComplete: this.complete,
                onSuccess: this.updateCartItemHandle.bind(this),
                onFailure: this.failure
            }
        );
		this.getEmptyCart();*/
	},
	attachProjectDetailsEvents : function(){
		var sb = this.sb;
		var prodBuyBtns = $$('.kit-buy-text');
		if(prodBuyBtns.length){
			sb.attachEvents(prodBuyBtns,'click',this.addProductToCart,this);
        }
	},
	addProductToCart : function(event){
		event.stop();
		this.sb.gaTrack('Cart','Add','Adding product to cart from project details page');
		this.incrementCartQty();
		var cartMeta = this.getCurrentCartMeta();
		var buyElem = event.currentTarget;
		var form = buyElem.up('form');
		var select = form.down('.super-attribute-select');
		var kitTypeName = buyElem.readAttribute('data-kit');
		select.value = kitTypeName;
		var validator = new Validation(form.id);
        if (validator.validate()) {
            var url = form.action;
            url = this.sb.removeHTTP(url);
            var params = Form.serialize(form.id);
            this.popupTemplateObject.showPopUpOnPageLoad({
				"headerTitle": cartMeta.text,
				"minH": "475px",
				"commonPopupCls": ['cartpopup'],
				"emptyFlag": true
			});
            var request = new Ajax.Request(
            url,
            {
                method:'post',
                parameters : params,
                onComplete: this.attachCartPopupEvents.bind(this),
                onSuccess: this.showCart.bind(this),
                onFailure: this.failure
            }
        );
            
        }
	},
	closeCart : function(){
		this.sb.gaTrack('Cart','Close','Closing cart');
		var popupContainer = $('popup-container');
		popupContainer.update().hide();
		//var body = $$('body')[0];
		//this.sb.screenBlocker.show(body);
		//window.location.reload();
		//if(this.isUpdated){
			//this.sb.screenBlocker.hide(body);
		//}else{
			//this.sb.screenBlocker.hide(body);	
		//}
	},
	gotoCheckout : function(){
		var popupContainer = $('popup-container');
		popupContainer.hide();
		var body = $$('body')[0];
		this.sb.screenBlocker.show(body);
		this.sb.gaTrack('Cart','Moving away','Moving to checkout from cart');
	},
	incrementCartQty : function(){
		var cartButton = this.topCartButton;
		var cartQty = parseInt(cartButton.down('.edgefxCartCount').innerHTML);
		if(!isNaN(cartQty)){
			cartButton.down('.edgefxCartCount').innerHTML = cartQty + 1;
		}
	},
	getCurrentCartMeta : function() {
		var cartMeta = {
			'text': '',
			'count': ''
		};
		var cartCount = parseInt(this.topCartButton.down('.edgefxCartCount').innerHTML);
		cartMeta.count = (!isNaN(cartCount)) ? cartCount : 0;
		cartMeta.text = 'CART - ' + cartMeta.count + " ITEMS(s)";
		return cartMeta;
	},
	structureShipData : function() {
		var shipingDataLen = this.shippingData['countryList'].length;
		if(shipingDataLen) {
			for(var i = 0; i < shipingDataLen; i++) {
				var curCountryObj = this.shippingData['countryList'][i];
				this.shippingDataAssoc[curCountryObj.id] = curCountryObj;
			}
		}
	},
	//@TODO: Need to make use of this routine for both initializing country and city drop downs
	renderSelectableCountries : function() {
			var options = {
					callbackFunction: this.shipDestSelectCallback.bind(this),
					defaultSelectedElement: this.shippingData['defaultId'],
					css: {
						showBorder: true,
						showMenuIcon: true,
						borderLeftClass: '',
						borderMiddleClass: '',
						borderRightClass: '',
						dropDownArrowClass: 'simpleDropDownArrow',
						menuIconClass: '',
						dropDownListClass: ''
					}
			};
				var shipCountryDrop = new SimpleDropdown('shipCountryDrpElem', this.shippingData['countryList'], options);
			    shipCountryDrop.init();
	},
	shipDestSelectCallback : function(obj) {
		this.shippingModel.selectedCountryCode = obj.id;
		//Code for getting selected cities for the coountry selected comes here.
		
		//Displays either pin code input or City input (or) dropdown based on the country selected
		//If pin code is not applicable for that country then City input or dropdpwn is displayed.
		this.displaySubRegionOption(obj.id);
	},
	displaySubRegionOption : function(countryId) {
		var isPinOptional = this.shippingDataAssoc[countryId].optionalFlag;
		this.shipEstDomElems.subRegionSelectElem.each(function(element) {
															element.setStyle({display : 'none'});
															element.value = '';
														});
		
		if(isPinOptional) {
			this.shipEstDomElems.selectedCityInput.style.display = "block";	
		} else {
			this.shipEstDomElems.pinCodeRegion.style.display = "block";
		}
	},
	initializeShipEstDomElems : function() {
		this.shipEstDomElems = {
			'holderElem' : $(this.cartPopup).down('.shippingTimeCalculationDetails'),
			'msgHolder' : $(this.cartPopup).down('.shipEstMessageHolder'),
			'shipEstBtn' : $(this.cartPopup).down('.deliveryTimeBtn'),
			'formDOMElem' : $(this.cartPopup).down('.shipEstForm'),
			'textHolder' : $(this.cartPopup).down('.shipEstTextHolder'),
			'subRegionSelectElem' : $(this.cartPopup).select('.subRegionSelectElem'),
			'pinCodeRegion': $(this.cartPopup).down('.pinCodeRegion'),
			'selectedCityInput': $(this.cartPopup).down('.selectedCityInput')
		};
	},
	getEstimatedShippingTime : function() {
		//Initialize the DOM Elems
		this.initializeShipEstDomElems();
		
		//Before making the ship estimate call we don't need the ship message to be diplayed
		this.shipEstDomElems.msgHolder.style.display = "none";

		//Validations...
		if(this.validation.isValidated(this.shipEstDomElems.formDOMElem)){
			//Do the required validations for the shipping estimate form
			//like Empty Zip Code, Empty area selected(if pin code is not applicable for selected country)
			//We also need to verify whether a country is selected or not
			var url = this.shipEstDomElems.shipEstBtn.readAttribute('href');
			this.sb.gaTrack('Cart','Shipping','Estimated Shipping time is being calculated');
			url = this.sb.removeHTTP(url);
		 	
		 	this.sb.screenBlocker.show(this.shipEstDomElems.holderElem, true);
		 	this.shipEstDomElems.holderElem.style.minHeight = '112px';
		 	
			var paramsObj = {
					'pincode': this.shipEstDomElems.pinCodeRegion.value,
					'countrycode': this.shippingModel.selectedCountryCode||this.shippingData['defaultId'],
				};
			
			var request = new Ajax.Request(
	            url,
	            {
	                method:'post',
	                parameters: paramsObj,
	                onComplete: '',
	                onSuccess: this.shipEstCallback.bind(this),
	                onFailure: this.shipEstCallback.bind(this)
	            }
	        );
		} else {
			//If there is an error in the validation, then hide the shipping time estimate message
			this.shipEstDomElems.holderElem.style.minHeight = '144px';	
		}
	},
	shipEstCallback : function(response) {
		var responseObj = response.responseJSON;
		this.sb.screenBlocker.hide(this.shipEstDomElems.holderElem);
		this.shipEstDomElems.msgHolder.style.display = "block";
		
		if(responseObj.success) {
			var daysCount = responseObj.data.daysCount;
			this.shipEstDomElems.holderElem.style.minHeight = '157px';
			this.shipEstDomElems.textHolder.textContent = "Your order will be delivered in " +  daysCount + " days";
		} else {
			this.shipEstDomElems.holderElem.style.minHeight = '168px';
			this.shipEstDomElems.textHolder.textContent = responseObj.message;
		}
	}
};
var CouponClass = Class.create(); 
CouponClass.prototype = {
	sb : new SandBox(),
	updateCoupon : null,
	removeCoupon : null,
	initialize : function(){
		this.success = this.onSuccess.bind(this);
		this.complete = this.onComplete.bind(this);
		this.failure = this.onFailure.bind(this);
	},
	attachCouponEvents : function(){
		var sb = this.sb;
		var cartPopup = $('popup-container');
		this.cartPopup = cartPopup;
		var addCouponLabel = $(cartPopup).select('#add-coupon-code')[0];
		sb.attachEvents(addCouponLabel,'click',this.showCouponForm,this);
		var couponBtns = $(cartPopup).select('.cart-action');
		sb.attachEvents(couponBtns,'click',this.updateCoupon,this);
		var couponField = $(cartPopup).down('#coupon_code');
		sb.attachEvents(couponField,'keypress',this.hideCouponError,this);
	},
	showCouponForm : function(event){
		this.sb.gaTrack('CartCoupon','Show','Showing coupon form');
		var addCouponLabel = event.currentTarget;
		var cartPopup = this.cartPopup;
		var addCoupon = $(cartPopup).select('#add-coupon-form-container')[0];
		this.form = addCoupon;
		addCouponLabel.addClassName('hide');
		addCoupon.removeClassName('hide');
	},
	showAddedCoupon : function(data){
		var cartPopup = this.cartPopup;
		var addCoupon = $(cartPopup).select('#add-coupon-form-container')[0];
		var removeCoupon = $(cartPopup).select('#remove-coupon-form-container')[0];
		$(removeCoupon).select('.coupon-text')[0].innerHTML = data.couponCode;
		addCoupon.addClassName('hide');
		removeCoupon.removeClassName('hide');
	},
	showAddCouponCode : function(){
		var cartPopup = this.cartPopup;
		var removeCoupon = cartPopup.down('#remove-coupon-form-container');
		removeCoupon.addClassName('hide');
		cartPopup.down('#add-coupon-code').removeClassName('hide');
		cartPopup.down('#coupon_code').value = '';
		$(removeCoupon).select('.coupon-text')[0].innerHTML = '';
	},
	updateCoupon : function(event){
		event.stop();
		var cartPopup = $('popup-container');
		var currTarget = event.currentTarget;
		var form = $(currTarget).up('form');
		var url = form.action;
		var isRemove = currTarget.hasAttribute('remove');
		var couponCode = $(cartPopup).select('#coupon_code')[0];
		var removeCouponCode = $(cartPopup).select('#remove-coupone')[0];
	    if (isRemove) {
	        couponCode.removeClassName('required-entry');
	        removeCouponCode.value = "1";
	    } else {
	        couponCode.addClassName('required-entry');
	        removeCouponCode.value = "0";
	        if(!couponCode.value){
	        	var data = {
	        		'message' : 'Please enter coupon code'
	        	};
	        	this.showError(data);
	        	return;
	        }
	    }
	    var formValidator = new Validation(form.id);
	    if(formValidator.validate()){
	    	url = this.sb.removeHTTP(url);
		    var request = new Ajax.Request(
	            url,
	            {
	                method:'post',
	                parameters: Form.serialize(form.id),
	                onComplete: this.complete,
	                onSuccess: this.success,
	                onFailure: this.failure
	            }
	        );
       }
	},
	onSuccess : function(data){
		var response = JSON.parse(data.responseText);
		if(response.success){
			this.updateCart(response.data);
		}else{
			this.showError(response.data);
		}
	},
	onComplete : function(data){
		console.log('complete');
	},
	onFailure : function(data){
		alert('Server is not connecting: Please try again later.');
	},
	updateCart : function(data){
		var cartPopup = $('popup-container');
		if(data.cancelled){
			this.sb.gaTrack('CartCoupon','Remove','Removing coupon code');
			this.showAddCouponCode();
		}else{
			this.sb.gaTrack('CartCoupon','Add','Adding coupon code');
			this.showAddedCoupon(data);
		}
		cartPopup.down('.discount-price').innerHTML = data.discount;
		cartPopup.down('.grand-total-price').innerHTML = data.grandTotal;
		cartPopup.down('.special-price').innerHTML = data.specialdiscount;
		cartPopup.down('.total-savings').innerHTML = data.savings;
	},
	showError : function(data){
		var cartPopup = $('popup-container');
		cartPopup.down('#coupon_code').addClassName('validation-failed');
		this.form.down('.validation-message').innerHTML = data.message;
		this.form.down('.validation-message').show();
	},
	hideCouponError : function(){
		var cartPopup = $('popup-container');
		cartPopup.down('#coupon_code').removeClassName('validation-failed');
		this.form.down('.validation-message').innerHTML = '';
		this.form.down('.validation-message').hide();
	}
	
};

document.observe("dom:loaded", function() {
	popupCart = new PopupCartClass({codLimit:20000});
	couponObject = new CouponClass();
});