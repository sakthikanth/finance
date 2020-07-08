var customCalendarClass = Class.create();
customCalendarClass.prototype = {
	sb : new SandBox(),
	initialize : function(calendarObj) {
		this.createCalendar(calendarObj);
	},
	/**
	 *this function create the default magento calendar with the given params
 	* @param {Object} calendarObj
	 */
	createCalendar: function(calendarObj) {
		 calendarObj.options = {
            className: 'customCalendar',
            createComplete: this.createComplete.bind(this)
       	};
       	calendarObj.disableFunc = function(date) {
       		var now = new Date();
			if(date.getFullYear() < now.getFullYear()) {
	            return true;
	        }
	        if(date.getFullYear() == now.getFullYear()) {
	            if(date.getMonth() < now.getMonth()) {
	                return true;
	            } else if(date.getMonth() == now.getMonth()) {
		            if(date.getDate() < now.getDate()) {
		                return true;
		            }
		        }
	        }
        };
		 //create calendar for end date
        Calendar.setup(calendarObj);
	},
	
	/**
	 *this function handles the callback after default calendar is created
	 * It changes the default calendar into UI customizable calendar
	 */
	createComplete: function() {
		if($$('.customCalendar .headrow')[0]) {
			$$('.customCalendar .headrow')[0].style.display = "none";
			$$('.customCalendar .name.wn')[0].style.display = "none";
			this.sb.hideElements($$('.customCalendar .day.wn'));
			var titleDiv = $$('.customCalendar thead .title')[0];
			titleDiv.writeAttribute('colspan', '5');
			
			var elements = $$('.customCalendar .day.name');
			var length = elements.length;
			for(var index = 0; index < length;index++) {
				elements[index].textContent = elements[index].textContent[0];
			}
			
			var elements = $$('.customCalendar thead tr:nth-child(1) .button');
			var length = elements.length;
			for(var index = 0; index < length;index++) {
				elements[index].textContent = "";
			}
			var today = this.getFooterText();
			$$(".customCalendar .ttip")[0].textContent = today;
		}
	},
	
	getFooterText: function() {
		var today = new Date();
			var dd = today.getDate();
			var mm = today.getMonth()+1; //January is 0!
			var yyyy = today.getFullYear();
			
			if(dd < 10) {
			    dd = '0' + dd;
			} 
			
			if(mm < 10) {
			    mm = '0' + mm;
			} 

			today = "Today (" + dd + '/' + mm + '/' + yyyy + ")";
			return today;
	}
};