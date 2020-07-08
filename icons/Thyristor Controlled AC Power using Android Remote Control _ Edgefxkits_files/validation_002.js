var UserValidation = Class.create();
UserValidation.prototype = {
	initialize : function(){

	},
	emsg: {
		"empty_general": "This is a required field",
		"empty_name": "Please enter your name",
		"empty_location": "Please enter your location",
		"empty_city": "Please enter your city name",
		"empty_address": "Please enter your address",
		"empty_region": "Please enter your region",
		"empty_email": "Please enter the email address",
		"invalid_email": "Please enter a valid email address",
		"empty_phone": "Please enter a valid phone number",
		"empty_feedback": "Please enter your feedback",
		"empty_question": "Please enter your question/concern",
		"review_success": "Your review has been successfully submitted for verification. Once verified, the review will be uploaded on the site",
		"review_error": " A system error occurred while submitting the review",
		"shortpassword" : "Your password must contain atleast six characters",
		"nonumpassword" : "Your password must contain atleast one number",
		"nocharpassword" : "Your password must contain atleast one letter",
		"notsamepasswords" : "Confirm password does not match with the password given above",
		"successforgotpassword" : "A Link has been sent successfully to your email address. Kindly find it to reset your password",
		"wronglogin" : "The email/password is incorrect",
		"beyond_quantity" : "Quantity you have given is more than what is available with us",
		"ratings": "Please enter your ratings",
		"invalid_model_number": "Invalid model number",
		"nocurrpassword": "Please enter current password",
		"wrongemail" : "Please enter a valid email address",
		"noemail" : "Please enter the email address",
		"nofirstname" : "First name is required",
		"nolastname" : "Last name is required",
		"dirtyfirstname" : "First name is not valid",
		"dirtylastname" : "Last name is not valid",
		"emailisexist" : "This email is already registered",
		"emailnotexist" : "This email is not registered",
		"nopassword" : "Please enter the password",
		"dirtypassword" : "Please enter a valid password",
		"nospacepassword" : "Password should not contain spaces",
		"longpassword" : "Please enter 16 or less characters",
		"nolicence" : "Terms and Conditions are required",
		"pincode" : "Please enter a valid zip/pincode",
		"state-select" : "Please select a state or province",
		"country-select" : "Please select a country",
		"state" : "Please enter a valid state",
		"phone10" : "Please enter a valid 10 digit phone number",
		"invalid_captcha" : "Please enter valid Text",
		"comment": "Please enter your comment",
		"college": "Please enter your college name",
		"start_date": "Please select start date",
		"end_date": "Please select end date",
		"beyondEnddate": "Start date should be less than or equal to end date",
		"multiSelectDropdown": "Please select atleast one element"
	},
	isValidated: function(e){
		var fields = e.elements;
		var bln = true;
		for(var i=0;i<fields.length; i++){
			var field = fields[i];
			//Remove all hidden and button elements
			var blnCheck = ((field.hasClassName('required-entry') || field.hasClassName('validation-entry'))
							&& field.style.display != "none"
							&& field.offsetWidth > 0);
			field.value = field.value.trim();
			if(blnCheck){
				//text fields and text areas
				var blnField = this.setFieldMessagesAndReturn(field);
				this.paintColor(field, blnField);
				bln = bln && blnField;
			}
		}
		this.setFocus();
		//other elements like Rating holder
		var ratingWrapper = e.down('.review-wrapper');
		if(ratingWrapper){
			var ratings = e["ratings[1]"];
			var blnField = this.isRatingSet(ratings);
			if(!blnField){
				this.writeAttribute(ratingWrapper, "ratings");
			}
			this.paintColor(ratingWrapper, blnField);
			bln = bln && blnField;
		}
		return bln;
	},
	
	/**
	 * Removing error messages and error colors for form fields when click on cancel button
	 */
	resetFormErrorFields: function(e) {
		var fields = e.elements;
		var bln = true;
		for(var i=0;i<fields.length; i++){
			var field = fields[i];
			this.paintColor(field, bln);
		}
		
		//other elements like Rating holder
		var ratingWrapper = e.down('.review-wrapper');
		if(ratingWrapper){
			var ratings = e["ratings[1]"];
			this.paintColor(ratingWrapper, bln);
		}
		
	},
	
	paintColor: function(e, bln, blnDirection){
		if(bln){
			//color the field
			this.resetColor(e);
			//show message
		}
		else{
			this.setErrorColor(e, blnDirection);
			//hide message
		}
	},
	setErrorColor: function(e, bln){
		var pointElement = this.getPointElement(e);
		pointElement.addClassName('error-field');
		if(bln){
			pointElement.addClassName('error-field-left');
		}
		else{
			pointElement.addClassName('error-field-right');	
		}
	},
	resetColor: function(e){
		var pointElement = this.getPointElement(e);
		pointElement.removeClassName('error-field');
		pointElement.removeClassName('error-field-right');
		pointElement.removeClassName('error-field-left');
		this.removeErrorMessage(pointElement);
	},
	resetValidationErrors: function(){

	},
	isRatingSet: function(e){
		var len = e.length;
		for(var i=0; i<len; i++){
			var radio = e[i];
			if(radio.checked){
				//remove message
				return true;
			}
		}
		//show message
		return false;
	},
	setFieldMessagesAndReturn : function(field){
		var fieldType = field.readAttribute('data-name');
		var blnEmpty = field.value.length == 0;
		if(!fieldType){
			return true;
		}
		if(fieldType == "name"){
			if(blnEmpty){
				this.writeAttribute(field, "empty_name");
				return false;
			}
		}
		else if(fieldType == "email"){
			if(blnEmpty){
				this.writeAttribute(field, "empty_email");
				return false;
			}
			else if(!this.validateEmail(field.value)){
				this.writeAttribute(field, "invalid_email");
				return false;
			}
		}
		else if(fieldType == "location"){
			if(blnEmpty){
				this.writeAttribute(field, "empty_location");
				return false;
			}
		}
		else if(fieldType == "city"){
			if(blnEmpty){
				this.writeAttribute(field, "empty_city");
				return false;
			}	
		}
		else if(fieldType == "region"){
			if(blnEmpty){
				this.writeAttribute(field, "empty_region");
				return false;
			}	
		}
		else if(fieldType == "phone"){
			if(blnEmpty && !field.hasClassName('validation-entry')){
				this.writeAttribute(field, "empty_phone");
				return false;
			}else if(blnEmpty && field.hasClassName('validation-entry')) {
				return true;
			}else if(!this.validatePhone(field.value)){
				this.writeAttribute(field, "empty_phone");
				return false;
			}
		}
		else if(fieldType == "feedback"){
			if(blnEmpty){
				this.writeAttribute(field, "empty_feedback");
				return false;
			}
		}
		else if(fieldType == "address"){
			if(blnEmpty){
				this.writeAttribute(field, "empty_address");
				return false;
			}
		}
		else if(fieldType == "pincode"){
			if(blnEmpty){
				this.writeAttribute(field, "pincode");
				return false;
			}else if(!this.validatePincode(field.value)){
				this.writeAttribute(field, "pincode");
				return false;
			}
		}
		else if(fieldType == "state-select"){
			blnEmpty = this.customizeComboValuesCheck(field);
			if(blnEmpty){
				this.writeAttribute(field, "state-select");
				return false;
			}
		}
		else if(fieldType == "state"){
			if(blnEmpty){
				this.writeAttribute(field, "state");
				return false;
			}
		}
		else if(fieldType == "captcha"){
			var isValid = true;
			if(blnEmpty){
				isValid = false;
				//this.writeAttribute(field, "invalid_captcha");
				//return false;
			}/*else{
				isValid = this.validateCaptcha(field);
			}*/
			if(!isValid){
				this.writeAttribute(field, "invalid_captcha");
				return false;
			}
		}
		else if(fieldType == "question"){
			if(blnEmpty){
				this.writeAttribute(field, "empty_question");
				return false;
			}
		}else if(fieldType == "comment"){
			if(blnEmpty){
				this.writeAttribute(field, "comment");
				return false;
			}
		} else if (fieldType == "country-select") {
			blnEmpty = this.customizeComboValuesCheck(field);
			if(blnEmpty){
				this.writeAttribute(field, "country-select");
				return false;
			}
		} else if (fieldType == "start_date") {
			if(blnEmpty){
				this.writeAttribute(field, "start_date");
				return false;
			}
		} else if (fieldType == "end_date") {
			if(blnEmpty){
				this.writeAttribute(field, "end_date");
				return false;
			}
		} else if(fieldType == "college") {
			if(blnEmpty){
				this.writeAttribute(field, "college");
				return false;
			}
		} 
		return true;
	},
	
	customizeComboValuesCheck: function(field) {
		var textField = field.value;
		if(textField == -100) {
			return true;
		} else {
			return false;
		}
	},
	
    validateEmail:function(emailAddress){
        var filter = /^([\w-\.]+)@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.)|(([\w-]+\.)+))([a-zA-Z]{2,4}|[0-9]{1,3})(\]?)$/;
        return filter.test(emailAddress);
    },
    
    validateTimePeriod: function(startDate, endDate, separator, rdiv) {
		var firstDate = new Date(startDate);
		var secondDate = new Date(endDate);
		
		if (firstDate > secondDate)
		{
		   this.writeAttribute(rdiv, 'beyondEnddate');
			return false;
    	}
    	return true;
    },
    
    validateMultiDropdown: function(elems, rDiv) {
    	if(! elems.length) {
	    	this.writeAttribute(rDiv, 'multiSelectDropdown');
	    	return false;
    	}
    	return true;
    	
    },
    
    validateCaptcha : function(field){
    	return true;
    },
    validatePincode : function(pincode){
    	var filter = /^\d+$/;
        return filter.test(pincode);
    },
    validatePhone : function(phone){
    	var filter = /^\d{10}$/;
        return filter.test(phone);
    },
	setOtherMessagesAndReturn : function(field){

	},
	writeAttribute : function(field, msg){
		var pointElement = this.getPointElement(field);
		var errorMsgElement = pointElement.down('.validation-error-message');
		var message = this.emsg[msg];
		if(!message){message = msg;}
		if(!errorMsgElement){
			var div = new Element('div');
			div.addClassName('validation-error-message');
			div.update(message);
			pointElement.appendChild(div);

			div.setStyle({
				'width': div.previous().getWidth() + "px"
			});
		}
		else{
			errorMsgElement.update(message);
		}
	},
	removeErrorMessage: function(e){
		var msgElement = e.down('.validation-error-message');
		if(msgElement){
			Element.remove(msgElement);
		}
	},
	
	getPointElement: function(e){
		if(e.hasAttribute('level')) {
			var val = e.readAttribute('level');
			var elem = e;
			for(i = 0;i < val;i++) {
				elem = elem.up('div');
			}
			return elem;
		}
		return e.up('div');
	},
	applyErrorField : function(msg, windowName, bln){
        var errorField = $$('#' + windowName + '-container .input-wrapper + .err-' + msg)[0];
        var field = errorField.previous('input');
        if(!field){
        	field = errorField.previous('.input-wrapper').down('input');
        }
        if(bln){
        	this.resetErrorAttribute(field);
        }
        else{
        	this.setErrorAttribute(field, msg);
        }
    },
    setErrorAttribute : function(field, msg, bln){
		this.setErrorColor(field, bln);
		this.writeAttribute(field, msg);
	},
	resetErrorAttribute: function(field){
		this.resetColor(field);
	},
	setFocus: function(){
		var errorFields = $$('.error-field');
		if(errorFields.length){
			var input = errorFields[0].down('input');
			if(!input){
				input = errorFields[0].down('textarea');
			}
			if(input){
				input.focus();
			}
		}
	},
	
	validateNumberField: function(elem) {
		elem.onkeydown = function (e) {
			var keysList = [46, 8, 9, 27, 13, 110];
	        // Allow: backspace, delete, tab, escape, enter
	        if (keysList.indexOf(e.keyCode) !== -1 ||
	             // Allow: Ctrl+A
	            (e.keyCode == 65 && e.ctrlKey === true) || 
	             // Allow: home, end, left, right, down, up
	            (e.keyCode >= 35 && e.keyCode <= 40)) {
	                 // let it happen, don't do anything
	                 return;
	        }
	        // Ensure that it is a number and stop the keypress
	        if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
	            e.preventDefault();
	        }
	   };
   }
};

function unlock() {
	var validatorValue = true;
	var name  = document.getElementById("name").value;
	var email = document.getElementById("email").value;
	var phone  = document.getElementById("contactno").value;
	if(name == ''){	
		document.getElementById("errorName").innerHTML = "Please enter the name";		
		validatorValue = false;
	}else if(name!=""){
		var regex = /^[a-zA-Z ]{2,30}$/;			
		if (!regex.test(name)) {
			document.getElementById("errorName").innerHTML = "Please enter only alphabets";				
			validatorValue = false;
		}else{
			document.getElementById("errorName").innerHTML = "";	
		}
	}else{
		document.getElementById("errorName").innerHTML = "";	
	}
	if(email == ''){
		document.getElementById("errorEmail").innerHTML = "Please enter the email address";	
		validatorValue = false;
	}else if(checkEmail(email)==false){
		document.getElementById("errorEmail").innerHTML = "Please enter valid email formate";		
		validatorValue = false;		
	}else{
		document.getElementById("errorEmail").innerHTML = "";	
	}
	if(phone == ''){
		document.getElementById("errorPhone").innerHTML = "Please enter the phone";	
		validatorValue = false;
	}else if(phone!=""){
		var phoneno = /^\d{10}$/;
		if((!phone.match(phoneno))){
			document.getElementById("errorPhone").innerHTML = "Please enter valid phone number";		
			validatorValue = false;
		}else{
			document.getElementById("errorPhone").innerHTML = "";
		}
	}else{			
		document.getElementById("errorPhone").innerHTML = "";
	}
	if(validatorValue == false){
		 return false;
	}
	else
	{		
		var $j = jQuery.noConflict();
		var url = "apitest.php";
		var postData = jQuery("#unLockForm").serialize();	
		$j.ajax({
			url: url,
			type: "POST",
			data: {name:name,email:email,phone:phone},
			success: function(data) {
				document.getElementById("formpopup1").style.display = 'none';
			}
		});
	}
}
function checkEmail(emailStr) {
	if (emailStr.length == 0) {
		return true;
	}
	var emailPat=/^(.+)@(.+)$/;
	var specialChars="\\(\\)<>@,;:\\\\\\\"\\.\\[\\]";
	var validChars="\[^\\s" + specialChars + "\]";
	var quotedUser="(\"[^\"]*\")";
	var ipDomainPat=/^(\d{1,3})[.](\d{1,3})[.](\d{1,3})[.](\d{1,3})$/;
	var atom=validChars + "+";
	var word="(" + atom + "|" + quotedUser + ")";
	var userPat=new RegExp("^" + word + "(\\." + word + ")*$");
	var domainPat=new RegExp("^" + atom + "(\\." + atom + ")*$");
	var matchArray=emailStr.match(emailPat);
	if (matchArray == null) {
		return false;
	}
	var user=matchArray[1];
	var domain=matchArray[2];
	if (user.match(userPat) == null) {
		return false;
	}
	var IPArray = domain.match(ipDomainPat);
	if (IPArray != null) {
		for (var i = 1; i <= 4; i++) {
			if (IPArray[i] > 255) {
				return false;
			}
		}
		return true;
	}
	var domainArray=domain.match(domainPat);
	if (domainArray == null) {
		return false;
	}
	var atomPat=new RegExp(atom,"g");
	var domArr=domain.match(atomPat);
	var len=domArr.length;
	if ((domArr[domArr.length-1].length < 2) ||(domArr[domArr.length-1].length > 3)) {
		return false;
	}
	if (len < 2) {
	   return false;
	}
	return true;
}