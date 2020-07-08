// This file was automatically generated from soy-templates.soy.
// Please don't edit this file by hand.

if (typeof edgefx == 'undefined') { var edgefx = {}; }


edgefx.sliderPages = function(opt_data, opt_sb) {
  var output = opt_sb || new soy.StringBuilder();
  output.append('<div class="sliderPages">');
  var iLimit4 = opt_data.pages;
  for (var i4 = 0; i4 < iLimit4; i4++) {
    output.append('<div class="sliderPageNode leftFloat curPointer" rel="', soy.$$escapeHtml(i4), '">', (i4 == opt_data.activeNode) ? '<img width="10px" height="10px" src="' + soy.$$escapeHtml(opt_data.imageBaseUrl) + 'skinning-images/assets/pageNavActive.png"/>' : '<img width="10px" height="10px" src="' + soy.$$escapeHtml(opt_data.imageBaseUrl) + 'skinning-images/assets/pageNavNormal.png"/>', '</div>');
  }
  output.append('</div>');
  if (!opt_sb) return output.toString();
};


edgefx.popUpLayoutTemplate = function(opt_data, opt_sb) {
  var output = opt_sb || new soy.StringBuilder();
  output.append('\t<div class="', soy.$$escapeHtml(opt_data.popupVarCls[0]), ' edgefxpopupContainer borderBottomRadius pRelative">', (opt_data.titleText != '') ? '<div class="edgefxpopupHeader borderTopRadius"><div class="edgefxpopupTitle fontOpenBold font_15 textColorEAF3F3 leftFloat textEllipsisCls ' + soy.$$escapeHtml(opt_data.popupVarCls[1]) + '" title="' + soy.$$escapeHtml(opt_data.titleText) + '">' + soy.$$escapeHtml(opt_data.titleText) + '</div><div class="popUpCloseIcon edgefxpopupCloseHolder curPointer rightFloat cart-popup-close-button"></div></div>' : '', '<div class="overFlowHide borderBottomRadius pRelative clrBoth screenLoaderHolder" style="min-height:', soy.$$escapeHtml(opt_data.minH), ';width:100%;background-color:#FFFFFF;"></div></div>');
  if (!opt_sb) return output.toString();
};
