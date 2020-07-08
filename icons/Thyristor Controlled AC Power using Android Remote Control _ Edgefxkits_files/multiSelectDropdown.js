/**
 * rDIv  specifies the rendering div
 * comboData refers the data in mutliselect dropdown
 * 
 */
function multiSelectDropdown(rDiv, comboData, options) {
	this.listElems = comboData;
	this.defaultSelectedElems = options.defaultElems;
	var renderDiv;
	var dropdownElement;
	var me = this;
	
	/**
	 *this function initiate the component 
	 */
	this.init = function() {
		try {
			renderDiv = document.getElementById(rDiv);
			renderDiv.innerHTML = components.multiCombo.renderDropdown({listHolderId:rDiv, elems: this.listElems});
			dropdownElement = document.getElementById(rDiv + 'MultiListBox');
			me.destroy();
			this.registerClicks();
			this.selectDefaultValues();
		} catch(e) {
			(me.consolelog) ? console.log("Error:" + e.message) : false;
		}
	};
	
	/**
	 * This function delete all object, events created by previous render
	 */
	this.destroy = function() {
		try {
			var checkboxElems = dropdownElement.getElementsByClassName('multiListElems');
			for (i = 0; i < checkboxElems.length; i++) { 
				 var checkboxElem  =  checkboxElems[i];
				 me.eventUtility.removeEvent(checkboxElem, 'click');
			}
		
			if(dropdownElement != null) {
				delete dropdownElement;
			}
		} catch (e) {
			(me.consolelog) ? console.log("Error:" + e.message) : false;
		}
	};
	
	/**
	 *this function selects the default selectable values 
	 */
	this.selectDefaultValues = function() {
		for (i = 0; i < this.defaultSelectedElems.length; i++) { 
			var parentElem = document.getElementById('multiListElem_' + this.defaultSelectedElems[i]);
			var elem = parentElem.getElementsByClassName('checkboxElem')[0];
			elem.checked = true;
		}
	};
	
	/**
	 *this function register the clicks for elems in the dropdown to change the checkbox status 
	 */
	this.registerClicks = function() {
		var checkboxElems = dropdownElement.getElementsByClassName('multiListElems');
		for (i = 0; i < checkboxElems.length; i++) { 
			 me.eventUtility.addEvent(checkboxElems[i], 'click', this.handleItemClick);
		}
	};
	
	/**
	 * this function handle the callback function after clicking on the item in the dropdown 
	 */
	this.handleItemClick = function(event) {
		event.stopPropagation();
		var elem = event.currentTarget.getElementsByClassName('checkboxElem')[0];
		if(elem.checked) {
			elem.checked = false;
		} else {
			elem.checked = true;
		}
		var asd = me.getSelectedElems();
	};
	
	/**
	 *this function return the selected elems in the dopdown 
	 * returnType can be id/label/both. by default returns only id array
	 */
	this.getSelectedElems = function(returnType) {
		var checkboxElems = dropdownElement.getElementsByClassName('multiListElems');
		var selectedList = [];
		for (i = 0; i < checkboxElems.length; i++) { 
			var elem = checkboxElems[i].getElementsByClassName('checkboxElem')[0];
			if(elem.checked) {
				switch(returnType) {
					case 'both':
						selectedList.push({
							'id': checkboxElems[i].getAttribute('relId'),
							'name': selectedList.push(checkboxElems[i].getAttribute('relValue'))
						});
					break;
					case 'label':
						selectedList.push(checkboxElems[i].getAttribute('relValue'));
					break;
					default:
					selectedList.push(checkboxElems[i].getAttribute('relId'));
				}
			}
		}
		return selectedList;
	};
	
	/**
	 * This function manage the events of dropdown
	 */
	this.eventUtility = (function () {
		return {
			
			// This function return addEventListener into DOM Element
			addEvent: (function () {
				if (typeof addEventListener !== "undefined") {
					return function (obj, etype, fn, useCapture) {
						var useCapture = useCapture || false;
						obj.addEventListener(etype, fn, useCapture);
					};
				} else {
					return function (obj, etype, fn, useCapture) {
						obj.attachEvent("on" + etype, fn);
					};
				}
			}()),
			
			// This function remove EventListener from DOM Element
			removeEvent: (function () {
				if (typeof removeEventListener !== "undefined") {
					return function (obj, etype, fn, useCapture) {
						var useCapture = useCapture || false;
						obj.removeEventListener(etype, fn, useCapture);
					};
				} else {
					return function (obj, etype, fn, useCapture) {
						obj.detachEvent("on" + etype, fn);
					};
				}
			}()),
			
			// This function prevent the repeated DOM events 
			preventDefault: (function () {
				if (typeof addEventListener !== "undefined") {
					return function (event) {
						return event.preventDefault();
					};
				} else {
					return function (event) {
						return event.returnValue = false;
					};
				}
			}())
		};
	}());
}
