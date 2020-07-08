/**
 * Widget name:SimpleDropdown
 * @Author:Jinu V S - 20/12/2013
 * 
 * @param variable rDiv
 * @param [Array] comboData
 * @param {Object} option
 */
function SimpleDropdown(rDiv, comboData, option) {

	this.listElements = comboData,
	this.callbackFunc = (option.callbackFunction) ? option.callbackFunction : false;
	
	this.eventTarget = null,
	this.listElementsLen = 0,
	this.scrollHeight = 0;
	this.isItemClicked = false;
	this.options = option;
	this.consolelog = (option.consolelog == true) ? true : false; 
	
	var me = this;
	var dropdownElement;
	var renderDiv;
	var customeBlockStyleClass = (this.options.dropDownListClass) ? this.options.customClass : "";
	var prevIndex = 0;
	var prevKey;
	
	/**
	 * Initialize the Dropdown and render the basic HTML elements
	 */
	this.init = function() {
		try {
			renderDiv = document.getElementById(rDiv);
			renderDiv.innerHTML = components.simpleCombo.selectCombo({listHolderId:rDiv, css:this.options.css});
			dropdownElement = document.getElementById(rDiv + 'ListBox');
			me.destroy();
			
			me.configureDropDown();
			me.createDropdown();
		} catch(e) {
			(me.consolelog) ? console.log("Error:" + e.message) : false;
		}
	};
	
	/**
	 * This function delete all object, events created by previous render
	 */
	this.destroy = function() {
		try {
			me.eventUtility.removeEvent(renderDiv, 'click');
			me.eventUtility.removeEvent(document, 'keydown');
			me.eventUtility.removeEvent(document, 'click');
		
			dropdownElement = document.getElementById(rDiv + 'ListBox');
			
			if(dropdownElement != null) {
				delete dropdownElement;
			}
		} catch (e) {
			(me.consolelog) ? console.log("Error:" + e.message) : false;
		}
	};
	

	/**
	 * Below function is used to render the dropDown
	 */
	this.createDropdown = function() {
		me.renderDropDownData();
		me.registerDropDownEvents();
		me.hideDropDown();
	};

	/**
	 * render the dropdown the elements in to dropdown body
	 */
	this.renderDropDownData = function() {
		try {
			var eventsDisplayData = this.listElements;
	
			for (var i=0, iLen=eventsDisplayData.length; i<iLen; i++) {
				this.createDropDownLists(eventsDisplayData[i], i);	//adding each drop down element
			}
			
			((this.options.defaultSelectedElement)
				? me.setDropDownValue(this.options.defaultSelectedElement)
				: me.domUtility.addClass(dropdownElement.firstChild, "selectionBackground"));
			
		} catch(e) {
			(me.consolelog) ? console.log("Error:" + e.message) : false;
		}
	};
	
	/**
	 * This fumction handles when user click/select on dropdown item
	 * @param {Object} event
	 */
	this.handleItemClick = function(event) {
		try {
			document.querySelector('.dropdownItemsHolder').style.display = "none";
			me.isItemClicked = true;
			var elementID = this.id;
			me.listElementsLen = this.getAttribute('rel');
			me.updateCurrentSelected(this);
			me.hideDropDown();
			(me.callbackFunc != false) ? me.callbackFunc(me.getDropDownValue()) : false;
		} catch(e) {
			(me.consolelog) ? console.log("Error:" + e.message) : false;
		}
	};

	/**
	 * This function create eachh drop down options and assign eventlister on it
	 * @param {Object} data
	 * @param variable iValue
	 */
	this.createDropDownLists = function(data, iValue) {
		try {
			if (!data) {
				return;
			}
	
			if (data.hasOwnProperty('name')) {
				var tiptext = (data.name.length > 24) ? data.name : "";
			}
			
			var uniqueId = rDiv + '_option_' + data.id;
			var htmlStr = '<div rel="' + data.id + '" value="' + data.value + '">' + data.name + '</div>';
			
			var newdiv = document.createElement('div');
	
			newdiv.setAttribute('id', uniqueId);
			newdiv.setAttribute('class', 'columListItem ' + customeBlockStyleClass);
			newdiv.setAttribute('rel', iValue);
			newdiv.setAttribute('listid', data.id);
			newdiv.setAttribute('value',data.value);
			newdiv.innerHTML = htmlStr;
			
			me.eventUtility.removeEvent(newdiv, 'click', this.handleItemClick);
			me.eventUtility.addEvent(newdiv, 'click', this.handleItemClick);
			dropdownElement.appendChild(newdiv);		//adding dropdown node at end.
		} catch(e) {
			(me.consolelog) ? console.log("Error:" + e.message) : false;
		}
	};
	
	/**
	 * Register the events for the dropdown
	 */
	this.registerDropDownEvents = function() {
		try {
			var _this = this;
			var comboContainer = renderDiv;
	
			function handleComboClick(event) {		//handle the combo body click	
				event.stop();
				hidePopupsOnBodyClick();
				if (dropdownElement.style.display === "block") {
					me.hideDropDown();
					me.isItemClicked = true;
				}
				
				var dropdowns = document.getElementsByClassName('dropdownItemsHolder');	//@TODO: Expensive; need to re-visit the logc!!!
				for(var i=0, iLen=dropdowns.length; i<iLen; i++) {
					dropdowns[i].style.display = 'none';
				}
							
				if (dropdownElement.style.display === "block") {
					me.hideDropDown();
				} else {
					if(!(me.isItemClicked)) {
						var selectedItem = dropdownElement.querySelector('.selectionBackground');
						if (selectedItem) {
							me.domUtility.addClass(selectedItem, "selectionBackground");
						} else {
							me.domUtility.addClass(dropdownElement.firstChild, "selectionBackground");
						}
						
						if(event.currentTarget.hasClassName('cart-kit-type-select')) {
							me.showDropDownForCart(event);
						} else {
							me.showDropDown();
						}
					}
					me.isItemClicked = false;
				}
			};
	
			function handleDocumentClick(event) {		//Handle container Click
				try {
					var _target = me.eventUtility.getTarget(event);
					var str = null;
					if (_target.id) {
						str = "#" + _target.id;
						str = str.replace(':', '');
					} else if (_target.className) {
						str = "." + _target.className;
					};
					
					var isExist = renderDiv.querySelectorAll(str).length;
					
					if (!isExist) {
						me.hideDropDown();
					}
				} catch(e) {
					(me.consolelog) ? console.log("Error:" + e.message) : false;
				}
			};
			
			function handleCartScrollClick(event) {
				try {
					var _target = me.eventUtility.getTarget(event);
					var str = null;
					if (_target.id) {
						str = "#" + _target.id;
						str = str.replace(':', '');
					} else if (_target.className) {
						str = "." + _target.className;
					};
					
					var isExist = renderDiv.querySelectorAll(str).length;
					
					if (!isExist) {
						me.hideDropDown();
					}
				} catch(e) {
					(me.consolelog) ? console.log("Error:" + e.message) : false;
				}
				
			};
			
			function handleItemKeypress(e) {	
				if(dropdownElement.style.display == 'block') {		//handle the combo - keypress
					var listAllItems = dropdownElement.childNodes;
					var len = listAllItems.length;
					var eventVal = e.keyCode || e.charCode || e.which;
					me.eventUtility.preventDefault(e);
		
					switch (eventVal) {
						case 40:			// Down key is pressed
							if (len > 0) {
								me.listElementsLen++;
								var selectedRel = parseInt(dropdownElement.querySelector('.selectionBackground').getAttribute("rel")) + 1;
								me.updateCurrentSelected(listAllItems[selectedRel]);
								me.handleScroll('down');
							}
						break;
						case 38:			// Up key is pressed
							if (len > 0) {
								me.listElementsLen--;
								var selectedRel = parseInt(dropdownElement.querySelector('.selectionBackground').getAttribute("rel")) - 1;
								me.updateCurrentSelected(listAllItems[selectedRel]);
								me.handleScroll('up');
							}
						break;
						case 13:			// 'Enter' key is pressed
							var currentSelected = dropdownElement.querySelector('.selectionBackground').id;
							if (me.callbackFunc != false) {
								me.callbackFunc(me.getDropDownValue());
							} 
							me.hideDropDown();
						break;
						case 27:			// 'Esc' key is pressed
							me.hideDropDown();
						break;
						default: 
							if(dropdownElement.style.display == 'block' && !(comboContainer.hasClassName('cmbPriceHolder'))) {
								var keyValue = String.fromCharCode(eventVal).toLowerCase();
								if(prevKey == keyValue) {
									i = prevIndex + 1;
									if(!(searchKeyPressVal(i,listAllItems,keyValue))){
										searchKeyPressVal(0,listAllItems,keyValue);
									}
								} else {
									i = 0;
									searchKeyPressVal(i,listAllItems,keyValue);
								}
								prevKey = keyValue;
							}
						
						break;
					}
				}
			}
		
			me.eventUtility.addEvent(comboContainer, 'click', handleComboClick);		//click on drop down body
			me.eventUtility.addEvent(document, 'keydown', handleItemKeypress);
			me.eventUtility.removeEvent(document, 'click');
			me.eventUtility.addEvent(document, 'click', handleDocumentClick);
			if($(comboContainer).hasClassName('cart-kit-type-select')) {
				var scrollParent = $(comboContainer).up('.scrollableContent');
				me.eventUtility.addEvent(scrollParent, 'scroll', handleCartScrollClick);
			}
		} catch(e) {
			(me.consolelog) ? console.log("Error:" + e.message) : false;
		}
	};
	
	function searchKeyPressVal(i,listAllItems,keyValue) {
		var len = listAllItems.length;
		for(;i<len; i++) {
			var searchval = listAllItems[i].textContent.toLowerCase();
			var element = listAllItems[i];
			if(searchval.indexOf(keyValue) == 0) {
				me.updateCurrentSelected(element);
				prevIndex = i;
				me.handleScrollForSearch();
				return true;
			} 
		}
	};
	
	this.handleScrollForSearch = function() {
		try {
			var cHolder, currentSelectedOrder;
			cHolder = dropdownElement;
			currentSelectedOrder = dropdownElement.querySelector('.selectionBackground');
			cHolder.scrollTop = currentSelectedOrder.offsetTop;
			this.scrollHeight = cHolder.scrollTop;
		} catch(e) {
			(me.consolelog) ? console.log("Error:" + e.message) : false;
		}
	};

	/**
	 * This function handles the scroll in dropdown
	 * @param {Object} currentDirection
	 */
	this.handleScroll = function(currentDirection) {
		try {
			var cHolder, currentSelectedOrder, selectedItemPosition, totalListLength, listHolderHeight;
			
			cHolder = dropdownElement;
			currentElem = dropdownElement.querySelector('.selectionBackground').clientHeight;
			currentSelectedOrder = parseInt(dropdownElement.querySelector('.selectionBackground').getAttribute("rel"))+1;
	
			selectedItemPosition = (currentSelectedOrder * currentElem);
			totalListLength = dropdownElement.childNodes.length * currentElem;
			
			listHolderHeight = dropdownElement.offsetHeight;
			
			if (currentDirection == 'down') {
				if ((selectedItemPosition > listHolderHeight) && (selectedItemPosition <= totalListLength)) {
					if(this.scrollHeight < (totalListLength - listHolderHeight)) {
						this.scrollHeight += currentElem;
					}
					cHolder.scrollTop = this.scrollHeight;
				}
			} else {
				if (selectedItemPosition <= this.scrollHeight  && (cHolder.scrollTop > 0)) {
					this.scrollHeight -= currentElem;
					cHolder.scrollTop = this.scrollHeight;
				}
			}
		} catch(e) {
			(me.consolelog) ? console.log("Error:" + e.message) : false;
		}
	};
	
	/**
	 * This function configure the drop down settings
	 */
	this.configureDropDown = function() {
		try {
			showMenu = (this.options.css.showMenuIcon) ? this.options.css.showMenuIcon : false;
			
			if (showMenu) {
				var menu = renderDiv.querySelector('#' + rDiv + '_MenuContainer');
				menu.style.display = 'block';
				//var displayTextWidth = menu.clientWidth + 5;
				//renderDiv.querySelector('.comboTextHolder').style.margin = '0px 0px 0px ' + displayTextWidth + 'px';
			}
		} catch(e) {
			(me.consolelog) ? console.log("Error:" + e.message) : false;
		}
	};

	/**
	 * Update the dropdown text dynamically based on user selection
	 */
	this.updateDropdownText = function(textVal) {
		try {
			renderDiv.querySelector('.comboTextHolder').innerHTML = textVal;
			if(this.options.showTooltip) {
				renderDiv.querySelector('.comboTextHolder').setAttribute('title', textVal);
			}
		} catch(e) {
			(me.consolelog) ? console.log("Error:" + e.message) : false;
		}
	};

	/**
	 * This function update the value in main container and 
	 * set background color for selected element
	 * @param {DOM Element} currentListItem
	 */
	this.updateCurrentSelected = function(currentListItem) {
		try {
			var selectedText = currentListItem.innerText || currentListItem.textContent;
	
			me.removeSelection();
			me.domUtility.addClass(currentListItem, "selectionBackground");
			me.updateDropdownText(selectedText);
	
		} catch(e) {
			(me.consolelog) ? console.log("Error:" + e.message) : false;
		}
	};

	/**
	 * Removes the selection background color of all the elements.
	 */
	this.removeSelection = function() {
		try {
			var currentSelected = dropdownElement.querySelector('.selectionBackground');
	
			if (currentSelected) {
				me.domUtility.removeClass(currentSelected, "selectionBackground");
			} else {
			}
		} catch(e) {
			(me.consolelog) ? console.log("Error:" + e.message) : false;
		}
	};

	/**
	 * This function hide the dropdown part
	 */
	this.hideDropDown = function() {
		dropdownElement.style.display = "none";
	};

	/**
	 * This function show the dropdown.
	 */
	this.showDropDown = function() {
		dropdownElement.style.display = "block";
		dropdownElement.scrollTop = this.scrollHeight;
	};
	
	this.showDropDownForCart = function(event) {
		var container = $(dropdownElement).parentElement;
		$(container).setStyle({
		        position: "inherit",
		    });
		    $(dropdownElement).setStyle({
		        position:"absolute",
		        display: "block",
		        left:event.currentTarget.parentElement.offsetLeft + 11 + 'px',
		        top: event.currentTarget.parentElement.offsetTop - $$('.scrollableContent')[0].scrollTop + 77 + 'px'
		    }); 
		dropdownElement.scrollTop = this.scrollHeight;
	};
	/**
	 * This function SET the value in dropdown
	 * @param Variable id
	 */
	this.setDropDownValue = function(id) {
		try {
			if(!id) {
				return false;
			}
			
			var elemToBeSelected = dropdownElement.querySelector('[listid="'+  id +'"]');
			
			if (elemToBeSelected) {
				me.removeSelection();
				me.domUtility.addClass(elemToBeSelected, "selectionBackground");
				me.listElementsLen = elemToBeSelected.getAttribute('rel');
				me.updateDropdownText(elemToBeSelected.innerText || elemToBeSelected.textContent);
			}
			return false;
		} catch(e) {
			(me.consolelog) ? console.log("Error:" + e.message) : false;
		}
	};
	
	/**
	 * This function GET the value from dropdown
	 * return {Object} contains id, value and elementid
	 */
	this.getDropDownValue = function() {
		try {
			var currentSelected = dropdownElement.querySelector('.selectionBackground');
			if(currentSelected) {
				return {
					id: currentSelected.getAttribute('listid'),
					value: currentSelected.innerText || currentSelected.textContent,
					elementId: currentSelected.id
				};
			}
		} catch(e) {
			(me.consolelog) ? console.log("Error:" + e.message) : false;
		}
	};
	
	/**
	 * This function use to handle the class of dropdown
	 */
	this.domUtility = (function () {
		return {
			hasClass: function (ele, cls) {		// Code check whether class is available or not ?
				if (!ele) {
					return;
				}
				return ele.className.match(new RegExp('(\\s|^)' + cls + '(\\s|$)'));
			},

			addClass: function (ele, cls) {			// Code check whether class is available ? if NO! then addd the classname from the DOM elements
				if (!ele) {
					return;
				}
				if (!this.hasClass(ele, cls)) ele.className += " " + cls;
			},

			removeClass: function (ele, cls) {// Code check whether class is available ? if YES!, remove classname from the DOM elements
				if (!ele) {
					return;
				}
				if (this.hasClass(ele, cls)) {
					var reg = new RegExp('(\\s|^)' + cls + '(\\s|$)');
					ele.className = ele.className.replace(reg, ' ');
				}
			}
		};
	}());
	
	
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
			
			// This function return target event in DOM Element
			getTarget: (function () {
				if (typeof addEventListener !== "undefined") {
					return function (event) {
						return event.target;
					};
				} else {
					return function (event) {
						return event.srcElement;
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