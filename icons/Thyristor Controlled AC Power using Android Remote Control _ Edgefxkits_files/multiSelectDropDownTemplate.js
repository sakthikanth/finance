// This file was automatically generated from multiSelectDropDownTemplate.soy.
// Please don't edit this file by hand.

if (typeof components == 'undefined') { var components = {}; }
if (typeof components.multiCombo == 'undefined') { components.multiCombo = {}; }


components.multiCombo.renderDropdown = function(opt_data, opt_sb) {
  var output = opt_sb || new soy.StringBuilder();
  output.append('\t<div id="', soy.$$escapeHtml(opt_data.listHolderId), 'MultiListBox" class="multiSelectDopdownContainer">');
  var elemList6 = opt_data.elems;
  var elemListLen6 = elemList6.length;
  for (var elemIndex6 = 0; elemIndex6 < elemListLen6; elemIndex6++) {
    var elemData6 = elemList6[elemIndex6];
    output.append('<div id="multiListElem_', soy.$$escapeHtml(elemData6.id), '" class="multiListElems chkbx-rwsp" relId="', soy.$$escapeHtml(elemData6.id), '" relValue="', soy.$$escapeHtml(elemData6.name), '"><input type="checkbox" class="checkboxElem"><label class="dummyCheckBoxLabel"></label><label class="edgefxCompareLbl font_14 textc556  fontOpenReg checkRadioLabel" for="chkdeals">', soy.$$escapeHtml(elemData6.name), '</label></div>');
  }
  output.append('</div>');
  if (!opt_sb) return output.toString();
};
