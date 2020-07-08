// This file was automatically generated from templateRequestForWorkshops.soy.
// Please don't edit this file by hand.

if (typeof requestForWorkshop == 'undefined') { var requestForWorkshop = {}; }


requestForWorkshop.addVenue = function(opt_data, opt_sb) {
  var output = opt_sb || new soy.StringBuilder();
  output.append('\t<div relId="', soy.$$escapeHtml(opt_data.id), '" class="leftFloat morevenues venuesList" id="venue_', soy.$$escapeHtml(opt_data.id), '"><div class="edfxinptbxrt-sub"><input type="text" data-name="venue" class="borderRadius venueField" tabindex="3"></div><div class="edfxinptbxrt-adlsbx addVenue"></div><div class="edfxinptbxrt-adlsbx deleteVenue"></div></div>');
  if (!opt_sb) return output.toString();
};
