
var workshopsClass = Class.create();
workshopsClass.prototype = {
	params : {},
    initialize : function() {
    	
    	if($('workshopRegistrationForm')) {
			$('workshopRegistrationForm').onsubmit = this.onWorkshopRegistrationClick.bind(this);
			this.validation.validateNumberField($("reg_phnNum"));
    	} else if($("smallPopup")){
	    	var _this = this;
	    	
	    	//get the workshop details
	    	this.getWorkshopDetailsPopup(false);
	    	
	    	setTimeout(function() { 
	    		$("smallPopup").addClassName('animateSlideUpBig');
	    	}, 5000);
	    	
	    	$$('.ppsml-edfx')[0].observe('click', function(e) {
				e.stopPropagation();
				hidePopupsOnBodyClick();
				_this.openWorkshopPopup(e);
			});
    	} else if($("workshopRequestForm")) {
    		this.registerWorkshopRequestClicks();
    		this.validation.validateNumberField($("req_phnNum"));
    		this.createCalendar();
    	}
	},
	
	sb : new SandBox(),
	validation : new UserValidation(),
	popupCallStatus: false,
	count: 0,
	shownEllipsis: false,
	
	/**
	 *this function handles the callback for small popup click
	 * If the workshop details call is not yet done, then it make the ajax call and displays the popup
 	 * @param {Object} e
	 */
	openWorkshopPopup: function(e) {
		var curtagetElem = e.currentTarget;
		if(curtagetElem.readAttribute('done-ajax') != "1" && !this.popupCallStatus) {
			this.getWorkshopDetailsPopup(true);
			return;
		}
		if($("bigPopup")) {
			$("smallPopup").removeClassName('animateSlideUpBig');
			$("bigPopup").addClassName('animateSlideUpBig');
			
			//set auto ellipses
			if(! this.shownEllipsis) {
				this.showEllipsis(".workshopContent");
				this.showEllipsis(".benefitsContent");
			}
		}
	},
	
	/**
	 *this function show the ellipsis to content 
	 */
	showEllipsis: function(elem) {
		var elemDiv = $j(elem);
		var elemChildren = $j(elem)[0].children;
		var elemChildrenlength = elemChildren.length;
		var totalHeight = elemDiv.height();
		var totalWidth = elemDiv.width();
		var fontWidth = 14;
		var charsPerLine = Math.floor(totalWidth / 14) + 10; //assuming that all letters wont be caps
		var lineHeight = 20;
		var filledHeight = 0;
		
		for(var i = 0; i < elemChildren.length; i++) {
			var elem = elemChildren[i];
			var childHeight = elem.clientHeight;
			remHeight = totalHeight - filledHeight;
			
			
			if(remHeight < (childHeight - 8)) {
				var remLines = Math.floor(remHeight / lineHeight);
				if(remLines <= 0) {
					i = i - 1;
					elem = elemChildren[i];
					var textValue = elem.textContent;
					elem.textContent = textValue.slice(0, textValue.length - 2) + "...";
				} else {
					var newText = [];
					var textValue = elem.textContent;
					var splitLines = textValue.split("\n");
					var maxCharacters = charsPerLine * remLines;
					
					for(var j = 0; j < remLines; j++) {
						if(j == remLines - 1 || splitLines[j].length > maxCharacters) {
							newText[j] = splitLines[j].slice(0, maxCharacters) + "...";
							break;
						} else {
							newText[j] = splitLines[j];
						}
					}
					elem.textContent = newText.join("\n");
				}
					
				//remove hidden children from the div
				for(var j = i + 1; j < elemChildrenlength; j++) {
					elemChildren[i + 1].remove();
				}
				this.shownEllipsis = true;
				return;
			}
			filledHeight = filledHeight + childHeight;
		}
	},
	
	/**
	 * this function sends the ajax call to get the workshop details 
	 * if renderPopup is then it displays the popup other wise hide it by loading html
 	* @param {Object} renderPopup
	 */
	getWorkshopDetailsPopup: function(renderPopup) {
		var me = this;
		me.popupCallStatus = true;
		curtagetElem = $("smallPopup");
		var workshopOpenurl = $("smallPopup").readAttribute('url');
		workshopOpenurl = this.sb.removeHTTP(workshopOpenurl);
		
         var ajaxOpenWorkshopPopup = new Ajax.Request(workshopOpenurl, {
            method:'post',
            parameters: {
                'id': $("smallPopup").readAttribute('workshopid')
             },
            onSuccess: function(response) {
            	me.popupCallStatus = false;
                var response = JSON.parse(response.responseText);
                
                //handle the response only once and ignore if it is already handled
                if($("smallPopup").readAttribute('done-ajax') != "1") {
	                if (response.success) {
	                    var div = document.createElement("div");
	                    div.innerHTML = response.html;
	                    document.body.appendChild(div);
						$("smallPopup").setAttribute('done-ajax', '1');
						me.registerClicks();
						
						//display the workshop details popup
						$j(".edgfxwrkpmain p").css("text-align", "initial");
							
						if(renderPopup) {
							me.openWorkshopPopup();
						}
	                }
                }
            },
            onFailure : function(response) {
            	me.popupCallStatus = false;
                me.sb.screenBlocker.hide(curtagetElem);
            }
         });
	},
	
	/**
	 *this function handles the callback on clicking submit button for workshop registration 
	 * It send the ajax call for registering user to workshop
	 * @param {Object} event
	 */
	onWorkshopRegistrationClick: function(event) {
		event.stop();
		var me = this;
		var validation = me.validation;
		var form = event.currentTarget;
		var formId = form.id;
		var containerDiv = $$('.wrksp-panel1-R')[0];
		var msgHolder = $$('.edfx-thkssbmit')[0];
		msgHolder.style.display = 'none';
		
		if(validation.isValidated(form)) {
			this.sb.screenBlocker.show(containerDiv, true);
			var url = form.action;
			url = this.sb.removeHTTP(url);
			var ajaxEmailListing = new Ajax.Request(url, {
	            method: 'post',
	            parameters: me.getWorkshopRegisterParams(formId),
	            onSuccess: function(response) {
	            	var data = JSON.parse(response.responseText);
	            	if(! data.success) {
	            		msgHolder.addClassName("failureMsg");
	            	} else {
	            		msgHolder.removeClassName("failureMsg");
	            		Form.reset(formId);
	            	}
					msgHolder.textContent = data.message;
					msgHolder.style.display = 'block';
					me.sb.screenBlocker.hide(containerDiv);
	           },
	           onFailure: function(response) {
					me.sb.screenBlocker.hide(containerDiv);
			   }
	        });	
		} 
		
	},
	
	/**
	 *this function send the workshop register post params required for ajax call 
	 * @param {Object} formId
	 */
	getWorkshopRegisterParams: function(formId) {
		var params = Form.serializeElements($(formId).getElements().reject(function (formElement) { 
						if (formElement.name == 'Mobile') {
							return true;        
						} else { 
						   return false;  
						}      
					}));
		var mobile = ($("reg_phnNum").value != "") ? ($$(".wrk-wrappernumbctrycde")[0].textContent + $("reg_phnNum").value) : $("reg_phnNum").value;
		var paramsObj = {
			"mobile": mobile,
			"venue_id": $('workshop_venues').querySelector('.selectionBackground').getAttribute('listid') 
		};
		params = params + '&' + Object.toQueryString(paramsObj);
		return params;
	},
	
	/**
	 *this function handle the callback for submitting workshop request form 
	 * It send the ajax call for rewuseting to workshop and handle the response
	 * @param {Object} event
	 */
	onWorkshopRequestClick: function(event) {
		event.stop();
		var me = this;
		var form = event.currentTarget;
		var containerDiv = $(form).up('.request-edfxfrm');
		
		if(this.isValidatedForm(form)) {
			$("requested_venueBox").value = this.buildWorkshopRequestVenues();
			this.sb.screenBlocker.show(containerDiv, true);
			var url = form.action;
			url = this.sb.removeHTTP(url);
			var ajaxEmailListing = new Ajax.Request(url, {
	            method: 'post',
				parameters: me.getWorkshopRequestParams(form.id),
	           
	            onSuccess: function(response) {
	            	var data = JSON.parse(response.responseText);
					if(data.success) {
						me.onWorkshopRequestSuccess(data);
						Form.reset(form.id);
					} else {
						var msgHolder = $$('.reqStatusMessage')[0];
						msgHolder.textContent = data.message;
						msgHolder.style.display = 'block';
					}
					me.sb.screenBlocker.hide(containerDiv);
	           },
	           onFailure: function(response) {
					me.sb.screenBlocker.hide(containerDiv);
			   }
			 });	
		} 
	},
	
	buildWorkshopRequestVenues: function() {
		var venues = $$('.venueField');
		var text = "";
		venues.each(function(el) {
			if(el.value.trim() != "") {
				text += text ? "@@" + el.value :  el.value;
			}
		});
		return text;
	},
	
	/**
	 *this function handle the success call back on requesting for workshop 
	 * It update the success message and hide the form
 	 * @param {Object} data
	 */
	onWorkshopRequestSuccess: function(data) {
		var holderDiv = $$('.edgfx-wks-tlesub')[0];
		var msgDiv = $$('.edgefxrwrsp-subtxt')[0];
		holderDiv.textContent = 'Workshop Creation Request Successful!';
		msgDiv.textContent = data.message;
		$('request-edfxfrmContainer').hide();
		$$('.reqWorkshopBackBtn')[0].style.display = "inline-block";
		$$('.edgefxContainer')[0].scrollTop = 0;
	},
	
	/**
	 *this function open the workshop request form on clicking back to request button  
	 */
	openWorkshopRequestForm: function() {
		var holderDiv = $$('.edgfx-wks-tlesub')[0];
		var msgDiv = $$('.edgefxrwrsp-subtxt')[0];
		holderDiv.textContent = 'Request A Workshop';
		msgDiv.textContent = '"Interested in conducting an Edgefx workshop in your institution or college? Please provide your details and we would get back to you very shortly."';
		$('request-edfxfrmContainer').show();
		$$('.reqWorkshopBackBtn')[0].hide();
		$$('.edgefxContainer')[0].scrollTop = 0;
	},
	
	/**
	 *this function return the time period in 'YYYY/MM/DD' format for sending the post params
     * @param {Object} dateStr
	 */
	getTimePeriod: function(dateStr) {
		var dateStr = dateStr.split('/');
		return (dateStr[2] + '/' + dateStr[1] + '/' + dateStr[0]);
	},
	
	/**
	 *this function send the workshop request post params required for ajax call 
	 * @param {Object} formId
	 */
	getWorkshopRequestParams: function(formId) {
		var params = Form.serializeElements($(formId).getElements().reject(function (formElement) { 
						if (formElement.name == 'start_date' || formElement.name == 'end_date' || formElement.name == 'mobile') {
							return true;        
						} else { 
						   return false;  
						}      
					}));
					
		var paramsObj = {
			"subjects": SelectableSubjectsDrop.getSelectedElems().join(), 
			"subject_names": SelectableSubjectsDrop.getSelectedElems('label').join(), 
			"start_date": this.getTimePeriod($('workshop_start_date').value), 
			"end_date": this.getTimePeriod($('workshop_end_date').value), 
			"mobile": $$(".edfxinptbxrtctrycde")[0].textContent + $("req_phnNum").value 
		};
		params = params + '&' + Object.toQueryString(paramsObj);
		return params;
	},
	
	/**
	 * this function validate the workshop request form fields
	 * If All the fields are correct then return true otherwise return false
 	 * @param {Object} form
	 */
	isValidatedForm: function(form) {
		var validation = this.validation;
		validation.resetColor($$('.dtpkermain')[0]);
		validation.resetColor($("workshop_Subjects"));
		var subjects = SelectableSubjectsDrop.getSelectedElems();
		var startDate =  this.getTimePeriod($('workshop_start_date').value);
		var endDate =  this.getTimePeriod($('workshop_end_date').value);
		var bln = validation.isValidated(form);
		var bln2 = validation.validateMultiDropdown(subjects, $("workshop_Subjects"));
		bln = bln && bln2;
		
		if(startDate != "" && endDate != "") {
			bln2 = validation.validateTimePeriod(startDate, endDate, '/', $$('.dtpkermain')[0]);
			bln = bln && bln2;
		}
		
		return bln;
	},
	
	/**
	 *this function register the clicks for popup icons and body
	 */
	registerClicks: function() {
    	var _this = this;
    	
		//register click for minize icon in workshop details popup
		$$('.edgfxcls-icon')[0].observe('click', function(e) {
			e.stopPropagation();
			_this.minimizeonPopup();
		});
		
		//register the click on details popup for stop propagating click to body
		$$('.wrkspmaintp')[0].observe('click', function(e) {
			e.stopPropagation();
		});
		
    	//register the click to body to minimize the popup
    	$$('body')[0].observe('click', function(e) {
			_this.minimizeonPopup();
		});
	},
	
	registerWorkshopRequestClicks: function() {
		var _this = this;
    		
		//register request form submission event
		$("workshopRequestForm").onsubmit = this.onWorkshopRequestClick.bind(this);
		
		//register workshop request back button click 
		$$(".reqWorkshopBackBtn")[0].observe('click', function(e) {
			e.stopPropagation();
			_this.openWorkshopRequestForm(e);
		});
		
		//register blur event to college box to fill in venue value
		Event.observe($("requested_college"), 'blur', function() {
	       _this.fillVenuesValue();
		});
		
		this.registerButtonClicks($("workshopRequestForm"));
		
	},
	
	registerButtonClicks: function(elem) {
		var buttons = elem.select('.edfxinptbxrt-adlsbx');
		var me = this;
		buttons.each(function(el) {
            el.stopObserving('click', me.handleVenueClick.bind(me));
            Event.observe(el, 'click', me.handleVenueClick.bind(me));
        });
        
        //register blur event to venue box to chech whether the venue is changed or not
        elem.select('.venueField').each(function(el) {
        	el.stopObserving('blur', me.fillVenuesValue.bind(me));
        	Event.observe(el, 'blur', me.fillVenuesValue.bind(me));
        });
	},
	
	fillVenuesValue: function() {
		var collegeValue = $("requested_college").value.trim();
        var venue = $("requested_venue");
        var venuesHodlerVal = this.buildWorkshopRequestVenues();
        
        if((venuesHodlerVal == "") && collegeValue != "") {
        	venue.value = collegeValue;
        }
	},
	
	handleVenueClick: function(el) {
		var cur = el.currentTarget;
        if(cur.hasClassName("addVenue")) {
			this.count++;
			var content = requestForWorkshop.addVenue({id: this.count});
			$$(".venuesList:last-child")[0].insert({after: content});
			this.registerButtonClicks($("venue_" + this.count));
        } else {
        	element = $(cur.up('.morevenues'));
        	element.parentNode.removeChild(element);
        	this.fillVenuesValue();
        }
	},
	
	/**
	 *this function minimize the workshop details popup 
	 */
	minimizeonPopup: function() {
		if($("bigPopup") && $("bigPopup").hasClassName('animateSlideUpBig')) {
			$("smallPopup").addClassName('animateSlideUpBig');
			$("bigPopup").removeClassName('animateSlideUpBig');
		}
	},
	
	createCalendar: function() {
		
		//create calendar for start date
		var SDCalendar = new customCalendarClass({
            inputField : 'workshop_start_date',
            button : 'workshop_start_date',
            singleClick : true,
            align : 'Br',
            ifFormat: "%d/%m/%Y",
            adjToScroll: false,
            renderDiv: document.getElementById('request-edfxfrmContainer'),
            showOthers: true
       });
		
		var EDCalendar = new customCalendarClass({
            inputField : 'workshop_end_date',
            button : 'workshop_end_date',
            singleClick : true,
            align : 'Br',
            ifFormat: "%d/%m/%Y",
            adjToScroll: false,
            renderDiv: document.getElementById('request-edfxfrmContainer'),
            showOthers: true
        });
        
	}
	
};
document.observe("dom:loaded", function() {
    workshops = new workshopsClass();
});