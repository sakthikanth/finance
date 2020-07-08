document.observe("dom:loaded", function() {
	setBackgroundImages();
	//Resizing main container when window resizing
	window.onresize = function() {
		var windowH = window.innerHeight;
		var edgefxContainer = $$("body")[0].select('.edgefxContainer');
		edgefxContainer[0].setStyle({height:windowH + 'px'});
		setBackgroundImages();
		coupon.resize();
	};

	if(window.location.hash){
		window.location.href = window.location.href;
	}
});
function setBackgroundImages(){
	//Setting window height to main container
	var windowH = window.innerHeight;
	var edgefxContainer = $$("body")[0].select('.edgefxContainer');
	edgefxContainer[0].setStyle({height:windowH + 'px'});
	var middleContentW = 960;
	var remainingW = (window.innerWidth - middleContentW)/2;
	var headerBackgroundImageW = 422;
	var footerBottomBackgroundImageW = 340;
	var contentBackgroundImageW = 249;
	var footerBackgroundTopRightImgW = 225;
	var headerElem = $$("body")[0].select('.edgefxHeaderBackground');
	setBackgroundImageWidth(headerElem, remainingW, headerBackgroundImageW);
	var footerBottomImage = $$("body")[0].select('.edgefxFooterBackgroundImage');
	setBackgroundImageWidth(footerBottomImage, remainingW, footerBottomBackgroundImageW);
	var contentBackgroundImage = $$("body")[0].select('.edgefxContentBackground');
	setBackgroundImageWidth(contentBackgroundImage, remainingW, contentBackgroundImageW);
	var footerTopImage = $$("body")[0].select('.footerBackgroundTopRightImg');
	setBackgroundImageWidth(footerTopImage, remainingW, footerBackgroundTopRightImgW);
	
	};
function setBackgroundImageWidth(elem, remainingW, elemW) {
	var fitWidth;
	for (var i = 0; i < elem.length; i++) {
		if (remainingW >= elemW) {
			fitWidth = elemW;
		} else {
			fitWidth = remainingW;
		}
		elem[i].setStyle({width:fitWidth + 'px'});
	}
};

function hidePopupsOnBodyClick() {
	var sb = new SandBox();
	
	//minimize workshop popup
	workshops.minimizeonPopup();
	
	//hide dropdown holder if opened
	sb.hideElements($$('.dropdownItemsHolder'));
}

function removeHTTP(url) {
	if(typeof url === 'string'){
		return url.replace(/^http[s]?:/, '');
	}else{
		return url;
	}	
}
