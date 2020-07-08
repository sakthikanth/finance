/**
 *
 * @theme    efk
 * @package     default
 * @copyright   edgefxteam@divami.com
 */

var AuthenticationTabPanelClass = Class.create();
AuthenticationTabPanelClass.prototype = {
	params : {},
	defaults : {
		stop : false,
        errors : '',
        profileUrl : '',
        firstname : '',
        password : '',
        passwordsecond : '',
        email : '',
		telephone : '',
		lastname : '',
	},
	firstClick : false,
	tabPanelDetails : {},
    initialize : function(){
		var sb = this.sb;
		this.success = this.onSuccess.bind(this);
		this.complete = this.onComplete.bind(this);
		this.failure = this.onFailure.bind(this);
		sb.attachEvents($$('.ajax-authentication'), 'click', this.showTabPanel, this);
		// sb.attachEvents($(document), 'keydown', this.onKeyPress, this);
	},
	sb : new SandBox(),
    popupTemplateObject : new PopupTemplateClass(),
    validation: new UserValidation(),
	
	efkAjaxLogin : function() {
		$$('.ajax-authentication[value=login]')[0].click();
	},
	showTabPanel : function(event){
	var url = null;
		if(event) {
			event.stop();
			var element = event.currentTarget;
			this.params['clicked-tab'] = element.readAttribute('value');
			url = element.readAttribute('href');
            		url = this.sb.removeHTTP(url);	
		}
		this.popupTemplateObject.showPopUpOnPageLoad({
									"headerTitle": '',
									"minH": "386px",
									"commonPopupCls": ['signupLoginHolder']
							});
		this.sb.gaTrack(this.params['clicked-tab'],'Click','Clicked on ' + this.params['clicked-tab']);
		var request = new Ajax.Request(
            url,
            {
                method:'post',
                parameters:this.params,
                onComplete: this.complete,
                onSuccess: this.success,
                onFailure: this.failure
            }
        );
	},
	
	getForgotPasswordCode : function(event) {
		this.sb.gaTrack('Login/SignUp tabpanel','Forget Password','Clicked on forget password');
        var popupContainer = $('popup-container');
        var forgotPwdHolder = $(popupContainer).select('#forgotPwd-container .forgotPWDFormHolder')[0];
        Element.show(forgotPwdHolder);
        forgotPwdHolder.removeClassName('hide');
        
        $$('#forgotPwd-container #email')[0].focus();
        Element.hide($(popupContainer).select('#forgotPwd-container .forgotPwdLinkHolder')[0]);
        Element.hide($(popupContainer).select('.loginBtnSetParent .loginBtnSet')[0]);
        var forgotPwdInfo = $$('.forgotPwdInfo')[0];
        if(forgotPwdInfo) {
        	forgotPwdInfo.show();	
        }
	},
	
	onForgotPasswordCancel : function(event) {
		var popupContainer = $('popup-container');
		this.sb.gaTrack('Forget Password','cancel','Cancel the forget password');
        var forgotPwdHolder = $(popupContainer).select('#forgotPwd-container .forgotPWDFormHolder')[0];
        Element.hide(forgotPwdHolder);
        forgotPwdHolder.addClassName('hide');
        
        Element.show($(popupContainer).select('.loginBtnSetParent .loginBtnSet')[0]);
        Element.show($(popupContainer).select('#forgotPwd-container .forgotPwdLinkHolder')[0]);
        $$('#login-container #email')[0].focus();
        var forgotSuccessMsg = $$('.success-forgotpassword')[0];
        if(forgotSuccessMsg) {
        	forgotSuccessMsg.hide();	
        }
	},	
	
	onComplete : function(data) {
		var sb = this.sb;	
		this.attachEvents();
		var popupContainer = $('popup-container');
		this.firstClick = true;
		$$('#' + this.params['clicked-tab'])[0].click();
		
		this.defaults.profileUrl = $(popupContainer).select('#profileurl')[0].value;
		
		sb.attachEvents($$('.forgot-password'), 'click', this.getForgotPasswordCode, this);
		sb.attachEvents($$('.forgotPWDFormHolder .cancelForgotPwd'), 'click', this.onForgotPasswordCancel, this);
		sb.attachEvents($(popupContainer).select('#email'), 'blur', this.onValidateEmail, this);
		//sb.attachEvents($(popupContainer).select('#pass'), 'blur', this.onValidatePassword, this);
		//sb.attachEvents($(popupContainer).select('#password'), 'blur', this.onValidatePassword, this);
		
		sb.attachEvents($$('#login-container input[type=submit].loginBtn'), 'click', this.onLoginClick, this);
		sb.attachEvents($$('#signup-container input[type=submit].signupBtn'), 'click', this.onSignupClick, this);
		sb.attachEvents($$('#forgotPwd-container input[type=submit].forgotPwdBtn'), 'click', this.onForgotPwdClick, this);
		if(this.tabPanelDetails["tabPanel[tab]"] == 'signup'){
			$$('#' + this.tabPanelDetails["tabPanel[tab]"] + '-container #firstname')[0].focus();
		}else{
			$$('#' + this.tabPanelDetails["tabPanel[tab]"] + '-container #email')[0].focus();
		}
	},
	
	onValidateEmail : function(event) {
		var element = event.currentTarget;
		var email = element.value;
		var form;
		if(element.hasClassName('forgotPWDFields')) {
			form = 'forgotPwd';	
		} else {
			form = element.up('form').id.split('-')[0];	
		}
		
	    /*if(!email && !this.validateEmail(email)) {
	    	this.validation.applyErrorField('wrongemail', form);
	    } else {
	    	Element.update($$('#' + form + '-container .err-wrongemail')[0], '');
	    	this.validation.applyErrorField('wrongemail', form, true);
	    }*/
	    if(form == 'login') {
	    	$$('#forgotPwd-container #email')[0].value = email;
	    }
	},
	
	onValidatePassword : function(event) {
		event.stop();
		var element = event.currentTarget;
		var password = element.value;
		var form = element.up('form').id.split('-')[0];
		var opts = AuthenticationTabPanelClass.prototype.defaults;
		opts.errors = '';
		this.checkPassword(password);
		if (opts.errors != ''){
            this.setError(opts.errors, form);
        }
	},
	
	checkPassword : function(password) {
		var opts = AuthenticationTabPanelClass.prototype.defaults;
		if(password.length < 6) {
			opts.errors = opts.errors + 'shortpassword,';
		} else if(password.match(/ +?/g)) {
			opts.errors = opts.errors + 'nospacepassword,';
		} else if(!(password.match(/[a-z]/) || password.match(/[A-Z]/))) {
			opts.errors = opts.errors + 'nocharpassword,';
		} else if(!password.match(/\d+/g)) {
			opts.errors = opts.errors + 'nonumpassword,';
		}		
	},
	
	onLoginClick : function(event) {
		event.stop();
		var opts = AuthenticationTabPanelClass.prototype.defaults;
		opts.url = event.currentTarget.readAttribute('url');
		this.sb.gaTrack(this.params['clicked-tab'],'login','User trying to login');
		this.setDatas('login');
		this.validateDatas('login');
		this.resetServerErrorField();
		if (opts.errors != ''){
            this.setError(opts.errors, 'login');
        }
        else{
            this.callAjaxControllerLogin();
        }
        return false;
	},
	
	onSignupClick : function(event) {
		event.stop();
		var opts = AuthenticationTabPanelClass.prototype.defaults;
		opts.url = event.currentTarget.readAttribute('url');
		this.sb.gaTrack(this.params['clicked-tab'],'signup','User trying to signup');
		this.setDatas('signup');
		this.validateDatas('signup');
		if (opts.errors != ''){
            this.setError(opts.errors, 'signup');
        }
        else{
            this.callAjaxControllerRegistration();
        }
        return false;
	},
	
	onForgotPwdClick : function(event) {
		event.stop();
		var opts = AuthenticationTabPanelClass.prototype.defaults;
		opts.url = event.currentTarget.readAttribute('url');
		this.sb.gaTrack('Forget Password','sendrequest','Clicked for reset password');
		this.setDatas('forgotPwd');
		this.validateDatas('forgotPwd');
		if (opts.errors != ''){
            this.setError(opts.errors, 'forgotPwd');
        }
        else{
            this.callAjaxControllerForgotPwd();
        }
        return false;
	},
	
	callAjaxControllerLogin : function() {
		var opts = AuthenticationTabPanelClass.prototype.defaults;
		var me = this;
		
		var elementToBlock = $$('.signupLoginPopupContainer')[0];
		me.sb.screenBlocker.hide(elementToBlock);
		me.sb.screenBlocker.show(elementToBlock, true);
		
		if (opts.stop != true){
			opts.stop = true;
			var url = me.sb.removeHTTP(opts.url);
            var ajaxRegistration = new Ajax.Request(url, {
                method:'post',
                parameters: {
                    'ajax' : 'login',
                    'email' : opts.email,
                    'password' : opts.password
                },
                onSuccess: function(response) {
                	var msg = response.responseText;
                	if (msg != 'success') {
	                    me.setServerError(msg, 'login');
                            me.sb.screenBlocker.hide(elementToBlock);
	                }
	                else{
                        opts.stop = false;
                        if(document.location.href.indexOf('resetpassword') == -1) {
                        	window.location = '';
                        } else {
                        	window.location = $$('.signupLoginPopupContainer')[0].select('#baseurl')[0];
                        }
                        //$$('.popup-close-button')[0].click();
                    }
	                opts.stop = false;
                }
            });
        }
    },
    
    callAjaxControllerRegistration : function() {
    	var opts = AuthenticationTabPanelClass.prototype.defaults;
    	var myAccountPage = $$('#signup-container form')[0].action;
		var me = this;
		
		var elementToBlock = $$('.signupLoginPopupContainer')[0];
		me.sb.screenBlocker.hide(elementToBlock);
		me.sb.screenBlocker.show(elementToBlock, true);
		
        if (opts.stop != true){
            opts.stop = true;
            var url = me.sb.removeHTTP(opts.url);
            var ajaxRegistration = new Ajax.Request(url, {
                type: 'POST',
                parameters: {
                    'ajax'       	 : 'signup',
                    'email'      	 : opts.email,
                    'password' 		 : opts.password,
                    'passwordsecond' : opts.passwordsecond,
                    'firstname'      : opts.firstname,
                    'lastname'       : opts.lastname,
                    'telephone'      : opts.telephone,
                },
                onSuccess: function(response) {
                	var msg = response.responseText;
                	if (msg != 'success') {
	                    me.setError(msg, 'signup');
	                    me.sb.screenBlocker.hide(elementToBlock);
	                }
	                else{
                        opts.stop = false;
                        window.location = '';
                        //$$('.popup-close-button')[0].click();
                    }
	                opts.stop = false;
                }
            });
        }
    },
    
    callAjaxControllerForgotPwd : function() {
    	var opts = AuthenticationTabPanelClass.prototype.defaults;
		var me = this;
		
		var elementToBlock = $$('.signupLoginPopupContainer')[0];
		me.sb.screenBlocker.hide(elementToBlock);
		me.sb.screenBlocker.show(elementToBlock, true);
		
		if (opts.stop != true){
			//opts.stop = true;
			var url = me.sb.removeHTTP(opts.url);
            var ajaxRegistration = new Ajax.Request(url, {
                method:'post',
                parameters: {
                    'ajax' : 'forgotPwd',
                    'email' : opts.email
                },
                onSuccess: function(response) {
                	var msg = response.responseText;
                	if (msg != 'success') {
	                    me.setError(msg, 'forgotPwd');
	                }
	                else{
                        opts.stop = false;
                        var forgotPwdInfo = $$('.forgotPwdInfo')[0];
                        if(forgotPwdInfo) {
                        	forgotPwdInfo.hide();	
                        }
                        var forgotPwdSuccessMsg = 'A reset link has been sent to your mail.';
                        Element.update($$('.success-forgotpassword')[0], forgotPwdSuccessMsg);
                        $$('.success-forgotpassword')[0].show();
                    }
	                opts.stop = false;
	                me.sb.screenBlocker.hide(elementToBlock);
                }
            });
        }
    },
    setServerError: function(errors, windowName){
    	var msg = errors.split(",");
    	var message = "";
    	if(msg.length){
    		msg = msg.splice(0,1);
    		if(msg.length){
    			message = msg[0];
    		}
    	}
    	if(message){
    		this.applyServerErrorField(message, windowName);
    	}
    },
    applyServerErrorField: function(message, windowName){
        var errorField = $('login-common-server-message');
        errorField.update(this.validation.emsg[message]);
        if(message !== "wronglogin"){
            var msgArr = ["email", "password"];
            for(var i=0; i < msgArr.length; i++){
                this.validation.applyErrorField(msgArr[i], windowName);
            }
        }
    },
    resetServerErrorField: function(){
    	var errorField = $('login-common-server-message');
    	errorField.update("");
        var msgArr = ["email", "password"];
        for(var i=0; i < msgArr.length; i++){
            this.validation.applyErrorField(msgArr[i], "login", true);
        }
    },
    setError: function(errors, windowName){
    	var items = $$('#' + windowName + '-container .authentication-ajaxlogin-error');
    	for (var index = 0; index < items.length; ++index) {
		  var item = items[index];
		  Element.update(item, '');
		}
		
		items.each(Element.hide);

        var errorArr = new Array();
        errorArr = errors.split(',');

        var length = errorArr.length - 1;
        //resetting fields
     	var msgArr = ['firstname','email', 'password', 'notsamepasswords','phone10'];
     	for (var i = 0; i < length; i++) {
        	this.validation.applyErrorField(msgArr[i], windowName, true);
        }
        //setting error fields
        for (var i = 0; i < length; i++) {
        	this.validation.applyErrorField(errorArr[i], windowName);
        }
        this.validation.setFocus();
        // for (var i = 0; i < length; i++) {
        //     var errorText = $$('.authentication-' + errorArr[i])[0].innerHTML;

        //     Element.update($$('#' + windowName + '-container .err-' + errorArr[i])[0], errorText);
        // }

        items.each(function(item) {
        	item.style.display = '';
        });
    },

    validateEmail:function(emailAddress){
        var filter = /^([\w-\.]+)@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.)|(([\w-]+\.)+))([a-zA-Z]{2,4}|[0-9]{1,3})(\]?)$/;

        return (filter.test(emailAddress));
    },
    
    setDatas : function (windowName) {
    	var opts = AuthenticationTabPanelClass.prototype.defaults;
    	if (windowName == 'signup') {
    		opts.email = $$('#' + windowName + '-container #email')[0].value;
	        opts.password = $$('#' + windowName + '-container #password')[0].value;
	        opts.passwordsecond = $$('#' + windowName + '-container #confirmPassword')[0].value;
			opts.firstname = $$('#' + windowName + '-container #firstname')[0].value;
            opts.telephone = $$('#' + windowName + '-container #phone')[0].value;
            opts.lastname = $$('#' + windowName + '-container #firstname')[0].value;
        } else if(windowName == 'login') {
	        opts.email = $$('#' + windowName + '-container #email')[0].value;
	        opts.password = $$('#' + windowName + '-container #pass')[0].value;
        } else if(windowName == 'forgotPwd') {
        	opts.email = $$('#' + windowName + '-container #email')[0].value;
        }
    },
    
    validateDatas : function(windowName){
    	var opts = AuthenticationTabPanelClass.prototype.defaults;
        opts.errors = '';
        
        if (windowName == 'signup'){
			if(opts.firstname.length < 1){
				opts.errors = opts.errors + 'empty_name,';
			}
			if (opts.email.length < 1) {
                opts.errors = opts.errors + 'noemail,';
            }
            else if (this.validateEmail(opts.email) != true){
                opts.errors = opts.errors + 'wrongemail,';
            }
            this.checkPassword(opts.password); 
            if (opts.password.length < 1) {
                opts.errors = opts.errors + 'nopassword,';
            }
            else if (opts.password.length < 6){
                opts.errors = opts.errors + 'shortpassword,';
            }
            else if (opts.password != opts.passwordsecond){
                opts.errors = opts.errors + 'notsamepasswords,';
            }
			if(opts.telephone.length < 1){
				opts.errors = opts.errors + 'empty_phone,';
			}else if (opts.telephone.length < 10){
                opts.errors = opts.errors + 'phone10,';
            }
        } else if (windowName == 'login'){
            if (opts.email.length < 1){
                opts.errors = opts.errors + 'noemail,';
            }
            else if (this.validateEmail(opts.email) != true){
                opts.errors = opts.errors + 'wrongemail,';
            }
            if (opts.password.length < 1){
                opts.errors = opts.errors + 'nopassword,';
            }
        } else if (windowName == 'forgotPwd'){
            if (opts.email.length < 1){
                opts.errors = opts.errors + 'noemail,';
            }
            else if (this.validateEmail(opts.email) != true){
                opts.errors = opts.errors + 'wrongemail,';
            }
        }
    },
	
	onSuccess : function(data) {
        var popupTemplateObject = this.popupTemplateObject;
		var domElement = new Element('div');
		var result = data.responseText.evalJSON();
		if(result.success) {
			domElement.insert(result.data.html);
			var authentication = $(domElement).select('.authentication')[0];
			var body = $$('body')[0];
			this.sb.screenBlocker.hide(body);
			popupTemplateObject.showPopup(authentication);
		} else {
			this.popupTemplateObject.closePopup();
		}
	},
	
	onFailure : function(data) {
		console.log('onFailure');
		this.popupTemplateObject.closePopup();
	},
	
	attachEvents : function(){
        var sb = this.sb;
		var tabPanelTabs = $$('.authentication-tab');
		sb.attachEvents(tabPanelTabs, 'click', this.selectedTab, this);
	},
	selectedTab : function(item) {
		/* Update url */
		var opts = AuthenticationTabPanelClass.prototype.defaults;
		var activeForm = item.currentTarget.readAttribute('id');
		if(!this.firstClick){
			this.sb.gaTrack('Login/SignUp tabpanel',activeForm,'Clicked on '+activeForm+' form');
		}
		this.firstClick = false;
		opts.profileUrl = $$('#' + activeForm + '-container form')[0].action;
		
		var element = item.currentTarget;
		var id = element.id;
		
		var previous = $$('.tabpanel-body-container.active')[0];
		var tabs = $$('.authentication-tab');
		tabs.forEach(function(tab) {
			tab.addClassName('unselectedTabHolder');
			tab.removeClassName('selectedTabHolder');
		});
		element.addClassName('selectedTabHolder');
		element.removeClassName('unselectedTabHolder');
				
		previous.removeClassName('active');
		previous.addClassName('hide');	
		var element = item.currentTarget;	
		var id = element.id;
		var tabPanelBodyContainer = $(id + '-container');
		tabPanelBodyContainer.removeClassName('hide');
		tabPanelBodyContainer.addClassName('active');
		
		this.tabPanelDetails['tabPanel[tab]'] = element.readAttribute('value');
		if(this.tabPanelDetails["tabPanel[tab]"] == 'signup'){
			$$('#' + this.tabPanelDetails["tabPanel[tab]"] + '-container #firstname')[0].focus();
		}else{
			$$('#' + this.tabPanelDetails["tabPanel[tab]"] + '-container #email')[0].focus();
		}
	},
	save : function(){
		var tabPanelTab = this.tabPanelDetails['tabPanel[tab]'];
        if(tabPanelTab){
	        var params = order.params;
	        params = params + (params!=''?'&':'') + Object.toQueryString(this.tabPanelDetails);
	        order.params = params;
	        return true;
        }
	}	
};

document.observe("dom:loaded", function() {
    authentication = new AuthenticationTabPanelClass();
});