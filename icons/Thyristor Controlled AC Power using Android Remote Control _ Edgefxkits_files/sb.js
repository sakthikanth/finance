var SandBox =  Class.create();
SandBox.prototype = {
	initialize : function(){
		this.appendBR();	
		this.attachEvents($$('.iframe-wrapper'), 'click', this.showIframe, this);
	},

	showIframe: function(e){
		var el = $(e.currentTarget);
		Element.hide(el.down('.video-mask-wrapper'));
		var iframe = el.down('iframe');
		iframe.src = iframe.src.replace(/\d$/,"1");
		Element.show(iframe);
	},
		
	showPopupInMiddle : function (popup){
		//calculating 
		hidePopupsOnBodyClick();
		var popupDimensions = $(popup).getDimensions();
		var windowDimensions = document.viewport.getDimensions();
		var pwidth = popupDimensions.width/2;
		var pheight = popupDimensions.height/2;
		var width = windowDimensions.width/2;
		var height = windowDimensions.height/2;
		var top = (height - pheight) + 'px';
		var left = (width - pwidth) + 'px';
		$(popup).setStyle({
			top: top,
			left: left
		});
	},
	attachEvents : function(elements, eventname, callback, scope){
		if(!elements || !callback){
			return;
		}
		if(Object.isArray(elements)){
			var length = elements.length;
			for(var index=0; index<length;index++){
				var element = elements[index];
				if(scope){
					element.observe(eventname, callback.bind(scope));
				}else{
					element.observe(eventname, callback);
				}
			}
		}else{
			elements.observe(eventname, callback.bind(scope));
		}
	},
	detachEvents : function(elements, eventname, callback){
		if(!elements){
			return;
		}
		if(Object.isArray(elements)){
			var length = elements.length;
			for(var index=0; index<length;index++){
				var element = elements[index];
				if(callback){
					element.stopObserving(eventname, callback);
				}
				else{
					element.stopObserving(eventname);
				}
			}
		}else{
			if(callback){
				elements.stopObserving(eventname, callback);
			}
			else{
				elements.stopObserving(eventname);
			}
		}
	},
	addClass : function(elements,className){
		if(!elements){
			return;
		}
		if(Object.isArray(elements)){
			var length = elements.length;
			for(var index=0; index<length;index++){
				var element = elements[index];
				element.addClassName(className);
			}
		}else{
			elements.addClassName(className);
		}
	},
	removeClass : function(elements,className){
		if(!elements){
			return;
		}
		if(Object.isArray(elements)){
			var length = elements.length;
			for(var index=0; index<length;index++){
				var element = elements[index];
				element.removeClassName(className);
			}
		}else{
			elements.removeClassName(className);
		}
	},
	hide : function(elements){
		if(!elements){
			return;
		}
		if(Object.isArray(elements)){
			var length = elements.length;
			for(var index=0; index<length;index++){
				var element = elements[index];
				element.hide();
			}
		}else{
			elements.hide();
		}
	},
	show : function(elements){
		if(!elements){
			return;
		}
		if(Object.isArray(elements)){
			var length = elements.length;
			for(var index=0; index<length;index++){
				var element = elements[index];
				element.show();
			}
		}else{
			elements.show();
		}
	},
	previousSiblingElement: function(e){
		return Element.previous(e.currentTarget);
	},
	getAttribute: function(el, txt){
		return $(el).getAttribute(txt);
	},
	screenBlocker : {
		show : function(elem, blnPopup, message){
			if(!elem){return;}
			var color = blnPopup?"screenBlockerPopupImage":"screenBlockerImage";
			var hasMess = message?"hasMessage":'';
			var blocker = '<div class="screenBlocker ' + color + ' ' + hasMess + '"><div class="screenLoader"></div>';
			if(message){
				blocker += '<div class="loadermess fontOpenSemiBold font_11">'+message+'</div>';
			}
			blocker += '</div>';
			elem.insert(blocker);
		},
		hide : function(elem){
			if(!elem){
				return;
			}
			var blocker = $(elem).down(".screenBlocker");
			if(blocker) {
				blocker.remove();	
			}
		}
	},

	appendBR: function(){
	    var elements = $$('.name-ellipsis');
	    elements.each(function(element){
	    	var height = 45;
	    	if(/twolineellipsis/g.test(element.className)){
	    		height = 40;
	    	}	    	
		   	var text = element.textContent.split("");
		    var count = 0;
		    var globalHeight = 0;
		    element.innerHTML = "";
		    for(var i=0; i<text.length; i++){
		        element.innerHTML += text[i];
		        //debugger;
		        while(element.offsetHeight > height){
		            var html = element.innerHTML;
		            html = html.slice(0, -1);
		            
		            if(count > 0){
		                html = html.slice(0, -3);
		            }
		            html += "...";
		            element.innerHTML = html;
		            count++;
		        }
		    }
	    });
	},
	gaTrack : function(category, action, opt_label, opt_value, opt_noninteraction){
               if(!category && !action){
                       return;
               }
               var arguments = [];
               var i = 0;
               if(opt_label){
                       arguments[i++]=opt_label;
               }
               if(opt_value){
                       arguments[i++]=opt_value;
               }
               if(opt_noninteraction){
                       arguments[i++]=opt_noninteraction;
               }
               try{
	               if(_gaq){
	                       _gaq.push(['_trackEvent', category, action, opt_label, opt_value, opt_noninteraction]);
	               }
               }catch(error){
               	//console.log('Google analytics is disabled');
               }
       },
	decorateStars: function(e){
		this.gaTrack('review star', 'star rating', 'clicked on star rating');
		var elem = e.currentTarget;
		var activeImage = "edgefxSpriteImage active-star";
		var deactiveImage = "edgefxSpriteImage deactive-star";		
        if(elem.checked){
            var label = elem.parentElement;
            label.className = activeImage;
            var td = label.parentElement;
            $(td).previousSiblings('td').each(function(element){
                var radio = element.select('label')[0];
                if(radio){
                    radio.className = activeImage;
                }
            });
            $(td).nextSiblings('td').each(function(element){
                var radio = element.select('label')[0];
                if(radio){
                    radio.className = deactiveImage;
                }
            });

            //storing value in a text box (for sitefeedback)
            var reviewFormInputFields = $$('.reviewformRatingInputField.input-text');
			if(reviewFormInputFields[0]){
				reviewFormInputFields[0].value = parseInt(elem.value, 10) + 1;
			}
        }
        else{
            elem.parentElement.className = deactiveImage;
        }
	},
	allowNumbersOnly : function(event){
		var key = event.which;
		if((key > 31 && key <48) || (key > 57 && key < 127)){
			event.stop();
			//return false;
		}
	},
	imagesPreloading: function(value){
		var el = $$('.preloading-images')[0];
		var imgs = $$('.image-list');
		value = el.up('.quickViewLeftBottom')?"small":value;
		//reset
		el.update("");
		if(value == "large"){
	        for (i = 0; i < imgs.length; i++) {
	            var largeImage = new Image();
	            var img = imgs[i];
	            largeImage.src = img.readAttribute('data-largesrc');
	            el.insert(largeImage);
	        }
		}
		else if(value == "small"){
			for (i = 0; i < imgs.length; i++) {
	            var smallImage = new Image();
	            var img = imgs[i];
	            smallImage.src = img.readAttribute('data-smallsrc');
	            el.insert(smallImage);
	        }
		}
		else{
	        for (i = 0; i < imgs.length; i++) {
	            var largeImage = new Image();
	            var smallImage = new Image();
	            var img = imgs[i];
	            largeImage.src = img.readAttribute('data-largesrc');
	            smallImage.src = img.readAttribute('data-smallsrc');
	            el.insert(largeImage);
	            el.insert(smallImage);
	        }
		}
	},
	removeHTTP : function(url){
		if(typeof url === 'string'){
			return url.replace(/^http[s]?:/, '');
		}else{
			return url;
		}	
	},
	hideElements: function(elements) {
		if(Object.isArray(elements)) {
			var length = elements.length;
			for(var index = 0; index < length;index++) {
				elements[index].style.display = "none";
			}
		}
	}
		
};


