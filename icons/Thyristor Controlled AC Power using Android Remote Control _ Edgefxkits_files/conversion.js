(function(){var g=this,l=function(a){return"string"==typeof a},aa=function(a,b,c){return a.call.apply(a.bind,arguments)},ba=function(a,b,c){if(!a)throw Error();if(2<arguments.length){var d=Array.prototype.slice.call(arguments,2);return function(){var c=Array.prototype.slice.call(arguments);Array.prototype.unshift.apply(c,d);return a.apply(b,c)}}return function(){return a.apply(b,arguments)}},m=function(a,b,c){m=Function.prototype.bind&&-1!=Function.prototype.bind.toString().indexOf("native code")?aa:ba;return m.apply(null,
arguments)},ca=Date.now||function(){return+new Date};var p=function(){var a=!1;try{var b=Object.defineProperty({},"passive",{get:function(){a=!0}});window.addEventListener("test",null,b)}catch(c){}return a}(),da=function(a,b,c){a.addEventListener?a.addEventListener(b,c,p?void 0:!1):a.attachEvent&&a.attachEvent("on"+b,c)};var q=function(a){return{visible:1,hidden:2,prerender:3,preview:4}[a.webkitVisibilityState||a.mozVisibilityState||a.visibilityState||""]||0},ea=function(a){var b;a.mozVisibilityState?b="mozvisibilitychange":a.webkitVisibilityState?b="webkitvisibilitychange":a.visibilityState&&(b="visibilitychange");return b},t=function(a,b){if(3==q(b))return!1;a();return!0},fa=function(a,b){if(!t(a,b)){var c=!1,d=ea(b),e=function(){if(!c&&t(a,b)){c=!0;var f=e;b.removeEventListener?b.removeEventListener(d,f,p?void 0:
!1):b.detachEvent&&b.detachEvent("on"+d,f)}};d&&da(b,d,e)}};var u=function(a){a=parseFloat(a);return isNaN(a)||1<a||0>a?0:a};var ga=u("0.20"),ha=u("0.01");var ia=/^true$/.test("false")?!0:!1;var v=String.prototype.trim?function(a){return a.trim()}:function(a){return a.replace(/^[\s\xa0]+|[\s\xa0]+$/g,"")},x=function(a,b){return a<b?-1:a>b?1:0};var ja=Array.prototype.indexOf?function(a,b,c){return Array.prototype.indexOf.call(a,b,c)}:function(a,b,c){c=null==c?0:0>c?Math.max(0,a.length+c):c;if(l(a))return l(b)&&1==b.length?a.indexOf(b,c):-1;for(;c<a.length;c++)if(c in a&&a[c]===b)return c;return-1},ka=Array.prototype.filter?function(a,b,c){return Array.prototype.filter.call(a,b,c)}:function(a,b,c){for(var d=a.length,e=[],f=0,h=l(a)?a.split(""):a,k=0;k<d;k++)if(k in h){var r=h[k];b.call(c,r,k,a)&&(e[f++]=r)}return e},la=Array.prototype.map?
function(a,b,c){return Array.prototype.map.call(a,b,c)}:function(a,b,c){for(var d=a.length,e=Array(d),f=l(a)?a.split(""):a,h=0;h<d;h++)h in f&&(e[h]=b.call(c,f[h],h,a));return e},ma=function(a){return Array.prototype.concat.apply(Array.prototype,arguments)};var y=function(a){var b=[],c=0,d;for(d in a)b[c++]=a[d];return b};var z;a:{var A=g.navigator;if(A){var B=A.userAgent;if(B){z=B;break a}}z=""};var C=function(a){C[" "](a);return a};C[" "]=function(){};var oa=function(a,b){var c=na;Object.prototype.hasOwnProperty.call(c,a)||(c[a]=b(a))};var pa=-1!=z.indexOf("Opera"),D=-1!=z.indexOf("Trident")||-1!=z.indexOf("MSIE"),sa=-1!=z.indexOf("Edge"),E=-1!=z.indexOf("Gecko")&&!(-1!=z.toLowerCase().indexOf("webkit")&&-1==z.indexOf("Edge"))&&!(-1!=z.indexOf("Trident")||-1!=z.indexOf("MSIE"))&&-1==z.indexOf("Edge"),ta=-1!=z.toLowerCase().indexOf("webkit")&&-1==z.indexOf("Edge"),F=function(){var a=g.document;return a?a.documentMode:void 0},G;
a:{var H="",I=function(){var a=z;if(E)return/rv\:([^\);]+)(\)|;)/.exec(a);if(sa)return/Edge\/([\d\.]+)/.exec(a);if(D)return/\b(?:MSIE|rv)[: ]([^\);]+)(\)|;)/.exec(a);if(ta)return/WebKit\/(\S+)/.exec(a);if(pa)return/(?:Version)[ \/]?(\S+)/.exec(a)}();I&&(H=I?I[1]:"");if(D){var J=F();if(null!=J&&J>parseFloat(H)){G=String(J);break a}}G=H}
var K=G,na={},ua=function(a){oa(a,function(){for(var b=0,c=v(String(K)).split("."),d=v(String(a)).split("."),e=Math.max(c.length,d.length),f=0;0==b&&f<e;f++){var h=c[f]||"",k=d[f]||"";do{h=/(\d*)(\D*)(.*)/.exec(h)||["","","",""];k=/(\d*)(\D*)(.*)/.exec(k)||["","","",""];if(0==h[0].length&&0==k[0].length)break;b=x(0==h[1].length?0:parseInt(h[1],10),0==k[1].length?0:parseInt(k[1],10))||x(0==h[2].length,0==k[2].length)||x(h[2],k[2]);h=h[3];k=k[3]}while(0==b)}return 0<=b})},va;var wa=g.document;
va=wa&&D?F()||("CSS1Compat"==wa.compatMode?parseInt(K,10):5):void 0;var L;if(!(L=!E&&!D)){var M;if(M=D)M=9<=Number(va);L=M}L||E&&ua("1.9.1");D&&ua("9");var N=function(a){try{var b;if(b=!!a&&null!=a.location.href)a:{try{C(a.foo);b=!0;break a}catch(c){}b=!1}return b}catch(c){return!1}},xa=function(a,b){for(var c in a)Object.prototype.hasOwnProperty.call(a,c)&&b.call(void 0,a[c],c,a)};var ya=document;var za=!!window.google_async_iframe_id,O=za&&window.parent||window;var Aa=function(a,b,c){for(;0<=(b=a.indexOf("fmt",b))&&b<c;){var d=a.charCodeAt(b-1);if(38==d||63==d)if(d=a.charCodeAt(b+3),!d||61==d||38==d||35==d)return b;b+=4}return-1},Ba=/#|$/,Ca=/[?&]($|#)/;var Q=function(a){Da();this.enabled=Math.random()<a;this.i=[]},Da=g.performance&&g.performance.now?m(g.performance.now,g.performance):ca;Q.prototype.install=function(a){a=a||window;a.google_js_reporting_queue=a.google_js_reporting_queue||[];this.i=a.google_js_reporting_queue};Q.prototype.disable=function(){this.i.length=0;this.enabled=!1};(new Q(1)).install(function(){if(za&&!N(O)){var a="."+ya.domain;try{for(;2<a.split(".").length&&!N(O);)ya.domain=a=a.substr(a.indexOf(".")+1),O=window.parent}catch(b){}N(O)||(O=window)}return O}());var Ea=function(){this.h={};this.a={};this.j=!1;for(var a=[2,3],b=0,c=a.length;b<c;++b)this.a[a[b]]=""},Fa=function(){try{var a=window.top.location.hash;if(a){var b=a.match(/\bdeid=([\d,]+)/);return b&&b[1]||""}}catch(c){}return""},Ga=function(a,b,c){var d=R;if(!d.j&&(c?d.a.hasOwnProperty(c)&&""==d.a[c]:1)){var e;if(e=(e=Fa().match(new RegExp("\\b("+a.join("|")+")\\b")))&&e[0]||null)a=e;else a:{if(!(1E-4>Math.random())&&(e=Math.random(),e<b)){b=window;try{var f=new Uint32Array(1);b.crypto.getRandomValues(f);
e=f[0]/65536/65536}catch(h){e=Math.random()}a=a[Math.floor(e*a.length)];break a}a=null}a&&""!=a&&(c?d.a.hasOwnProperty(c)&&(d.a[c]=a):d.h[a]=!0)}},Ha=function(a){var b=R;return b.a.hasOwnProperty(a)?b.a[a]:""},Ia=function(){var a=R,b=[];xa(a.h,function(a,d){b.push(d)});xa(a.a,function(a){""!=a&&b.push(a)});return b};var R,S="google_conversion_id google_conversion_format google_conversion_type google_conversion_order_id google_conversion_language google_conversion_value google_conversion_currency google_conversion_domain google_conversion_label google_conversion_color google_disable_viewthrough google_enable_display_cookie_match google_remarketing_only google_remarketing_for_search google_conversion_items google_custom_params google_conversion_date google_conversion_time google_conversion_js_version onload_callback opt_image_generator google_conversion_page_url google_conversion_referrer_url".split(" "),
T=["google_conversion_first_time","google_conversion_snippets"];function U(a){return null!=a?encodeURIComponent(a.toString()):""}function Ja(a){return null!=a?a.toString().substring(0,512):""}function V(a,b){b=U(b);return""!=b&&(a=U(a),""!=a)?"&".concat(a,"=",b):""}function W(a){var b=typeof a;return null==a||"object"==b||"function"==b?null:String(a).replace(/,/g,"\\,").replace(/;/g,"\\;").replace(/=/g,"\\=")}
function Ka(a){var b;if((a=a.google_custom_params)&&"object"==typeof a&&"function"!=typeof a.join){var c=[];for(b in a)if(Object.prototype.hasOwnProperty.call(a,b)){var d=a[b];if(d&&"function"==typeof d.join){for(var e=[],f=0;f<d.length;++f){var h=W(d[f]);null!=h&&e.push(h)}d=0==e.length?null:e.join(",")}else d=W(d);(e=W(b))&&null!=d&&c.push(e+"="+d)}b=c.join(";")}else b="";return""==b?"":"&".concat("data=",encodeURIComponent(b))}
function X(a){return"number"!=typeof a&&"string"!=typeof a?"":U(a.toString())}function La(a){if(!a)return"";a=a.google_conversion_items;if(!a)return"";for(var b=[],c=0,d=a.length;c<d;c++){var e=a[c],f=[];e&&(f.push(X(e.value)),f.push(X(e.quantity)),f.push(X(e.item_id)),f.push(X(e.adwords_grouping)),f.push(X(e.sku)),b.push("("+f.join("*")+")"))}return 0<b.length?"&item="+b.join(""):""}
function Ma(a,b,c){var d=[];if(a){var e=a.screen;e&&(d.push(V("u_h",e.height)),d.push(V("u_w",e.width)),d.push(V("u_ah",e.availHeight)),d.push(V("u_aw",e.availWidth)),d.push(V("u_cd",e.colorDepth)));a.history&&d.push(V("u_his",a.history.length))}c&&"function"==typeof c.getTimezoneOffset&&d.push(V("u_tz",-c.getTimezoneOffset()));b&&("function"==typeof b.javaEnabled&&d.push(V("u_java",b.javaEnabled())),b.plugins&&d.push(V("u_nplug",b.plugins.length)),b.mimeTypes&&d.push(V("u_nmime",b.mimeTypes.length)));
return d.join("")}function Na(a){a=a?a.title:"";if(void 0==a||""==a)return"";var b=function(a){try{return decodeURIComponent(a),!0}catch(e){return!1}};a=encodeURIComponent(a);for(var c=256;!b(a.substr(0,c));)c--;return"&tiba="+a.substr(0,c)}function Oa(a,b,c,d){var e="";if(b){var f;f=a.top==a?0:(f=a.location.ancestorOrigins)?f[f.length-1]==a.location.origin?1:2:N(a.top)?1:2;a=c?c:1==f?a.top.location.href:a.location.href;e+=V("frm",f);e+=V("url",Ja(a));e+=V("ref",Ja(d||b.referrer))}return e}
function Y(a,b){return!(ia||b&&Pa.test(navigator.userAgent))||a&&a.location&&a.location.protocol&&"https:"==a.location.protocol.toString().toLowerCase()?"https:":"http:"}function Qa(a,b,c){c=c.google_remarketing_only?"googleads.g.doubleclick.net":c.google_conversion_domain||"www.googleadservices.com";return Y(a,/www[.]googleadservices[.]com/i.test(c))+"//"+c+"/pagead/"+b}
function Ra(a,b,c,d){var e="/?";"landing"==d.google_conversion_type&&(e="/extclk?");var e=Qa(a,[d.google_remarketing_only?"viewthroughconversion/":"conversion/",U(d.google_conversion_id),e,"random=",U(d.google_conversion_time)].join(""),d),f;a:{f=d.google_conversion_language;if(null!=f){f=f.toString();if(2==f.length){f=V("hl",f);break a}if(5==f.length){f=V("hl",f.substring(0,2))+V("gl",f.substring(3,5));break a}}f=""}a=[V("cv",d.google_conversion_js_version),V("fst",d.google_conversion_first_time),
V("num",d.google_conversion_snippets),V("fmt",d.google_conversion_format),V("value",d.google_conversion_value),V("currency_code",d.google_conversion_currency),V("label",d.google_conversion_label),V("oid",d.google_conversion_order_id),V("bg",d.google_conversion_color),f,V("guid","ON"),V("disvt",d.google_disable_viewthrough),V("eid",Ia().join()),La(d),Ma(a,b,d.google_conversion_date),Ka(d),Oa(a,c,d.google_conversion_page_url,d.google_conversion_referrer_url),d.google_remarketing_for_search&&!d.google_conversion_domain?
"&srr=n":"",Na(c)].join("")+Sa();return e+a}var Ta=function(a,b,c,d,e,f){return'<iframe name="'+a+'" title="'+b+'" width="'+d+'" height="'+e+'" src="'+c+'" frameborder="0" marginwidth="0" marginheight="0" vspace="0" hspace="0" allowtransparency="true"'+(f?' style="display:none"':"")+' scrolling="no"></iframe>'};
function Ua(a){return{ar:1,bg:1,cs:1,da:1,de:1,el:1,en_AU:1,en_US:1,en_GB:1,es:1,et:1,fi:1,fr:1,hi:1,hr:1,hu:1,id:1,is:1,it:1,iw:1,ja:1,ko:1,lt:1,nl:1,no:1,pl:1,pt_BR:1,pt_PT:1,ro:1,ru:1,sk:1,sl:1,sr:1,sv:1,th:1,tl:1,tr:1,vi:1,zh_CN:1,zh_TW:1}[a]?a+".html":"en_US.html"}
var Z={g:{c:"27391101",b:"27391102"},f:{c:"376635470",b:"376635471"}},Sa=function(){var a=ma.apply([],la(y(Z),function(a){return y(a)},void 0)),b=ka(Fa().split(","),function(b){return""!=b&&!(0<=ja(a,b))});return 0<b.length?"&debug_experiment_id="+b.join(","):""},Pa=/Android ([01]\.|2\.[01])/i,Va=function(){var a=Z.g;R&&Ga([a.c,a.b],ha,3)},Wa=function(a,b){if(!b.google_remarketing_only||!b.google_enable_display_cookie_match||(R?Ha(2):"")!=Z.f.b)return"";a=Y(a,!1)+"//bid.g.doubleclick.net/xbbe/pixel?d=KAE";
return Ta("google_cookie_match_frame","Google cookie match frame",a,1,1,!0)};
function Xa(a,b,c,d){var e="";d.google_remarketing_only&&d.google_enable_display_cookie_match&&(R&&Ga([Z.f.c,Z.f.b],ga,2),e=Wa(a,d));3!=d.google_conversion_format||d.google_remarketing_only||d.google_conversion_domain||Va();b=Ra(a,b,c,d);var f=function(a,b,c,d){return'<img height="'+c+'" width="'+b+'" border="0" alt="" src="'+a+'"'+(d?' style="display:none"':"")+" />"};return 0==d.google_conversion_format&&null==d.google_conversion_domain?'<a href="'+(Y(a,!1)+"//services.google.com/sitestats/"+Ua(d.google_conversion_language)+
"?cid="+U(d.google_conversion_id))+'" target="_blank">'+f(b,135,27,!1)+"</a>"+e:1<d.google_conversion_snippets||3==d.google_conversion_format?Ya(c,b)?e:f(b,1,1,!0)+e:Ta("google_conversion_frame","Google conversion frame",b,2==d.google_conversion_format?200:300,2==d.google_conversion_format?26:13,!1)+e}function Za(){return new Image}
function Ya(a,b){if((R?Ha(3):"")==Z.g.b)try{var c;var d;var e=b.search(Ba),f=Aa(b,0,e);if(0>f)d=null;else{var h=b.indexOf("&",f);if(0>h||h>e)h=e;f+=4;d=decodeURIComponent(b.substr(f,h-f).replace(/\+/g," "))}if(3!=d)c=!1;else{var k=b.search(Ba);d=0;for(var r,e=[];0<=(r=Aa(b,d,k));)e.push(b.substring(d,r)),d=Math.min(b.indexOf("&",r)+1||k,k);e.push(b.substr(d));var n=[e.join("").replace(Ca,"$1"),"&","fmt"];n.push("=",encodeURIComponent("4"));if(n[1]){var w=n[0],P=w.indexOf("#");0<=P&&(n.push(w.substr(P)),
n[0]=w=w.substr(0,P));var qa=w.indexOf("?");0>qa?n[1]="?":qa==w.length-1&&(n[1]=void 0)}var ra=a.createElement("script");ra.src=n.join("");a.getElementsByTagName("script")[0].parentElement.appendChild(ra);c=!0}return c}catch(fb){}return!1}function $a(a,b){var c=a.opt_image_generator&&a.opt_image_generator.call;b+=V("async","1");var d=Za;c&&(d=a.opt_image_generator);a=d();a.src=b;a.onload=function(){}}
function ab(a,b,c){var d;d=[U(c.google_conversion_id),"/?random=",Math.floor(1E9*Math.random())].join("");d=Y(a,!1)+"//www.google.com/ads/user-lists/"+d;d+=[V("label",c.google_conversion_label),V("fmt","3"),Oa(a,b,c.google_conversion_page_url,c.google_conversion_referrer_url)].join("");$a(c,d)}
function bb(a){if("landing"==a.google_conversion_type||!a.google_conversion_id||a.google_remarketing_only&&a.google_disable_viewthrough)return!1;a.google_conversion_date=new Date;a.google_conversion_time=a.google_conversion_date.getTime();a.google_conversion_snippets="number"==typeof a.google_conversion_snippets&&0<a.google_conversion_snippets?a.google_conversion_snippets+1:1;"number"!=typeof a.google_conversion_first_time&&(a.google_conversion_first_time=a.google_conversion_time);a.google_conversion_js_version=
"8";0!=a.google_conversion_format&&1!=a.google_conversion_format&&2!=a.google_conversion_format&&3!=a.google_conversion_format&&(a.google_conversion_format=1);!1!==a.google_enable_display_cookie_match&&(a.google_enable_display_cookie_match=!0);R=new Ea;return!0}function cb(a){for(var b=0;b<S.length;b++)a[S[b]]=null}function db(a){for(var b={},c=0;c<S.length;c++)b[S[c]]=a[S[c]];for(c=0;c<T.length;c++)b[T[c]]=a[T[c]];return b}
function eb(a){var b=document.getElementsByTagName("head")[0];b||(b=document.createElement("head"),document.getElementsByTagName("html")[0].insertBefore(b,document.getElementsByTagName("body")[0]));var c=document.createElement("script");c.src=Qa(window,"conversion_debug_overlay.js",a);b.appendChild(c)};(function(a,b,c){if(a)if(null!=/[\?&;]google_debug/.exec(document.URL))eb(a);else{try{if(bb(a))if(3==q(c)){var d=db(a),e="google_conversion_"+Math.floor(1E9*Math.random());c.write('<span id="'+e+'"></span>');fa(function(){try{var f=c.getElementById(e);f&&(f.innerHTML=Xa(a,b,c,d),d.google_remarketing_for_search&&!d.google_conversion_domain&&ab(a,c,d))}catch(h){}},c)}else c.write(Xa(a,b,c,a)),a.google_remarketing_for_search&&!a.google_conversion_domain&&ab(a,c,a)}catch(f){}cb(a)}})(window,navigator,
document);}).call(this);
