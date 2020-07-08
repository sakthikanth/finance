// This file was automatically generated from simpleDropDownTemplate.soy.
// Please don't edit this file by hand.

if (typeof components == 'undefined') { var components = {}; }
if (typeof components.simpleCombo == 'undefined') { components.simpleCombo = {}; }


components.simpleCombo.selectCombo = function(opt_data, opt_sb) {
  var output = opt_sb || new soy.StringBuilder();
  output.append('\t<div class="dropdownContainer"><div class="simpleDropDownBody borderRadius"><div id="', soy.$$escapeHtml(opt_data.listHolderId), '_MenuContainer" class="leftFloat ', (opt_data.css.menuIconClass) ? soy.$$escapeHtml(opt_data.css.menuIconClass) : 'simpleDropMenuIcon', '"></div><div class="', (opt_data.css.showBorder) ? (opt_data.css.borderMiddleClass) ? soy.$$escapeHtml(opt_data.css.borderMiddleClass) : 'simpleDropDownMiddle' : '', '"><div class="comboTextHolder leftFloat fontOpenReg font_12 textColor69767d"></div>\t\t\t\t\t\t\t\t<!-- Please do not change the className of this div --></div><div class="leftFloat ', (opt_data.css.dropDownArrowClass) ? soy.$$escapeHtml(opt_data.css.dropDownArrowClass) : 'simpleDropDownArrow', '"></div></div><div id="', soy.$$escapeHtml(opt_data.listHolderId), 'ListBox" class="pAbsolute dropdownItemsHolder borderBottomRadius font_14 fontOpenReg textColor17"></div>\t\t<!-- Please do not change the id of this div --></div>');
  if (!opt_sb) return output.toString();
};
