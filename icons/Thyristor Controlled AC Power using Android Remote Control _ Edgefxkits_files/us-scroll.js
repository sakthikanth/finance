var scroll = (function(){
    var values = [],
        reposition = false,
        previousTop = false,
        w = "wrapper",
        u = " unselectable",
        c = "content",
        S = "scrollBarContainer",
        s = "scrollBar",
        // mac animation classes. pass empty string to make the scroll work normal.
        a = " animate",
        m = " mac",
        useSlimScroll = function(C){
            if(C.offsetHeight < C.scrollHeight){
                var h = C.innerHTML;
                C.innerHTML = "";
                var key = values.length;
                values[key] = {};
                values[key].wrapper = createElement(w + u + m, "", C);
                values[key].content = createElement(c, h, values[key].wrapper);
                // content.setAttribute("unselectable","on"); /* IE8 unselectable fix */
                values[key].sbc = createElement(S + a, "", values[key].wrapper);
                values[key].scrollBar = createElement(s, "", values[key].sbc);


                values[key].wH = values[key].wrapper.offsetHeight;
                values[key].sH = values[key].wrapper.scrollHeight;
                values[key].sP = (values[key].wH/values[key].sH) * 100;
                // Manually set the height of the scrollbar (in percentage)
                values[key].sP1 = 15;

                values[key].rP1 = 100 - values[key].sP1;
                values[key].x = (values[key].sH - values[key].wH) * ((values[key].sP1 - values[key].sP)/(100 - values[key].sP));
                values[key].sH1 = Math.abs((values[key].x / (values[key].rP1)) + (values[key].sH/100));

                // register global values


                values[key].scrollBar.style.height = values[key].sP1 + "%";

                //store the key in the container

                setAttribute(values[key].wrapper, 'scroll-key', key);

                // Attaching mouse events
                addEvent('mousedown', values[key].scrollBar, beginScroll);
                addEvent('click', values[key].sbc, setScroll);

                // For scroll
                addEvent('scroll', values[key].wrapper, doScroll);
                // content.onselectstart = function() { return false; }
            }
        },
        setAttribute = function(e, p, v){
            e.setAttribute(p, v);
        },
        getAttribute = function(e, p){
            return e.getAttribute(p);
        },
        createElement = function(className, html, parent){
            var div = document.createElement('div');
            div.className = className;
            div.innerHTML = html;
            parent.appendChild(div);
            return div;
        },
        setScroll = function(e){
            var e = e || event;

            var sbc = e.currentTarget;
            var scrollBar = sbc.querySelector('.scrollBar');
            var wrapper = sbc.parentElement;

            var key = getAttribute(wrapper, 'scroll-key');

            values[key].scrollBar.className = s;
            var el = e.target || event.srcElement;
            var parentElement = el.parentElement || el.parentNode;
            if(parentElement === values[key].sbc){
                return false;
            }
            var ePageY = e.pageY || event.clientY;
            var top = ((ePageY - values[key].wrapper.parentElement.offsetTop)/values[key].wH * 100) - values[key].sP1/2;
            if(top > values[key].rP1){
                top = values[key].rP1;
            }
            else if(top < 0){
                top = 0;
            }
            values[key].scrollBar.style.top = top + "%";
            values[key].wrapper.scrollTop = top * values[key].sH1;
            values[key].sbc.className = S + a;
        },
        beginScroll = function(e){
            var e = e || event;

            // Elements
            var scrollBar = e.currentTarget;
            var sbc = scrollBar.parentElement;
            var wrapper = sbc.parentElement;

            var key = getAttribute(wrapper, 'scroll-key');

            addEvent('mousemove', document, moveScroll);
            addEvent('mouseup', document, endScroll);

            // disable scroll event
            removeEvent('scroll', values[key].wrapper);

            values[key].offsetTop = values[key].wrapper.offsetTop;
            values[key].firstY = e.pageY || event.clientY;

            if(!values[key].reposition){
                values[key].reposition = scrollBar.offsetTop;
            }

            currentkey = key;
        },
        moveScroll = function(e){
            var e = e || event;
            // move the cursor position and also change the scrollPosition of the container.
            var key = currentkey; 

            var wrapperScrollTop = values[key].wrapper.scrollTop;
            var ePageY = e.pageY || event.clientY;
            var top = values[key].reposition + ePageY - values[key].firstY;
            top = (top/values[key].wH * 100);
            if(values[key].rP1 < top){
                top = values[key].rP1;
            }
            if(!values[key].previousTop){
                values[key].previousTop = top + 1;
            }
            var blnThreshold = top >= 0 && values[key].firstY > values[key].offsetTop;
            if((values[key].previousTop > top && blnThreshold) || (blnThreshold && (wrapperScrollTop + values[key].wH !== values[key].sH))){
                values[key].scrollBar.style.top = top + "%";
                values[key].previousTop = top;                
                var scrollTop = top * values[key].sH1;
                values[key].wrapper.scrollTop = scrollTop;
                handleScroll(scrollTop,values[key].wrapper);
            }

            values[key].sbc.className = S;
            
        },
        endScroll = function(e){
            var e = e || event;

            var key = currentkey; 

            removeEvent('mousemove', document);
            removeEvent('mouseup', document);

            // setAttribute(values[key].wrapper, 'scroll-reposition', 0);
            values[key].reposition = 0;

            // Enable scroll event
            addEvent('scroll', values[key].wrapper, doScroll);
            values[key].sbc.className = S + a;
        },
        doScroll = function(e){
            var e = e || event;

            var wrapper = e.currentTarget;

            var key = getAttribute(wrapper, 'scroll-key');

            values[key].sbc.className = S;
            var scrollTop = values[key].wrapper.scrollTop;
            var top = scrollTop/values[key].sH * 100;
            values[key].scrollBar.style.top = scrollTop/values[key].sH1 + "%";
            values[key].sbc.className = S + a;
            handleScroll(scrollTop,wrapper);
        },
        addEvent = function(event, element, func){
            element['on' + event] = func;
            // element.addEventListener(event, func, false);
        },
        removeEvent = function(event, element){
            element['on' + event] = null;
            // element.removeEventListener(event, func, false);
        },
        
        handleScroll = function(scrollTop,wrapper) {
        	 var parentElem = wrapper.parentElement;
        	 if(parentElem.hasClassName('trackOrderContentContainer')) {
        	 	var wrapperScrollTop = wrapper.scrollTop;
	        	 var content = wrapper.down('.content');
	        	 var selectedRow = content.select('.selectedOrder')[0];
	        	 var arrowParent = selectedRow.up('.show-orders-list');
	        	 var arrowImage = $(arrowParent).select('.fedexArrowImage')[0];
	        	 var nextRow = $(selectedRow).next();
	        	 var offsetTop = selectedRow.offsetTop;
	        	 var maxLimit = wrapperScrollTop + 190 - 40;
	        	 if(offsetTop < (scrollTop)) {
	        	 	$(nextRow).setStyle({
			        	bottom: '',
			        	
			         });
	        	 	 $(nextRow).setStyle({
			        	top: 0 + 'px',
			        	display: 'block',
			         }); 
			         $(arrowImage).setStyle({
					        top: 56 + 'px'
					 	});
	        	 } else if(150 < (offsetTop-scrollTop)){
	        	 	$(nextRow).setStyle({
			        	top: '',
			         });
			         $(nextRow).setStyle({
			        	bottom: 0 + 'px',
			        	display: 'block',
			         });
			         $(arrowImage).setStyle({
					        top: 201 + 'px'
					 	});
	        	 } else {
	        	 	 $(nextRow).setStyle({
			        	display: 'none',
			         }); 
			         $(arrowImage).setStyle({
						top: offsetTop - scrollTop + 56 + 'px'
					 }); 
	        	 }
        	 }
        };
    return {
        useSlimScroll : useSlimScroll
    };
})();
