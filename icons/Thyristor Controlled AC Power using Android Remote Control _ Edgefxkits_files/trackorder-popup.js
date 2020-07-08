/**
 *
 * @theme    efk
 * @package     default
 * @copyright   edgefxteam@divami.com
 */

var PopupTrackOrderClass = Class.create();
PopupTrackOrderClass.prototype = {
	params : {},
    initialize : function(){
    	var sb = this.sb;
		this.success = this.onSuccess.bind(this);
		this.complete = this.onComplete.bind(this);
		this.failure = this.onFailure.bind(this);
		this.ongetorders = this.onGetOrders.bind(this);
		this.displayFedexTracking = this.displayFedExTracking.bind(this);
		sb.attachEvents($$('.track-order'), 'click', this.showTrackOrderPopup, this);
	},
	
	sb : new SandBox(),
    popupTemplateObject : new PopupTemplateClass(),
    firstOrder: false,
    currentElem: null,
	
	showTrackOrderPopup : function(event){
		event.preventDefault();
		this.sb.gaTrack('Track Order','click','Opening the track order');
		var element = event.currentTarget;
		var url = element.readAttribute('href');
		url = this.sb.removeHTTP(url);
		
		this.popupTemplateObject.showPopUpOnPageLoad({
									"headerTitle": "TRACK ORDER",
									"minH": "300px",
									"commonPopupCls": ['trackorderpopupContainer']
							});
		
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
			var trackOrder = $(domElement).select('.efk-track-order')[0];
			popupTemplateObject.showPopup(trackOrder);
		} else {
			this.popupTemplateObject.closePopup();
		}
	},
	
	onComplete : function(data) {
		var sb = this.sb;
		var trackOrderPopup = $('popup-container');
		var isUserLoggedIn = parseInt(trackOrderPopup.down('#is-user-login').value);
		var myorderContainer = trackOrderPopup.select('.my-orders-container')[0];
		if(isUserLoggedIn) {
			Element.hide($(trackOrderPopup).select('.track-order-container')[0]);
			this.currentElem = myorderContainer;
			var orderContainer = $(myorderContainer).select('.ordersList')[0];
			if(orderContainer) {
				var trackOrderBody = $(myorderContainer).select('.trackOrderBodyContainer')[0];
				this.removePreviousScroll(orderContainer);
				scroll.useSlimScroll(orderContainer);
				this.handleFedexTableScroll();
				this.handleTableRowClick('my-order-table');
				this.adjustTrackorderWidth(true);
			} else {
				this.adjustTrackorderWidth(false);
			}
		} else {
			this.currentElem = trackOrderPopup.select('.track-order-container')[0];
			Element.hide($(myorderContainer));
			Element.hide($(trackOrderPopup).select('.track-order-container .back-to-myorders-action')[0]);
		}
		var dataContainer = trackOrderPopup.select('.edgefxpopupContainer');
		sb.showPopupInMiddle(dataContainer[0]);
		var showStatusBtn = $(trackOrderPopup).select('.show-status-action')[0];
		var trackDiffOrderLnk = $(trackOrderPopup).select('.track-different-order-action')[0];
		var backToMyOrdersLnk = $(trackOrderPopup).select('.back-to-myorders-action')[0];
		var emailTextField = $(trackOrderPopup).select('#email_address')[0];
		
		$$('.efk-track-order-body #ordernumber')[0].focus();
		
		sb.attachEvents(showStatusBtn, 'click', this.getOrders, this);
		sb.attachEvents(trackDiffOrderLnk, 'click', this.showTrackOrder, this);
		sb.attachEvents(backToMyOrdersLnk, 'click', this.showMyOrders, this);
		sb.attachEvents(emailTextField, 'blur', this.onBlurFromEmailField, this);
	},
	
	onFailure : function(data) {
		console.log('onFailure');
		this.popupTemplateObject.closePopup();
	},
	
	showMyOrders : function(event) {
		this.sb.gaTrack('Track Order','toggle to uyser orders','Login user moving to my orders from different orders tab');
		var trackOrderPopup = $('popup-container');
		var myorderContainer = $(trackOrderPopup).select('.my-orders-container')[0];
		var trackorderContainer = $(trackOrderPopup).select('.track-order-container')[0];
		Element.hide(trackorderContainer);
		Element.show(myorderContainer);
		trackOrderPopup.down('.efk-track-order .edgefxpopupTitle').update('MY ORDERS');
		this.currentElem = myorderContainer;
		var orderContainer = $(myorderContainer).select('.ordersList')[0];
		if(orderContainer) {
			this.adjustTrackorderWidth(true);
		} else {
			this.adjustTrackorderWidth(false);
		}
		
		//Adjusting height position
		var dataContainer = trackOrderPopup.select('.edgefxpopupContainer');
		this.sb.showPopupInMiddle(dataContainer[0]);
	},
	
	getOrders : function(event) {
		event.stop();
		var element = event.currentTarget;
		var url = element.select('#show-status-action')[0].readAttribute('url');
		var form = element.up('form');
		var orderNumber = form.down('#ordernumber').value;
		var email = form.down('#email_address').value;
		var me = this;
		this.removeErrorMessage();
		
		$('popup-container').select('.track-order-container .show-orders-list')[0].hide();
		if(!orderNumber && !email) {
			this.updateErrorMessage('Enter either order number or email');
			this.setErrorField();
		} else if(!orderNumber && !this.validateEmail(email)) {
			this.updateErrorMessage('Not a valid Email address');
			this.setEmailErrorField();
		} else {
			this.resetErrorFields();
			var elementToBlock = $$('.efk-track-order-body')[0];
			me.sb.screenBlocker.hide(elementToBlock);
			me.sb.screenBlocker.show(elementToBlock, true);
			url = me.sb.removeHTTP(url);
			var request = new Ajax.Request(
	            url,
	            {
	                method:'post',
	                parameters: {
	                    'email' : email,
	                    'ordernumber' : orderNumber
	                },
	                onSuccess: me.ongetorders,
	            }
	        );
		}
	},
	setErrorField : function(){
		this.setField('#ordernumber', true);
		// this.setField('#email_address', true);
		var elem = $$('.trackOrderInitial')[0].down('#email_address');
		elem.addClassName('special-error-field');
	},
	
	setOrderErrorField : function(){
		this.resetErrorFields();
		this.setField('#ordernumber', true);
	},
	
	setEmailErrorField : function(){
		this.resetErrorFields();
		this.setField('#email_address', true);
	},
	
	resetErrorFields : function(){
		this.setField('#ordernumber');
		this.setField('#email_address');
	},
	
	setField : function(text, bln){
		var elem = $$('.trackOrderInitial')[0].down(text);
		if(bln){
			elem.addClassName('special-error-field');
			elem.focus();
		}
		else{
			elem.removeClassName('special-error-field');
		}
	},
	
	onBlurFromEmailField : function(event) {
		var value = event.currentTarget.value;
		/*var orderNumber = $$('.trackOrderInitial #ordernumber')[0].value;
		if(orderNumber == "" && value == "") {
			this.updateErrorMessage('Enter either order number or email');
		}*/
		if(this.validateEmail(value)) {
			return;
		} else if(value) {
			this.updateErrorMessage('Not a valid Email address');
		}
	},
	
	validateEmail:function(emailAddress){
        var filter = /^([\w-\.]+)@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.)|(([\w-]+\.)+))([a-zA-Z]{2,4}|[0-9]{1,3})(\]?)$/;

        if (filter.test(emailAddress)) {
            return true;
        }
        else {
            return false;
        }
    },
    
    removeErrorMessage : function() {
    	var trackOrderPopup = $('popup-container');
    	$(trackOrderPopup).down('.err-message').update('');
    },
    
    updateErrorMessage : function(msg) {
    	var trackOrderPopup = $('popup-container');
    	$(trackOrderPopup).down('.err-message').update(msg);
    },
	
	onGetOrders : function(response) {
		var trackOrderPopup = $('popup-container');
		var orderContainer = trackOrderPopup.select('.ordersList')[0];
		var orders = response.responseText.evalJSON();
		var len = orders.length;
		
		var elementToBlock = $$('.efk-track-order-body')[0];
		this.sb.screenBlocker.hide(elementToBlock);
		this.sb.gaTrack('Track Order','show status','Showing the results');
		
		if(len <= 0) {
			var orderNumber = $$('.trackOrderInitial #ordernumber')[0].value;
			var email = $$('.trackOrderInitial #email_address')[0].value;
			var msg = '';
			if(orderNumber && email) {
				msg = orderNumber + ' / ' + email;
			} else {
				msg = orderNumber + '' + email;
			}
			this.updateErrorMessage(msg + ' does not exists.');
			if(email.length != 0 && orderNumber.length != 0){
				this.setErrorField();
			}
			else if(email.length == 0){
				this.setOrderErrorField();
			}
			else if(orderNumber.length == 0){
				this.setEmailErrorField();
			}
			return;
		}
		var showOrdersTable = $(trackOrderPopup).select('.track-order-container .show-orders-list')[0];
		var showOrdersTableBody = $(showOrdersTable).select('.trackOrderContentContainer table tbody')[0];
		var temp;
		
		Element.hide(showOrdersTable);
		showOrdersTableBody.update('');
		var evenRow = '';
		var selected = '';
		for(var i = 0; i < len; i++) {
			evenRow = '';
			selected = '';
			if((i+1) % 2 == 0) {
				evenRow = 'trackOrderEvenRow';
			} else if(i==0) {
				selected = 'selectedOrder';
			}
			var trackurl = orders[i].trackurl;
			temp = "<tr class=\"fontOpenReg font_12 textColor5050 textAlignLeft trackOrderRow " + evenRow + selected+ "\"><td class=\"trackOrderTableFirstCol\">" + orders[i].ordernumber + "</td>" +
	            	"<td class=\"trackOrderTableSecondCol\">" + orders[i].dateoforder + "</td>" +
	            	"<td class=\"trackOrderTableThirdCol\"><span class='webRupee'>RS. </span>" + orders[i].amount + "</td>" +
	            	"<td class=\"trackOrderTableFourthCol textAlignCen\">" + orders[i].items + "</td>" +
	            	"<td class=\"trackOrderTableFifthCol\"> <div class=\"edgefxSpriteImage trackStatusImage leftFloat\"> </div> <div class=\"trackStatusMsg leftFloat\">" + orders[i].orderstatus + "</div></td>"+
	            	"<td class=\"lastCol\">" + trackurl + "</td></tr>" ;
	            	
	       
	         showOrdersTableBody.insert(temp);
	         
	         var clonenode = "<tr class=\"fontOpenReg font_12 textColor5050 textAlignLeft trackOrderRow maskClass pAbsolute " + evenRow + "\" style=\"display:none;\"><td class=\"trackOrderTableFirstCol\">" + orders[i].ordernumber + "</td>" +
	            	"<td class=\"trackOrderTableSecondCol\">" + orders[i].dateoforder + "</td>" +
	            	"<td class=\"trackOrderTableThirdCol\"><span class='webRupee'>RS. </span>" + orders[i].amount + "</td>" +
	            	"<td class=\"trackOrderTableFourthCol textAlignCen\">" + orders[i].items + "</td>" +
	            	"<td class=\"trackOrderTableFifthCol\"> <div class=\"edgefxSpriteImage trackStatusImage leftFloat\"> </div> <div class=\"trackStatusMsg leftFloat\">" + orders[i].orderstatus + "</div></td>"+
	            	"<td class=\"lastCol\">" + trackurl + "</td></tr>" ;
	         showOrdersTableBody.insert(clonenode); 
	         if(i == 0) {
	         	if(orders[i].trackInfo != null) {
		         	this.firstOrder = true;
					this.displayFedExTracking(orders[i].trackInfo);
				} else {
					this.dispalyNoTackData();
				}
			}
		}
		Element.show(showOrdersTable);
		this.adjustTrackorderWidth(true);
		var dataContainer = trackOrderPopup.select('.edgefxpopupContainer');
		this.sb.showPopupInMiddle(dataContainer[0]);
		this.removePreviousScroll(orderContainer);
		scroll.useSlimScroll(orderContainer);
		//Handle fedex scroll for initial load
		this.handleFedexTableScroll();
		this.handleTableRowClick('track-order-table');
	},
	
	handleFedexTableScroll: function() {
		var elementToBlock = this.currentElem.select('.fedexTableContainer')[0];
		this.removePreviousScroll(elementToBlock);
		scroll.useSlimScroll(elementToBlock);
	},
	
	removePreviousScroll: function(scrollElem) {
		var contentElem = $(scrollElem).select('.content')[0];
		if(contentElem != null) {
			var html = contentElem.innerHTML;
			$(scrollElem).innerHTML = '';
			$(scrollElem).innerHTML = html;
		} 
	},
	
	handleTableRowClick: function(table) {
		var table = $(table);
	    var rows = table.getElementsByTagName("tr");
	    for (i = 0; i < rows.length; i++) {
	        var currentRow = table.rows[i];
	        this.sb.attachEvents(currentRow, 'click', this.trackOrderByNum, this);
	    }	
	},
	
	trackOrderByNum: function(event) {
		event.stop();
		var me = this;
		var row = event.currentTarget;
		var prevOrder = $(row).parentElement.select('tr.selectedOrder')[0];
		if(prevOrder != row) {
			this.handleHiddenRowClick(row);
			if($(prevOrder) == null){
				prevOrder = row.parentElement.select('tr:first')[0];
			}
			if($(prevOrder).hasClassName('selectedOrder')){
				var selectedNode = $(prevOrder).next(); 
				$(prevOrder).removeClassName('selectedOrder');
				$(selectedNode).style.display = 'none';
			}
			$(row).addClassName('selectedOrder');
			this.changeArrowPointer(row);
			var rowOffset = row.offsetTop;
			var column = row.getElementsByTagName("td")[5];
			var url = column.textContent;
			url = this.sb.removeHTTP(url);
			if(url != '') {
				var elementToBlock = this.currentElem.select('.fedexTableContainer')[0];
				me.sb.screenBlocker.hide(elementToBlock);
				me.sb.screenBlocker.show(elementToBlock, true);
				
				var request = new Ajax.Request(
		            url,
		            {
		                method: 'post',
		                onSuccess: me.displayFedexTracking,
		            }
		        );
			} else {
				this.dispalyNoTackData();
			}
		}
	},
	
	handleHiddenRowClick: function(row) {
		var wrapper = row.up('.wrapper');
		if(wrapper != null) {
			var scrollTop = wrapper.scrollTop;
			var offsetTop = row.offsetTop;
			var diff = offsetTop - scrollTop;
			if(offsetTop < scrollTop) {
				wrapper.scrollTop = offsetTop;
			} else if(150 < diff){
				wrapper.scrollTop = scrollTop + 40; // 40 is row height
			}
		}
		
	},
	
	changeArrowPointer: function(row) {
		var trackOrderPopup = $('popup-container');
		var parentContainer = row.up('.trackOrderContentContainer');
		var arrowParent = row.up('.show-orders-list');
		var wrapper = $(parentContainer).select('.wrapper')[0];
		var parentScroll;
		if(wrapper) {
			parentScroll = wrapper.scrollTop;
		} else {
			parentScroll = 0;
		}
		var arrowImage = $(arrowParent).select('.fedexArrowImage')[0];
		var rowOffset = row.offsetTop;
		var maxLimit = rowOffset - parentScroll + 56;
		if(maxLimit > 201) {
			$(arrowImage).setStyle({
			 	top: 201 + 'px'
			 });
		} else {
			$(arrowImage).setStyle({
		 		top: rowOffset - parentScroll + 56 + 'px'
		 	}); 
		}
		
	},
	
	displayFedExTracking: function(response) {
		var elementToBlock = this.currentElem.select('.fedexTableContainer')[0];
		var fedexTable = this.currentElem.select('.fedexTabelHolder')[0];
		this.sb.screenBlocker.hide(elementToBlock);
		var trackOrderPopup = $('popup-container');
		if(this.firstOrder) {
			var orders = response.evalJSON();
			this.firstOrder = false;
		} else {
			var orders = response.responseText.evalJSON();
		}
		if(orders != null) {
			var showOrdersTableBody = $(this.currentElem).select('.fedexTableContainer table tbody')[0];
			showOrdersTableBody.update('');
			var len = orders.length;
			for(var i = 0; i < len; i++) {
				evenRow = '';
				
				temp = " <tr class=\"fontOpenReg textAlignLeft fedexOrderRow\"><td class=\"fedexOrderTableFirstCol\">" + orders[i].location + "</td>" +
		            	"<td class=\"fedexOrderTableSecondCol\">" + orders[i].localdate + "</td>" +
		            	"<td class=\"fedexOrderTableThirdCol\">" + orders[i].timestamp + "</td>" +
		            	"<td class=\"fedexOrderTableFourthCol\">" + orders[i].description + "</td></tr>" ;
		       
		         showOrdersTableBody.insert(temp);
			}
		} else {
			this.dispalyNoTackData();
		}
		this.handleFedexTableScroll();
	},
	
	dispalyNoTackData: function() {
		var trackOrderPopup = $('popup-container');
		var showOrdersTableBody = this.currentElem.select('.fedexTableContainer table tbody')[0];
		var temp;
		showOrdersTableBody.update('');
		temp = "<tr class=\"fontOpenReg textAlignLeft trackOrderRow \"><td style=\"padding-left:10px;\">" + "Location and Time details are not available for this shipment" + "</td></tr>" ;
        showOrdersTableBody.insert(temp);
	},
	
	showTrackOrder : function(event) {
		var trackOrderPopup = $('popup-container');
		this.sb.gaTrack('Track Order','track different','Login user is trying to see other orders status');
		var myorderContainer = $(trackOrderPopup).select('.my-orders-container')[0];
		var trackorderContainer = $(trackOrderPopup).select('.track-order-container')[0];
		this.currentElem = trackorderContainer;
		Element.hide($(trackOrderPopup).select('.my-orders-container')[0]);
		Element.show($(trackOrderPopup).select('.track-order-container')[0]);
		Element.show($(trackOrderPopup).select('.track-order-container .back-to-myorders-action')[0]);
		var trackData = $('track-order-table').select('tr').length;
		if(trackData != 0) {
			this.adjustTrackorderWidth(true);
		} else {
			this.adjustTrackorderWidth(false);
		}
		var dataContainer = trackOrderPopup.select('.edgefxpopupContainer');
		this.sb.showPopupInMiddle(dataContainer[0]);
		trackOrderPopup.down('.efk-track-order .edgefxpopupTitle').update('TRACK ORDER');
		$$('.efk-track-order-body #ordernumber')[0].focus();
	},
	
	adjustTrackorderWidth: function(expand) {
		var trackOrderPopup = $('popup-container').select('.trackorderpopupContainer')[0];
		if(expand) {
			trackOrderPopup.style.width = 1300 + 'px';
		} else {
			trackOrderPopup.style.width = 703 + 'px';
		}
		
	},
	
};

document.observe("dom:loaded", function() {
    trackorder = new PopupTrackOrderClass();
});