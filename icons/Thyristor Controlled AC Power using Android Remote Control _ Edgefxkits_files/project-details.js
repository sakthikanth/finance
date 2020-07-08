/**
* @theme    	efk
* @package     default
* @copyright   edgefxteam@divami.com
*/
var PdClicksClass = Class.create();
PdClicksClass.prototype = {
	
	initialize : function(){
		var sb = this.sb;
		
		//hide review form by default
		this.hideReviewForm();
		//$$('.popup-close-button').invoke('observe','click',this.popupClose.bind(this));
		sb.attachEvents($$('.zoom-popup'), 'click', this.openImagePopup, this);
		sb.attachEvents($$('.image-list'), 'click', this.showImageInImageViewer, this);
		sb.attachEvents($$('.video-list-link'), 'click', this.showVideoInPopup, this);
		sb.attachEvents($$('.blockDiagramHolder .edgefxSpriteImage.enalargeImage')[0], 'click', this.showLargeBlockDiagram, this);
		sb.attachEvents($$('.notify-me'), 'click', this.showNotifyOverlay, this);
		//sb.attachEvents($$('body'), 'click', this.hideOverlays, this);
		sb.attachEvents($$('.writeReviewButton'), 'click', this.toggleReviewSection, this);
		sb.attachEvents($$('.projectContentSpecification'), 'click', this.gatherPopupInfo, this);
		//sb.attachEvents($$('.kitDetails'), 'click', this.gatherPopupInfo, this);
		sb.attachEvents($$('.cancel-review-form'), 'click', this.hideReviewForm, this);
		sb.attachEvents($$('.close-write-review-form'), 'click', this.hideReviewForm, this);
		sb.attachEvents($$('.review-star'), 'click', sb.decorateStars, sb);
		//sb.attachEvents($$('.share-btn-alt-link'), 'click', this.invokeShareBtn, this);
		// sb.attachEvents($$('.reviewSubmitButton'), 'submit', this.submitReviewForm, this);
		var reviewForm = $('review-form');
		if(reviewForm){
			reviewForm.onsubmit = this.submitReviewForm.bind(this);
		}
		var moreViews = $$(".more-views");
		if(moreViews.length){
			var currentImageElement = moreViews && moreViews[0].select("li.default-highlight")[0];
			if(currentImageElement){
				currentImageElement.setStyle({"border": "2px solid #174762"});
			}
		}
		this.decorateBD();
		var showWriteReviewMessage = $('show-write-review-message');
		if(showWriteReviewMessage){
			Element.hide(showWriteReviewMessage);
		}

		// ajax call function for Q & A section
	    var questionsShowMoreLinks = $$('.edgefxQuestionAnswerSection .showMoreLink');
	    if(questionsShowMoreLinks.length){
			    sb.attachEvents(questionsShowMoreLinks[0], 'click', this.loadAllQuestions, this);
	    }

	    //matching items flag click event
	    sb.attachEvents($$('.match-items-click'), 'click', this.getMatchingItems, this);
		// sb.imagesPreloading();
		this.compare = (comparing)?comparing: new Compare();

		this.assignBorderToDefaultImageList();
	},
	
	currentImageElement : null,
	
	//Using other classes
	sb : new SandBox(),
	compare : new Compare(),
	validation : new UserValidation(),
	assignBorderToDefaultImageList: function(){
		var magicPlus = $$('.MagicZoomPlus');
		if(magicPlus.length){
			magicPlus = magicPlus[0];
			var magicId = magicPlus.readAttribute('id');
			var magicMatch = magicId.match(/\d+$/);
			if(magicMatch.length){
				var magicIdNumber = magicMatch[0];
				$('imageMain' + magicIdNumber).up('li').addClassName('selected-image-border');
			}
		}
	},
	getMatchingItems: function(e){
		var cur = e.currentTarget;
		var me = this;
		var parameters = {
			'ids' : cur.readAttribute('data-ids')
		};
		var url = cur.readAttribute('data-url');
		var elementToBlock = $$('body')[0];
		this.sb.screenBlocker.hide(elementToBlock);
		// this.sb.screenBlocker.show(elementToBlock);
		this.popupTemplateObject.showPopUpOnPageLoad({
			"headerTitle": cur.innerHTML,
			"minH": "413px",
			"commonPopupCls": ['matching-products-container']
		});
		new Ajax.Request(url, {
			onSuccess: function(response) {
				//var div = document.createElement('response.responseText');
				me.popupTemplateObject.showPopup(response.responseText);
		    	me.attachMatchEvents().bind(me);
			}.bind(this),
			onComplete: function(){
				me.sb.screenBlocker.hide(elementToBlock);
			}
		});
	},
	attachMatchEvents: function(){
		this.sb.attachEvents($$('.next-button-img'), 'click', this.nextMatchItem, this);
		this.sb.attachEvents($$('.prev-button-img'), 'click', this.prevMatchItem, this);

		var compare = this.compare;
		var popup = $('popup-container');
		var compareCheck = $(popup).select('.compare-chk');
		if(compareCheck.length){
			//detach compare check event
			this.sb.detachEvents(compareCheck, 'click', compare.addCompareProduct);
			//attach compare check event
			this.sb.attachEvents(compareCheck, 'click', compare.addCompareProduct, compare);
			compare.refreshCheck();
		}
	},
	nextMatchItem: function(e){
		var wrapper = $$('.matching-product-wrapper')[0];
		if(wrapper){
			var left = wrapper.style.left;
			var productSection = wrapper.select('.matching-product-section');
			if(productSection.length){
				var length = productSection.length;
				var offsetWidth = wrapper.offsetWidth;
				var itemSize = (offsetWidth/length);
				var constant = itemSize * 2;
				var leftValue = left.length?Math.abs(parseInt(left, 10)):0;
				if((offsetWidth - leftValue) >= itemSize){
					var remainingWidth = offsetWidth - (leftValue + constant);					
					if(remainingWidth > 0){
						var applyLeft = -(leftValue + constant);
						wrapper.style.left = applyLeft + "px";
					}
				}
			}
		}
	},
	prevMatchItem: function(e){
		var wrapper = $$('.matching-product-wrapper')[0];
		if(wrapper){
			var left = wrapper.style.left;
			var productSection = wrapper.select('.matching-product-section');
			if(productSection.length){
				var length = productSection.length;
				var offsetWidth = wrapper.offsetWidth;
				var constant = (offsetWidth/length) * 2;
				var leftValue = left.length?parseInt(left, 10):0;
				var remainingWidth = Math.abs(leftValue);
				if(remainingWidth > 0){
					var applyLeft = leftValue + constant;
					wrapper.style.left = applyLeft + "px";
				}
			}
		}
	},
	loadAllQuestions : function(e){
		e.stop();
		var cur = e.currentTarget;
		var url = cur.readAttribute('href');
		var me = this;
		var elementToBlock = $$('.edgefxQuestionAnswerSection')[0];
		this.sb.screenBlocker.show(elementToBlock, true);      
		new Ajax.Request(url, {
			onSuccess: function(response) {
				elementToBlock.update(response.responseText);
			},
			onComplete: function(){
				me.sb.screenBlocker.hide(elementToBlock);
			}
		});
	},
	invokeShareBtn: function(e){
		var current = e.currentTarget;
		var div = current.next();
		div.down('a').click();
	},
	decorateBD: function(){
		var blockDiagramHolder = $$('.blockDiagramHolder');
		if(blockDiagramHolder.length){
	        var blockDiagrams = blockDiagramHolder[0].select('img');
	        var bdItemListHolder = $$('.blockdiagram-list-holder')[0];
	        var bdLength = blockDiagrams.length;
	        if(bdLength > 1){
	        	var sb = this.sb;
	        	this.setBlockDiagram(blockDiagrams);
	            //show small list with items equal to length
	            for(var i=0; i<bdLength; i++){
	                var div = new Element('div');
	                div.addClassName('bd-item-icon fontOpenSemiBold font_12');
	                bdItemListHolder.appendChild(div);
	                div.update(i+1);
	                //attach event to only the newly created item
	                sb.attachEvents(div, 'click', this.bdViewer, this);
	                //setting border to the initial bd icon by default
	                if(i == 0){
	                	//div.style.border = "2px solid #174762";
	                	div.addClassName('bd-item-active-icon');
	                }else{
	                	div.addClassName('bd-item-inactive-icon');
	                }
	            }
	        }
	        if(bdLength){
	        	blockDiagrams[0].addClassName('current-bd');
	        }
	    }
    },
    bdViewer : function(e){
    	this.sb.gaTrack('project details', 'view block diagram', 'clicked on block diagram icon');
    	var elem = e.currentTarget;
    	//set border
    	var activeElem = $$('.bd-item-active-icon')[0];
    	if(activeElem){
    		activeElem.removeClassName('bd-item-active-icon');
    		activeElem.addClassName('bd-item-inactive-icon');
    	}
    	/*$$('.bd-item-icon').each(function(element){
    		element.style.border = "";
    	});*/
    	//elem.style.border = "2px solid #174762";
    	elem.removeClassName('bd-item-inactive-icon');
    	elem.addClassName('bd-item-active-icon');
    	//Get the index position
    	var index = elem.previousSiblings().size();
    	var blockDiagrams = $$('.blockDiagramHolder')[0].select('img');
    	this.setBlockDiagram(blockDiagrams, index);
    },
    setBlockDiagram : function(blockDiagrams, index){
    	index = index? index: 0;
    	//hide the blockdiagrams except the selected one.
        blockDiagrams.each(function(img){
            img.addClassName('hide');
            img.removeClassName('show');
            img.removeClassName('current-bd');
        });
        //Show the provided index value element.
        //By default keep the first BD img visible
        blockDiagrams[index].removeClassName('hide');
        blockDiagrams[index].addClassName('show');
        blockDiagrams[index].addClassName('current-bd');
    },
	showLargeBlockDiagram: function(e){
		this.sb.gaTrack('project details', 'large block diagram', 'clicked on zoom icon of block diagram');
		var popupTemplateObject = this.popupTemplateObject;
		var imgs = e && e.currentTarget.up().select('img');
		var img = imgs[0]; //setting the first element by default
		for(var i=0; i<imgs.length;i++){
			img = imgs[i];
			if(img.hasClassName('show')){
				break;
			}
		}
		var src = img.src;
		$('popup-container').show();
		popupTemplateObject.getLargeImagePopupTemplate(src, "Block Diagram");
		
		//hide nav buttons if blockdiagram is single
		if(imgs.length == 1){
			var next = $$('.next-img') && $$('.next-img')[0];
			var prev = $$('.prev-img') && $$('.prev-img')[0];
			if(next && prev){
				Element.hide(next);
				Element.hide(prev);
			}
		}
		this.attachBdNavEvents();
		this.checkPopupImageSize();
	},
	attachBdNavEvents : function(){
		var sb = this.sb;
		//detach other events if present
		sb.detachEvents($$('.next-img'), 'click');
		sb.detachEvents($$('.prev-img'), 'click');
		//attach events
		sb.attachEvents($$('.next-img'), 'click', this.nextBDImage, this);
		sb.attachEvents($$('.prev-img'), 'click', this.prevBDImage, this);
		sb.attachEvents($$('.zoom-status-holder'), 'click', this.toggleLargeImageSize, this);
	},
	nextBDImage : function(){
		this.sb.gaTrack('project details', 'next block diagram image', 'clicked on next nav button of block diagram popup');
		var current = $$('img.current-bd')[0];
		var next = current.next('img');
		if(!next){
			next = current.up().select('img')[0];
		}
		var src = next.src;
		if(src){
			var img = $$('.large-image')[0];
			var element = $$('.zoom-status-holder')[0];
			this.contractLargeImage(img, element);
			current.removeClassName('current-bd');
			next.addClassName('current-bd');
			$$('.popup-large-image')[0].src = src;
		}
		this.checkPopupImageSize();
	},
	prevBDImage : function(){
		this.sb.gaTrack('project details', 'previous block diagram image', 'clicked on previous nav button of block diagram popup');
		var current = $$('img.current-bd')[0];
		var previous = current.previous('img');
		if(!previous){
			//get the last img element
			var imgs = current.up().select('img');
			var imgLength = imgs.length;
			previous = imgs[imgLength - 1];
		}
		var src = previous.src;
		if(src){
			var img = $$('.large-image')[0];
			var element = $$('.zoom-status-holder')[0];
			this.contractLargeImage(img, element);
			current.removeClassName('current-bd');
			previous.addClassName('current-bd');
			$$('.popup-large-image')[0].src = src;
		}
		this.checkPopupImageSize();
	},
	submitReviewForm : function(e){
		e.stop();
		this.sb.gaTrack('project details', 'submit review form', 'clicked on submit review button');
		var validation = this.validation;
		//Validate fields
		var form = e.currentTarget;
		if(validation.isValidated(form)){
			//call ajax function
			var url = form.action;
			url = this.sb.removeHTTP(url);
	    	this.sb.screenBlocker.show($$('.reviewFormHolder')[0], true);      
	        var request = new Ajax.Request(
		        url,
		        {
		            method:'post',
		            parameters : Form.serialize(form.id),
		            onComplete: function(){
		            	this.sb.screenBlocker.hide($$('.reviewFormHolder')[0]);
	            	}.bind(this),
		            onSuccess: function(data){
		            	var response = JSON.parse(data.responseText);
		            	var reviewMessage = $('show-write-review-message');
		            	Element.show(reviewMessage);
		            	if(response.success){
		            		reviewMessage.update(response.message);
	            		this.hideReviewMessage.delay(7, reviewMessage);
	            		//hide and reset form
		            	this.hideReviewForm(true);
		            	}else{
		            		if(response.captcha){
								this.showCaptchaErrorMess();
							}else{
								reviewMessage.update(response.message);
							}
		            	}
		            }.bind(this)
		        }
	        );
		}
	},
	showCaptchaErrorMess : function(){
		var captchaElement = $('captcha_product_review');
		if(!captchaElement){
			console.log('invalid captcha id');
			return;
		}
		this.validation.setErrorColor(captchaElement);
		this.validation.writeAttribute(captchaElement, "invalid_captcha");
		this.reloadCaptcha();
	},
	reloadCaptcha : function(){
		var captchaReload = $('captcha-reload');
		if(captchaReload){
			captchaReload.click();
		}else{
			console.log('no reload element');
		}
	},
	hideReviewMessage: function(el){
		Element.hide(el);
	},
	onSuccess : function(data){
		console.log("hello");
	},
	popupTemplateObject: new PopupTemplateClass(),	
	hideReviewForm : function(bln){
		if(!bln){
			this.sb.gaTrack('project details', 'hide review form', 'clicked on close button of review form');
		}
		//clear fields
		this.resetFields();
		var addForm = $$('.form-add');
		if(addForm.length){
			var writeReviewForm = addForm[0];
			writeReviewForm.style.display = "none";
		}
	},
	resetFields : function(){
		var reviewForm = $('review-form');
		var me = this;
		var validation = me.validation;
		if(reviewForm){
			reviewForm.reset();
			//resetting field error messages
			validation.resetFormErrorFields(reviewForm);
			//clear stars
			$$('.review-star').each(function(element){
			    element.checked = false;
			    element.up('label').className = "edgefxSpriteImage deactive-star";
			});
			this.reloadCaptcha();
		}
	},
	gatherPopupInfo : function(e){
		e.stop();
		this.sb.gaTrack('project details', 'view hardware contents', 'clicked on hardware contents link');
		var url = e.currentTarget.readAttribute('data-href');
		this.getBackendPopupPage(url);
	},
	getBackendPopupPage : function(url){
		var me = this;
		var elementToBlock = $$('body')[0];
		this.sb.screenBlocker.hide(elementToBlock);
		// this.sb.screenBlocker.show(elementToBlock);
		this.popupTemplateObject.showPopUpOnPageLoad({
			"headerTitle": "Hardware Contents and Specifications",
			"minH": "475px",
			"commonPopupCls": ['cartpopup']
		});
		url = this.sb.removeHTTP(url);
		new Ajax.Request(url, {
			onSuccess: function(response) {
				//var div = document.createElement('response.responseText');
				me.popupTemplateObject.showPopup(response.responseText);
		    	// me.attachSpecEvents();
			}.bind(this),
			onComplete: function(){
				me.sb.screenBlocker.hide(elementToBlock);
			}
		});
	},
	// attachSpecEvents : function(){
	// 	this.sb.attachEvents($$('.edgefxpopupCloseHolder'), 'click', this.closeSpecPopup, this);
	// 	this.sb.attachEvents(document, 'keydown', this.escTrigger, this);
	// },
	// escTrigger : function(e){
	// 	if(e.keyCode == 27){
	// 		this.closeSpecPopup();
	// 	}
	// },
	closeSpecPopup : function(){
		Element.hide($('popup-container'));
	},
	toggleReviewSection : function(e){
		this.sb.gaTrack('project details', 'toggle review section', 'clicked on write review button');
		$('show-write-review-message').update("");
        var writeReviewForm = $$('.form-add')[0];
        var display = writeReviewForm && writeReviewForm.style.display;
        writeReviewForm.style.display = "block";
	},
	openImagePopup: function(e){
		this.sb.gaTrack("project details", "image zoom", "clicked on zoom for image popup");
		var popupTemplateObject = this.popupTemplateObject;
		var sb = this.sb;
		var el = e.currentTarget;
		var image = $('image');
		var title = image.readAttribute('title');
		if(image.style.display == "none"){
			//show video popup
			var src = el.previous('.video-viewer-container').down('.video-viewer').readAttribute('src');
			popupTemplateObject.getVideoPopupTemplate(src, title);
		}
		else{
			var src = image.readAttribute('data-largesrc');
			popupTemplateObject.getLargeImagePopupTemplate(src, title);			
		}
		this.attachImagePopupEvents();		
	},
	attachImagePopupEvents : function(){
		var sb = this.sb;
		sb.attachEvents($$('popup-close-button'), 'click', this.closePopup, this);
		sb.attachEvents($$('.next-img'), 'click', this.nextImage, this);
		sb.attachEvents($$('.prev-img'), 'click', this.prevImage, this);
		sb.attachEvents($$('.zoom-status-holder'), 'click', this.toggleLargeImageSize, this);
	},
	toggleLargeImageSize: function(e){
		this.sb.gaTrack('project details - popup','toggle large image size', 'clicked on image size toggling element in image popup' );
		var element = e.currentTarget;
		var image = element.previous('img');//.down('img');
		if(element.hasClassName('expand')){
			this.expandLargeImage(image, element);
		}
		else{
			this.callContractLargeImage(image, element);
		}
	},
	expandLargeImage: function(img, element){
		this.sb.gaTrack('project details - popup', 'expand popup image', 'clicked on toggle image size element to expand');
		element.addClassName('contract');
		element.removeClassName('expand');
		element.writeAttribute('title', 'contract image');
		img.removeClassName('popup-large-image');
		img.up('div').addClassName('overflowAuto popup-large-image');
	},
	callContractLargeImage: function(img, element){
		this.sb.gaTrack('project details - popup', 'contract popup image', 'clicked on toggle image size element to contract');
		this.contractLargeImage(img, element);
	},
	contractLargeImage: function(img, element){
		element.addClassName('expand');
		element.removeClassName('contract');
		element.writeAttribute('title', 'expand image');
		img.addClassName('popup-large-image');
		img.up('div').removeClassName('overflowAuto popup-large-image');
	},
	closePopup : function(){
		this.sb.gaTrack('project details - popup', 'close popup', 'clicked on close button to close the popup');
		Element.hide($('popup-container'));
	},
	showSignup : function(event){
		event.stop();
		var url = event.currentTarget.href; 
		//popupTemplateObject.getSignupTemplate();
		url = this.sb.removeHTTP(url);
		new Ajax.Request(url, {
			onSuccess: function(response) {
				var div = document.createElement(response.responseText);
				var html = $$('.account-create')[0];
			}
		});
	},
	hideOverlays : function (e) {
	    var re, els, iterator;
	    re = /(^|\s)(notify-me|form-add|writeReviewButton|notify-overlay)(\s|$)/;
	    els = [$(e.target)].concat($(e.target).ancestors());
	    iterator = function (el) { return re.test(el.classNames()); };
	    if (els.find(iterator)) return false;
	    $$('.notify-overlay', '.form-add').invoke('hide');
	},
	checkPopupImageSize: function(){
		var height = true && $$('.image-popup-body')[0].down('img').getHeight();
		var zoomIcon = $$('.zoom-status-holder')[0];
		if(height && height < 520){
			//hide zooming icon
			Element.hide(zoomIcon);
		}
		else{
			Element.show(zoomIcon);
		}
	},
	showImageInImageViewer: function(e){
		this.sb.gaTrack('project details', 'image viewer', 'clicked on image viewer');
		var currentElem = e.currentTarget;
		this.resetBorderStyle(currentElem);
		var currentImageElement = currentElem.up('li', 0);
		var sb = this.sb;
		//show image
		var image = $('image');
		Element.show(image);
		//hide video viewer
		var videoViewer = $$('.video-viewer')[0];
		Element.hide(videoViewer);
		image.src = sb.getAttribute(currentElem, 'data-smallsrc');

		var listItem = currentElem && currentElem.up().up();
		var index = $(listItem).previousSiblings().size();
		image.setAttribute('data-index', index);
	},
	showVideoInPopup: function(e){
		// var popupTemplateObject = this.popupTemplateObject;
		// //resetting src to stop the video in image viewer
		// var videoViewer = $$('.video-list-link')[0];
		// var src = videoViewer.readAttribute('data-href');
		// popupTemplateObject.getVideoPopupTemplate(src);
		this.sb.gaTrack('project details', 'video popup', 'clicked on video popup icon');
		var elem = e.currentTarget;
		
		//hide image
		var image = $$('a.MagicZoomPlus');
		if(!image.length){
			image = $('image');
			//reset border style
			// this.resetBorderStyle(elem);
		}
		else{
			image = image[0];
		}

		elem.up('ul').select('li').each(function(el){ 
			el.removeClassName('selected-image-border'); 
		})
		elem.up('li').addClassName('selected-image-border');

		Element.hide(image);
		//show video viewer
		var videoViewer = $$('.video-viewer')[0];
		videoViewer.up().style.display = "block";
		videoViewer.show();
		videoViewer.src = elem.readAttribute('data-href') + "?wmode=opaque";
	},
	resetBorderStyle : function(e){
		$$(".image-list-ul")[0].select("li").each(function(element){
			element.setStyle({"border":""});
		});
		//reset video 
		e.up('li').setStyle({"border": "2px solid #174762"});
	},
	prevImage: function(e){
		this.sb.gaTrack('project details - popup','show previous image', 'clicked on previous nav button on image popup');
		var sb = this.sb;
		var index = parseInt(sb.getAttribute('image', 'data-imgindex'), 10);
		var imgListItem = $$('.image-list-item');
		var imgListLength = imgListItem.length;
		index--;
		if(index < 0){
			index = imgListLength - 1;
		}
		var img = $$('.large-image')[0];
		var element = $$('.zoom-status-holder')[0];
		this.contractLargeImage(img, element);
		var src = imgListItem[index].select('.image-list')[0].readAttribute('data-largesrc');
		img.writeAttribute('src', src);
		$('image').setAttribute('data-imgindex', index);
	},
	nextImage: function(e){
		this.sb.gaTrack('project details - popup','show next image', 'clicked on next nav button on image popup');
		var sb = this.sb;
		var index = parseInt(sb.getAttribute('image', 'data-imgindex'), 10);
		var imgListItem = $$('.image-list-item');
		var imgListLength = imgListItem.length;
		index++;
		if(parseInt(index, 10) >= imgListLength){
			index = 0;
		}
		var img = $$('.large-image')[0];
		var element = $$('.zoom-status-holder')[0];
		this.contractLargeImage(img, element);
		var src = imgListItem[index].select('.image-list')[0].readAttribute('data-largesrc');
		img.writeAttribute('src', src);
		$('image').setAttribute('data-imgindex', index);
	},
	showNotifyOverlay: function(e){
		this.sb.gaTrack('project details', 'notify overlay', 'clicked on notify me button');
		var notifyForm = $$('.notify-overlay')[0];
		var display = notifyForm.style && notifyForm.style.display;
        notifyForm.style.display = display == "none"?"block":"none";
	}
};

document.observe("dom:loaded", function() {
	var projectDetails = new PdClicksClass();
});
