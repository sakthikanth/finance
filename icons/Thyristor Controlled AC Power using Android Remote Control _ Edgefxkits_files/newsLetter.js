var NewsLetter = Class.create();
NewsLetter.prototype = {
	sb : new SandBox(),
	initialize: function(){
		var newsLetterSubmit = $('newsletter-validate-detail-submit');
		this.sb.attachEvents(newsLetterSubmit, 'click', this.subscribeUser, this);
		this.complete = this.onComplete.bind(this);
		this.success = this.onSuccess.bind(this);
		this.failure = this.onFailure.bind(this);
		this.messageElem = $$('.edgefxNewsSubSecWrapper .letterMessage')[0];
	},
	validation: new UserValidation(),
	subscribeUser : function(event){
		event.stop();
		var submitButton = event.currentTarget;
		//this.sb.screenBlocker.show(submitButton);
        var form = submitButton.up('form');
        //var formValidator = new Validation(form.id);
        var url = form.action;
        url = this.sb.removeHTTP(url);
	    if(this.validation.isValidated(form)){        
	        var request = new Ajax.Request(
		        url,
		        {
		            method:'post',
		            parameters : Form.serialize(form.id),
		            onComplete: this.complete,
		            onSuccess: this.success,
		            onFailure: this.failure
		        }
	        );
       }
	},
	onComplete : function(data){
		
	},
	onSuccess : function(data){
		var response = JSON.parse(data.responseText);
		if(this.messageElem){
			this.messageElem.innerHTML = response.message;
		}
		//alert(response.message);
		//console.log('success');
	},
	onFailure : function(data){
		//alert('Server is not connectiong.. try again later');
		if(this.messageElem){
			this.messageElem.innerHTML = 'Server is not connectiong.. try again later';
		}
	}
};

document.observe("dom:loaded", function() {
	newsLetterbject = new NewsLetter();
});