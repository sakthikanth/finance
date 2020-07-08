(function(){var m,n=this;function p(a){a=a.split(".");for(var b=n,c;c=a.shift();)if(null!=b[c])b=b[c];else return null;return b}
function aa(){}
function ba(a){a.R=void 0;a.A=function(){return a.R?a.R:a.R=new a}}
function ca(a){var b=typeof a;if("object"==b)if(a){if(a instanceof Array)return"array";if(a instanceof Object)return b;var c=Object.prototype.toString.call(a);if("[object Window]"==c)return"object";if("[object Array]"==c||"number"==typeof a.length&&"undefined"!=typeof a.splice&&"undefined"!=typeof a.propertyIsEnumerable&&!a.propertyIsEnumerable("splice"))return"array";if("[object Function]"==c||"undefined"!=typeof a.call&&"undefined"!=typeof a.propertyIsEnumerable&&!a.propertyIsEnumerable("call"))return"function"}else return"null";
else if("function"==b&&"undefined"==typeof a.call)return"object";return b}
function da(a){var b=ca(a);return"array"==b||"object"==b&&"number"==typeof a.length}
function r(a){return"string"==typeof a}
function ea(a){return"function"==ca(a)}
function fa(a){var b=typeof a;return"object"==b&&null!=a||"function"==b}
var ga="closure_uid_"+(1E9*Math.random()>>>0),ja=0;function ka(a,b,c){return a.call.apply(a.bind,arguments)}
function la(a,b,c){if(!a)throw Error();if(2<arguments.length){var d=Array.prototype.slice.call(arguments,2);return function(){var c=Array.prototype.slice.call(arguments);Array.prototype.unshift.apply(c,d);return a.apply(b,c)}}return function(){return a.apply(b,arguments)}}
function t(a,b,c){t=Function.prototype.bind&&-1!=Function.prototype.bind.toString().indexOf("native code")?ka:la;return t.apply(null,arguments)}
function ma(a,b){var c=Array.prototype.slice.call(arguments,1);return function(){var b=c.slice();b.push.apply(b,arguments);return a.apply(this,b)}}
var na=Date.now||function(){return+new Date};
function u(a,b){var c=a.split("."),d=n;c[0]in d||!d.execScript||d.execScript("var "+c[0]);for(var e;c.length&&(e=c.shift());)c.length||void 0===b?d[e]?d=d[e]:d=d[e]={}:d[e]=b}
function v(a,b){function c(){}
c.prototype=b.prototype;a.T=b.prototype;a.prototype=new c;a.prototype.constructor=a;a.La=function(a,c,f){for(var d=Array(arguments.length-2),e=2;e<arguments.length;e++)d[e-2]=arguments[e];return b.prototype[c].apply(a,d)}}
;var oa;var pa=String.prototype.trim?function(a){return a.trim()}:function(a){return a.replace(/^[\s\xa0]+|[\s\xa0]+$/g,"")};
function qa(a,b){return a<b?-1:a>b?1:0}
;var sa=Array.prototype.indexOf?function(a,b,c){return Array.prototype.indexOf.call(a,b,c)}:function(a,b,c){c=null==c?0:0>c?Math.max(0,a.length+c):c;
if(r(a))return r(b)&&1==b.length?a.indexOf(b,c):-1;for(;c<a.length;c++)if(c in a&&a[c]===b)return c;return-1},w=Array.prototype.forEach?function(a,b,c){Array.prototype.forEach.call(a,b,c)}:function(a,b,c){for(var d=a.length,e=r(a)?a.split(""):a,f=0;f<d;f++)f in e&&b.call(c,e[f],f,a)},ta=Array.prototype.filter?function(a,b,c){return Array.prototype.filter.call(a,b,c)}:function(a,b,c){for(var d=a.length,e=[],f=0,g=r(a)?a.split(""):a,k=0;k<d;k++)if(k in g){var h=g[k];
b.call(c,h,k,a)&&(e[f++]=h)}return e},ua=Array.prototype.map?function(a,b,c){return Array.prototype.map.call(a,b,c)}:function(a,b,c){for(var d=a.length,e=Array(d),f=r(a)?a.split(""):a,g=0;g<d;g++)g in f&&(e[g]=b.call(c,f[g],g,a));
return e},va=Array.prototype.some?function(a,b,c){return Array.prototype.some.call(a,b,c)}:function(a,b,c){for(var d=a.length,e=r(a)?a.split(""):a,f=0;f<d;f++)if(f in e&&b.call(c,e[f],f,a))return!0;
return!1};
function wa(a,b){var c;a:{c=a.length;for(var d=r(a)?a.split(""):a,e=0;e<c;e++)if(e in d&&b.call(void 0,d[e],e,a)){c=e;break a}c=-1}return 0>c?null:r(a)?a.charAt(c):a[c]}
function xa(a,b){return 0<=sa(a,b)}
function ya(a){return Array.prototype.concat.apply(Array.prototype,arguments)}
function za(a){var b=a.length;if(0<b){for(var c=Array(b),d=0;d<b;d++)c[d]=a[d];return c}return[]}
function Aa(a,b){for(var c=1;c<arguments.length;c++){var d=arguments[c];if(da(d)){var e=a.length||0,f=d.length||0;a.length=e+f;for(var g=0;g<f;g++)a[e+g]=d[g]}else a.push(d)}}
function Ba(a,b,c,d){return Array.prototype.splice.apply(a,Ca(arguments,1))}
function Ca(a,b,c){return 2>=arguments.length?Array.prototype.slice.call(a,b):Array.prototype.slice.call(a,b,c)}
;function Da(a){if(a.classList)return a.classList;a=a.className;return r(a)&&a.match(/\S+/g)||[]}
function Ea(a,b){return a.classList?a.classList.contains(b):xa(Da(a),b)}
function Fa(a,b){a.classList?a.classList.add(b):Ea(a,b)||(a.className+=0<a.className.length?" "+b:b)}
function Ga(a,b){a.classList?a.classList.remove(b):Ea(a,b)&&(a.className=ta(Da(a),function(a){return a!=b}).join(" "))}
function Ha(a,b,c){c?Fa(a,b):Ga(a,b)}
;function Ia(a,b){for(var c in a)b.call(void 0,a[c],c,a)}
function Ja(a,b){var c={},d;for(d in a)c[d]=b.call(void 0,a[d],d,a);return c}
function Ka(a){var b=La,c;for(c in b)if(a.call(void 0,b[c],c,b))return c}
var Ma="constructor hasOwnProperty isPrototypeOf propertyIsEnumerable toLocaleString toString valueOf".split(" ");function Na(a,b){for(var c,d,e=1;e<arguments.length;e++){d=arguments[e];for(c in d)a[c]=d[c];for(var f=0;f<Ma.length;f++)c=Ma[f],Object.prototype.hasOwnProperty.call(d,c)&&(a[c]=d[c])}}
;var Oa;a:{var Pa=n.navigator;if(Pa){var Qa=Pa.userAgent;if(Qa){Oa=Qa;break a}}Oa=""}function x(a){return-1!=Oa.indexOf(a)}
;function Ra(){}
;function y(a,b){this.i=void 0!==a?a:0;this.j=void 0!==b?b:0}
y.prototype.equals=function(a){return a instanceof y&&(this==a?!0:this&&a?this.i==a.i&&this.j==a.j:!1)};
y.prototype.ceil=function(){this.i=Math.ceil(this.i);this.j=Math.ceil(this.j);return this};
y.prototype.floor=function(){this.i=Math.floor(this.i);this.j=Math.floor(this.j);return this};
y.prototype.round=function(){this.i=Math.round(this.i);this.j=Math.round(this.j);return this};function Sa(a,b){this.width=a;this.height=b}
m=Sa.prototype;m.aspectRatio=function(){return this.width/this.height};
m.isEmpty=function(){return!(this.width*this.height)};
m.ceil=function(){this.width=Math.ceil(this.width);this.height=Math.ceil(this.height);return this};
m.floor=function(){this.width=Math.floor(this.width);this.height=Math.floor(this.height);return this};
m.round=function(){this.width=Math.round(this.width);this.height=Math.round(this.height);return this};function Ta(a,b){var c=Ua;return Object.prototype.hasOwnProperty.call(c,a)?c[a]:c[a]=b(a)}
;var Va=x("Opera"),z=x("Trident")||x("MSIE"),Wa=x("Edge"),Xa=x("Gecko")&&!(-1!=Oa.toLowerCase().indexOf("webkit")&&!x("Edge"))&&!(x("Trident")||x("MSIE"))&&!x("Edge"),Ya=-1!=Oa.toLowerCase().indexOf("webkit")&&!x("Edge"),Za=x("Windows");function $a(){var a=n.document;return a?a.documentMode:void 0}
var ab;a:{var bb="",cb=function(){var a=Oa;if(Xa)return/rv\:([^\);]+)(\)|;)/.exec(a);if(Wa)return/Edge\/([\d\.]+)/.exec(a);if(z)return/\b(?:MSIE|rv)[: ]([^\);]+)(\)|;)/.exec(a);if(Ya)return/WebKit\/(\S+)/.exec(a);if(Va)return/(?:Version)[ \/]?(\S+)/.exec(a)}();
cb&&(bb=cb?cb[1]:"");if(z){var db=$a();if(null!=db&&db>parseFloat(bb)){ab=String(db);break a}}ab=bb}var eb=ab,Ua={};
function fb(a){return Ta(a,function(){for(var b=0,c=pa(String(eb)).split("."),d=pa(String(a)).split("."),e=Math.max(c.length,d.length),f=0;0==b&&f<e;f++){var g=c[f]||"",k=d[f]||"";do{g=/(\d*)(\D*)(.*)/.exec(g)||["","","",""];k=/(\d*)(\D*)(.*)/.exec(k)||["","","",""];if(0==g[0].length&&0==k[0].length)break;b=qa(0==g[1].length?0:parseInt(g[1],10),0==k[1].length?0:parseInt(k[1],10))||qa(0==g[2].length,0==k[2].length)||qa(g[2],k[2]);g=g[3];k=k[3]}while(0==b)}return 0<=b})}
var gb;var hb=n.document;gb=hb&&z?$a()||("CSS1Compat"==hb.compatMode?parseInt(eb,10):5):void 0;!Xa&&!z||z&&9<=Number(gb)||Xa&&fb("1.9.1");var jb=z&&!fb("9");function kb(a){return a?new lb(mb(a)):oa||(oa=new lb)}
function A(a){var b=document;return r(a)?b.getElementById(a):a}
function nb(a){var b=document;return b.querySelectorAll&&b.querySelector?b.querySelectorAll("."+a):ob(a,void 0)}
function ob(a,b){var c,d,e,f;c=document;c=b||c;if(c.querySelectorAll&&c.querySelector&&a)return c.querySelectorAll(""+(a?"."+a:""));if(a&&c.getElementsByClassName){var g=c.getElementsByClassName(a);return g}g=c.getElementsByTagName("*");if(a){f={};for(d=e=0;c=g[d];d++){var k=c.className;"function"==typeof k.split&&xa(k.split(/\s+/),a)&&(f[e++]=c)}f.length=e;return f}return g}
function pb(a){return"CSS1Compat"==a.compatMode}
function mb(a){return 9==a.nodeType?a:a.ownerDocument||a.document}
function qb(a,b){if("textContent"in a)a.textContent=b;else if(3==a.nodeType)a.data=b;else if(a.firstChild&&3==a.firstChild.nodeType){for(;a.lastChild!=a.firstChild;)a.removeChild(a.lastChild);a.firstChild.data=b}else{for(var c;c=a.firstChild;)a.removeChild(c);a.appendChild(mb(a).createTextNode(String(b)))}}
var rb={SCRIPT:1,STYLE:1,HEAD:1,IFRAME:1,OBJECT:1},sb={IMG:" ",BR:"\n"};function tb(a){if(jb&&null!==a&&"innerText"in a)a=a.innerText.replace(/(\r\n|\r|\n)/g,"\n");else{var b=[];ub(a,b,!0);a=b.join("")}a=a.replace(/ \xAD /g," ").replace(/\xAD/g,"");a=a.replace(/\u200B/g,"");jb||(a=a.replace(/ +/g," "));" "!=a&&(a=a.replace(/^\s*/,""));return a}
function ub(a,b,c){if(!(a.nodeName in rb))if(3==a.nodeType)c?b.push(String(a.nodeValue).replace(/(\r\n|\r|\n)/g,"")):b.push(a.nodeValue);else if(a.nodeName in sb)b.push(sb[a.nodeName]);else for(a=a.firstChild;a;)ub(a,b,c),a=a.nextSibling}
function vb(a){var b=wb.ma;return b?xb(a,function(a){return!b||r(a.className)&&xa(a.className.split(/\s+/),b)},!0,void 0):null}
function xb(a,b,c,d){a&&!c&&(a=a.parentNode);for(c=0;a&&(null==d||c<=d);){if(b(a))return a;a=a.parentNode;c++}return null}
function lb(a){this.b=a||n.document||document}
lb.prototype.getElementsByTagName=function(a,b){return(b||this.b).getElementsByTagName(String(a))};
lb.prototype.createElement=function(a){return this.b.createElement(String(a))};
lb.prototype.isElement=function(a){return fa(a)&&1==a.nodeType};function yb(a,b,c){this.l=c;this.g=a;this.o=b;this.f=0;this.b=null}
yb.prototype.get=function(){var a;0<this.f?(this.f--,a=this.b,this.b=a.next,a.next=null):a=this.g();return a};var zb=window.yt&&window.yt.config_||window.ytcfg&&window.ytcfg.data_||{};u("yt.config_",zb);u("yt.tokens_",window.yt&&window.yt.tokens_||{});var Ab=window.yt&&window.yt.msgs_||p("window.ytcfg.msgs")||{};u("yt.msgs_",Ab);function Bb(a){var b=arguments;if(1<b.length){var c=b[0];zb[c]=b[1]}else for(c in b=b[0],b)zb[c]=b[c]}
function B(a,b){return a in zb?zb[a]:b}
function Cb(a,b){ea(a)&&(a=Db(a));return window.setTimeout(a,b)}
function Db(a){return a&&window.yterr?function(){try{return a.apply(this,arguments)}catch(b){Eb(b)}}:a}
function Eb(a){var b=p("yt.logging.errors.log");b?b(a,void 0,void 0,void 0,void 0):(b=B("ERRORS",[]),b.push([a,void 0,void 0,void 0,void 0]),Bb("ERRORS",b))}
;function C(a,b){this.version=a;this.args=b}
function Fb(a){if(!a.ia){var b={};a.call(b);a.ia=b.version}return a.ia}
function Gb(a,b){function c(){a.apply(this,b.args)}
if(!b.args||!b.version)throw Error("yt.pubsub2.Data.deserialize(): serializedData is incomplete.");var d;try{d=Fb(a)}catch(e){}if(!d||b.version!=d)throw Error("yt.pubsub2.Data.deserialize(): serializedData version is incompatible.");c.prototype=a.prototype;try{return new c}catch(e){throw e.message="yt.pubsub2.Data.deserialize(): "+e.message,e;}}
function D(a,b){this.topic=a;this.H=b}
D.prototype.toString=function(){return this.topic};function Hb(){this.g=this.g;this.l=this.l}
Hb.prototype.g=!1;Hb.prototype.dispose=function(){this.g||(this.g=!0,this.P())};
Hb.prototype.P=function(){if(this.l)for(;this.l.length;)this.l.shift()()};function Ib(){this.f=this.b=null}
var Kb=new yb(function(){return new Jb},function(a){a.reset()},100);
Ib.prototype.remove=function(){var a=null;this.b&&(a=this.b,this.b=this.b.next,this.b||(this.f=null),a.next=null);return a};
function Jb(){this.next=this.scope=this.b=null}
Jb.prototype.set=function(a,b){this.b=a;this.scope=b;this.next=null};
Jb.prototype.reset=function(){this.next=this.scope=this.b=null};function Lb(a){var b=void 0;isNaN(b)&&(b=void 0);var c=p("yt.scheduler.instance.addJob");c?c(a,1,b):void 0===b?a():Cb(a,b||0)}
;function Mb(a){n.setTimeout(function(){throw a;},0)}
var Nb;
function Ob(){var a=n.MessageChannel;"undefined"===typeof a&&"undefined"!==typeof window&&window.postMessage&&window.addEventListener&&!x("Presto")&&(a=function(){var a=document.createElement("IFRAME");a.style.display="none";a.src="";document.documentElement.appendChild(a);var b=a.contentWindow,a=b.document;a.open();a.write("");a.close();var c="callImmediate"+Math.random(),d="file:"==b.location.protocol?"*":b.location.protocol+"//"+b.location.host,a=t(function(a){if(("*"==d||a.origin==d)&&a.data==
c)this.port1.onmessage()},this);
b.addEventListener("message",a,!1);this.port1={};this.port2={postMessage:function(){b.postMessage(c,d)}}});
if("undefined"!==typeof a&&!x("Trident")&&!x("MSIE")){var b=new a,c={},d=c;b.port1.onmessage=function(){if(void 0!==c.next){c=c.next;var a=c.Z;c.Z=null;a()}};
return function(a){d.next={Z:a};d=d.next;b.port2.postMessage(0)}}return"undefined"!==typeof document&&"onreadystatechange"in document.createElement("SCRIPT")?function(a){var b=document.createElement("SCRIPT");
b.onreadystatechange=function(){b.onreadystatechange=null;b.parentNode.removeChild(b);b=null;a();a=null};
document.documentElement.appendChild(b)}:function(a){n.setTimeout(a,0)}}
;function Pb(a){Qb||Rb();Sb||(Qb(),Sb=!0);var b=Tb,c=Kb.get();c.set(a,void 0);b.f?b.f.next=c:b.b=c;b.f=c}
var Qb;function Rb(){if(-1!=String(n.Promise).indexOf("[native code]")){var a=n.Promise.resolve(void 0);Qb=function(){a.then(Ub)}}else Qb=function(){var a=Ub;
!ea(n.setImmediate)||n.Window&&n.Window.prototype&&!x("Edge")&&n.Window.prototype.setImmediate==n.setImmediate?(Nb||(Nb=Ob()),Nb(a)):n.setImmediate(a)}}
var Sb=!1,Tb=new Ib;function Ub(){for(var a;a=Tb.remove();){try{a.b.call(a.scope)}catch(c){Mb(c)}var b=Kb;b.o(a);b.f<b.l&&(b.f++,a.next=b.b,b.b=a)}Sb=!1}
;function E(a){Hb.call(this);this.aa=1;this.o=[];this.w=0;this.b=[];this.f={};this.Ba=!!a}
v(E,Hb);m=E.prototype;m.subscribe=function(a,b,c){var d=this.f[a];d||(d=this.f[a]=[]);var e=this.aa;this.b[e]=a;this.b[e+1]=b;this.b[e+2]=c;this.aa=e+3;d.push(e);return e};
function Vb(a,b,c){if(b=a.f[b]){var d=a.b;(b=wa(b,function(a){return d[a+1]==c&&void 0==d[a+2]}))&&a.G(b)}}
m.G=function(a){var b=this.b[a];if(b){var c=this.f[b];if(0!=this.w)this.o.push(a),this.b[a+1]=aa;else{if(c){var d=sa(c,a);0<=d&&Array.prototype.splice.call(c,d,1)}delete this.b[a];delete this.b[a+1];delete this.b[a+2]}}return!!b};
m.K=function(a,b){var c=this.f[a];if(c){for(var d=Array(arguments.length-1),e=1,f=arguments.length;e<f;e++)d[e-1]=arguments[e];if(this.Ba)for(e=0;e<c.length;e++){var g=c[e];Wb(this.b[g+1],this.b[g+2],d)}else{this.w++;try{for(e=0,f=c.length;e<f;e++)g=c[e],this.b[g+1].apply(this.b[g+2],d)}finally{if(this.w--,0<this.o.length&&0==this.w)for(;c=this.o.pop();)this.G(c)}}return 0!=e}return!1};
function Wb(a,b,c){Pb(function(){a.apply(b,c)})}
m.clear=function(a){if(a){var b=this.f[a];b&&(w(b,this.G,this),delete this.f[a])}else this.b.length=0,this.f={}};
function Xb(a,b){if(b){var c=a.f[b];return c?c.length:0}var c=0,d;for(d in a.f)c+=Xb(a,d);return c}
m.P=function(){E.T.P.call(this);this.clear();this.o.length=0};var Yb=p("yt.pubsub2.instance_")||new E;E.prototype.subscribe=E.prototype.subscribe;E.prototype.unsubscribeByKey=E.prototype.G;E.prototype.publish=E.prototype.K;E.prototype.clear=E.prototype.clear;u("yt.pubsub2.instance_",Yb);var Zb=p("yt.pubsub2.subscribedKeys_")||{};u("yt.pubsub2.subscribedKeys_",Zb);var $b=p("yt.pubsub2.topicToKeys_")||{};u("yt.pubsub2.topicToKeys_",$b);var ac=p("yt.pubsub2.isAsync_")||{};u("yt.pubsub2.isAsync_",ac);u("yt.pubsub2.skipSubKey_",null);
function F(a,b){var c=cc();return c?c.publish.call(c,a.toString(),a,b):!1}
function dc(a,b,c){window.yt.pubsub2.skipSubKey_=a;F.call(null,b,c);window.yt.pubsub2.skipSubKey_=null}
function G(a,b,c){var d=cc();if(!d)return 0;var e=d.subscribe(a.toString(),function(d,g){if(!window.yt.pubsub2.skipSubKey_||window.yt.pubsub2.skipSubKey_!=e){var f=function(){if(Zb[e])try{if(g&&a instanceof D&&a!=d)try{g=Gb(a.H,g)}catch(h){throw h.message="yt.pubsub2 cross-binary conversion error for "+a.toString()+": "+h.message,h;}b.call(c||window,g)}catch(h){Eb(h)}};
ac[a.toString()]?p("yt.scheduler.instance")?Lb(f):Cb(f,0):f()}});
Zb[e]=!0;$b[a.toString()]||($b[a.toString()]=[]);$b[a.toString()].push(e);return e}
function ec(a){var b=cc();b&&("number"==typeof a&&(a=[a]),w(a,function(a){b.unsubscribeByKey(a);delete Zb[a]}))}
function cc(){return p("yt.pubsub2.instance_")}
;function fc(a){return eval("("+a+")")}
;function gc(a,b,c){a&&(a.dataset?a.dataset[hc(b)]=c:a.setAttribute("data-"+b,c))}
function H(a,b){return a?a.dataset?a.dataset[hc(b)]:a.getAttribute("data-"+b):null}
function ic(a,b){a&&(a.dataset?delete a.dataset[hc(b)]:a.removeAttribute("data-"+b))}
var jc={};function hc(a){return jc[a]||(jc[a]=String(a).replace(/\-([a-z])/g,function(a,c){return c.toUpperCase()}))}
;var kc=null;"undefined"!=typeof XMLHttpRequest?kc=function(){return new XMLHttpRequest}:"undefined"!=typeof ActiveXObject&&(kc=function(){return new ActiveXObject("Microsoft.XMLHTTP")});var I=/^(?:([^:/?#.]+):)?(?:\/\/(?:([^/?#]*)@)?([^/#?]*?)(?::([0-9]+))?(?=[/#?]|$))?([^?#]+)?(?:\?([^#]*))?(?:#([\s\S]*))?$/;function lc(a){return a?decodeURI(a):a}
function mc(a){if(a[1]){var b=a[0],c=b.indexOf("#");0<=c&&(a.push(b.substr(c)),a[0]=b=b.substr(0,c));c=b.indexOf("?");0>c?a[1]="?":c==b.length-1&&(a[1]=void 0)}return a.join("")}
function nc(a,b,c){if("array"==ca(b))for(var d=0;d<b.length;d++)nc(a,String(b[d]),c);else null!=b&&c.push("&",a,""===b?"":"=",encodeURIComponent(String(b)))}
function oc(a,b,c){for(c=c||0;c<b.length;c+=2)nc(b[c],b[c+1],a);return a}
function pc(a,b){for(var c in b)nc(c,b[c],a);return a}
function qc(a){a=pc([],a);a[0]="";return a.join("")}
function rc(a,b){return mc(2==arguments.length?oc([a],arguments[1],0):oc([a],arguments,1))}
;function sc(a){"?"==a.charAt(0)&&(a=a.substr(1));a=a.split("&");for(var b={},c=0,d=a.length;c<d;c++){var e=a[c].split("=");if(1==e.length&&e[0]||2==e.length){var f=decodeURIComponent((e[0]||"").replace(/\+/g," ")),e=decodeURIComponent((e[1]||"").replace(/\+/g," "));f in b?"array"==ca(b[f])?Aa(b[f],e):b[f]=[b[f],e]:b[f]=e}}return b}
function tc(a,b){var c=a.split("#",2);a=c[0];var c=1<c.length?"#"+c[1]:"",d=a.split("?",2);a=d[0];var d=sc(d[1]||""),e;for(e in b)d[e]=b[e];return mc(pc([a],d))+c}
;var uc=p("yt.pubsub.instance_")||new E;E.prototype.subscribe=E.prototype.subscribe;E.prototype.unsubscribeByKey=E.prototype.G;E.prototype.publish=E.prototype.K;E.prototype.clear=E.prototype.clear;u("yt.pubsub.instance_",uc);var vc=p("yt.pubsub.subscribedKeys_")||{};u("yt.pubsub.subscribedKeys_",vc);var wc=p("yt.pubsub.topicToKeys_")||{};u("yt.pubsub.topicToKeys_",wc);var xc=p("yt.pubsub.isSynchronous_")||{};u("yt.pubsub.isSynchronous_",xc);var yc=p("yt.pubsub.skipSubId_")||null;
u("yt.pubsub.skipSubId_",yc);function zc(a,b,c){var d=Ac();if(d){var e=d.subscribe(a,function(){if(!yc||yc!=e){var d=arguments,g;g=function(){vc[e]&&b.apply(c||window,d)};
try{xc[a]?g():Cb(g,0)}catch(k){Eb(k)}}},c);
vc[e]=!0;wc[a]||(wc[a]=[]);wc[a].push(e);return e}return 0}
function Bc(a){var b=Ac();b&&("number"==typeof a?a=[a]:"string"==typeof a&&(a=[parseInt(a,10)]),w(a,function(a){b.unsubscribeByKey(a);delete vc[a]}))}
function Cc(a,b){var c=Ac();return c?c.publish.apply(c,arguments):!1}
function Ac(){return p("yt.pubsub.instance_")}
;function Dc(a,b,c,d,e,f,g){function k(){4==(h&&"readyState"in h?h.readyState:0)&&b&&Db(b)(h)}
var h=kc&&kc();if(!("open"in h))return null;"onloadend"in h?h.addEventListener("loadend",k,!1):h.onreadystatechange=k;c=(c||"GET").toUpperCase();d=d||"";h.open(c,a,!0);f&&(h.responseType=f);g&&(h.withCredentials=!0);f="POST"==c;if(e=Ec(a,e))for(var l in e)h.setRequestHeader(l,e[l]),"content-type"==l.toLowerCase()&&(f=!1);f&&h.setRequestHeader("Content-Type","application/x-www-form-urlencoded");h.send(d);return h}
function Ec(a,b){b=b||{};var c;c||(c=window.location.href);var d=a.match(I)[1]||null,e=lc(a.match(I)[3]||null);d&&e?(d=c,c=a.match(I),d=d.match(I),c=c[3]==d[3]&&c[1]==d[1]&&c[4]==d[4]):c=e?lc(c.match(I)[3]||null)==e&&(Number(c.match(I)[4]||null)||null)==(Number(a.match(I)[4]||null)||null):!0;for(var f in Fc){if((e=d=B(Fc[f]))&&!(e=c)){var e=f,g=B("CORS_HEADER_WHITELIST")||{},k=lc(a.match(I)[3]||null);e=k?(g=g[k])?xa(g,e):!1:!0}e&&(b[f]=d)}return b}
function Gc(a,b){var c=B("XSRF_FIELD_NAME",void 0),d;b.headers&&(d=b.headers["Content-Type"]);return!b.Na&&(!lc(a.match(I)[3]||null)||b.withCredentials||lc(a.match(I)[3]||null)==document.location.hostname)&&"POST"==b.method&&(!d||"application/x-www-form-urlencoded"==d)&&!(b.C&&b.C[c])}
function Hc(a,b){var c=b.format||"JSON";b.Oa&&(a=document.location.protocol+"//"+document.location.hostname+(document.location.port?":"+document.location.port:"")+a);var d=B("XSRF_FIELD_NAME",void 0),e=B("XSRF_TOKEN",void 0),f=b.ha;f&&(f[d]&&delete f[d],a=tc(a,f||{}));var g=b.postBody||"",f=b.C;Gc(a,b)&&(f||(f={}),f[d]=e);f&&r(g)&&(d=sc(g),Na(d,f),g=b.Aa&&"JSON"==b.Aa?JSON.stringify(d):qc(d));var k=!1,h,l=Dc(a,function(a){if(!k){k=!0;h&&window.clearTimeout(h);var d;a:switch(a&&"status"in a?a.status:
-1){case 200:case 201:case 202:case 203:case 204:case 205:case 206:case 304:d=!0;break a;default:d=!1}var e=null;if(d||400<=a.status&&500>a.status)e=Ic(c,a,b.Ma);if(d)a:if(204==a.status)d=!0;else{switch(c){case "XML":d=0==parseInt(e&&e.return_code,10);break a;case "RAW":d=!0;break a}d=!!e}var e=e||{},f=b.context||n;d?b.F&&b.F.call(f,a,e):b.onError&&b.onError.call(f,a,e);b.S&&b.S.call(f,a,e)}},b.method,g,b.headers,b.responseType,b.withCredentials);
b.ya&&0<b.timeout&&(h=Cb(function(){k||(k=!0,l.abort(),window.clearTimeout(h),b.ya.call(b.context||n,l))},b.timeout))}
function Ic(a,b,c){var d=null;switch(a){case "JSON":a=b.responseText;b=b.getResponseHeader("Content-Type")||"";a&&0<=b.indexOf("json")&&(d=fc(a));break;case "XML":if(b=(b=b.responseXML)?Jc(b):null)d={},w(b.getElementsByTagName("*"),function(a){d[a.tagName]=Kc(a)})}c&&Lc(d);
return d}
function Lc(a){if(fa(a))for(var b in a){var c;(c="html_content"==b)||(c=b.length-5,c=0<=c&&b.indexOf("_html",c)==c);c?a[b]=new Ra:Lc(a[b])}}
function Jc(a){return a?(a=("responseXML"in a?a.responseXML:a).getElementsByTagName("root"))&&0<a.length?a[0]:null:null}
function Kc(a){var b="";w(a.childNodes,function(a){b+=a.nodeValue});
return b}
var Fc={"X-Goog-Visitor-Id":"SANDBOXED_VISITOR_ID","X-YouTube-Client-Name":"INNERTUBE_CONTEXT_CLIENT_NAME","X-YouTube-Client-Version":"INNERTUBE_CONTEXT_CLIENT_VERSION","X-Youtube-Identity-Token":"ID_TOKEN","X-YouTube-Page-CL":"PAGE_CL","X-YouTube-Page-Label":"PAGE_BUILD_LABEL","X-YouTube-Variants-Checksum":"VARIANTS_CHECKSUM"};var Mc={},Nc=0;function Oc(a){var b=new Image,c=""+Nc++;Mc[c]=b;b.onload=b.onerror=function(){delete Mc[c]};
b.src=a}
;function Pc(a){C.call(this,1,arguments);this.b=a}
v(Pc,C);function J(a){C.call(this,1,arguments);this.b=a}
v(J,C);function Qc(a,b,c){C.call(this,3,arguments);this.g=a;this.f=b;this.b=null!=c?!!c:null}
v(Qc,C);function Rc(a,b,c,d,e){C.call(this,2,arguments);this.f=a;this.b=b;this.l=c||null;this.g=d||null;this.source=e||null}
v(Rc,C);function Sc(a,b,c){C.call(this,1,arguments);this.b=a;this.f=b}
v(Sc,C);function Tc(a,b,c,d,e,f,g){C.call(this,1,arguments);this.f=a;this.o=b;this.b=c;this.w=d||null;this.l=e||null;this.g=f||null;this.source=g||null}
v(Tc,C);
var Uc=new D("subscription-batch-subscribe",Pc),Vc=new D("subscription-batch-unsubscribe",Pc),Wc=new D("subscription-subscribe",Rc),Xc=new D("subscription-subscribe-loading",J),Yc=new D("subscription-subscribe-loaded",J),K=new D("subscription-subscribe-success",Sc),Zc=new D("subscription-subscribe-external",Rc),$c=new D("subscription-unsubscribe",Tc),ad=new D("subscription-unsubscirbe-loading",J),bd=new D("subscription-unsubscribe-loaded",J),L=new D("subscription-unsubscribe-success",J),cd=new D("subscription-external-unsubscribe",
Tc),dd=new D("subscription-enable-ypc",J),ed=new D("subscription-disable-ypc",J),fd=new D("subscription-prefs",Qc),gd=new D("subscription-prefs-success",Qc),hd=new D("subscription-prefs-failure",Qc);function id(a){var b=document.location.protocol+"//"+document.domain+"/post_login",b=rc(b,"mode","subscribe"),b=rc("/signin?context=popup","next",b),b=rc(b,"feature","sub_button");if(b=window.open(b,"loginPopup","width=375,height=440,resizable=yes,scrollbars=yes",!0)){var c=zc("LOGGED_IN",function(b){Bc(B("LOGGED_IN_PUBSUB_KEY",void 0));Bb("LOGGED_IN",!0);a(b)});
Bb("LOGGED_IN_PUBSUB_KEY",c);b.moveTo((screen.width-375)/2,(screen.height-440)/2)}}
u("yt.pubsub.publish",Cc);function jd(){var a=B("PLAYER_CONFIG");return a&&a.args&&void 0!==a.args.authuser?!0:!(!B("SESSION_INDEX")&&!B("LOGGED_IN"))}
;function kd(a,b,c,d){this.top=a;this.right=b;this.bottom=c;this.left=d}
kd.prototype.getHeight=function(){return this.bottom-this.top};
kd.prototype.ceil=function(){this.top=Math.ceil(this.top);this.right=Math.ceil(this.right);this.bottom=Math.ceil(this.bottom);this.left=Math.ceil(this.left);return this};
kd.prototype.floor=function(){this.top=Math.floor(this.top);this.right=Math.floor(this.right);this.bottom=Math.floor(this.bottom);this.left=Math.floor(this.left);return this};
kd.prototype.round=function(){this.top=Math.round(this.top);this.right=Math.round(this.right);this.bottom=Math.round(this.bottom);this.left=Math.round(this.left);return this};function ld(a,b,c,d){this.left=a;this.top=b;this.width=c;this.height=d}
ld.prototype.ceil=function(){this.left=Math.ceil(this.left);this.top=Math.ceil(this.top);this.width=Math.ceil(this.width);this.height=Math.ceil(this.height);return this};
ld.prototype.floor=function(){this.left=Math.floor(this.left);this.top=Math.floor(this.top);this.width=Math.floor(this.width);this.height=Math.floor(this.height);return this};
ld.prototype.round=function(){this.left=Math.round(this.left);this.top=Math.round(this.top);this.width=Math.round(this.width);this.height=Math.round(this.height);return this};function M(a,b){var c=mb(a);return c.defaultView&&c.defaultView.getComputedStyle&&(c=c.defaultView.getComputedStyle(a,null))?c[b]||c.getPropertyValue(b)||"":""}
function md(a,b){return M(a,b)||(a.currentStyle?a.currentStyle[b]:null)||a.style&&a.style[b]}
function nd(a){var b;try{b=a.getBoundingClientRect()}catch(c){return{left:0,top:0,right:0,bottom:0}}z&&a.ownerDocument.body&&(a=a.ownerDocument,b.left-=a.documentElement.clientLeft+a.body.clientLeft,b.top-=a.documentElement.clientTop+a.body.clientTop);return b}
function od(a){"number"==typeof a&&(a+="px");return a}
function pd(a){var b=qd;if("none"!=md(a,"display"))return b(a);var c=a.style,d=c.display,e=c.visibility,f=c.position;c.visibility="hidden";c.position="absolute";c.display="inline";a=b(a);c.display=d;c.position=f;c.visibility=e;return a}
function qd(a){var b=a.offsetWidth,c=a.offsetHeight,d=Ya&&!b&&!c;return(void 0===b||d)&&a.getBoundingClientRect?(a=nd(a),new Sa(a.right-a.left,a.bottom-a.top)):new Sa(b,c)}
function rd(a,b){if(/^\d+px?$/.test(b))return parseInt(b,10);var c=a.style.left,d=a.runtimeStyle.left;a.runtimeStyle.left=a.currentStyle.left;a.style.left=b;var e=a.style.pixelLeft;a.style.left=c;a.runtimeStyle.left=d;return+e}
function sd(a,b){var c=a.currentStyle?a.currentStyle[b]:null;return c?rd(a,c):0}
var td={thin:2,medium:4,thick:6};function ud(a,b){if("none"==(a.currentStyle?a.currentStyle[b+"Style"]:null))return 0;var c=a.currentStyle?a.currentStyle[b+"Width"]:null;return c in td?td[c]:rd(a,c)}
;var vd=p("yt.dom.getNextId_");if(!vd){vd=function(){return++wd};
u("yt.dom.getNextId_",vd);var wd=0}function xd(){var a=document,b;va(["fullscreenElement","webkitFullscreenElement","mozFullScreenElement","msFullscreenElement"],function(c){b=a[c];return!!b});
return b}
;function yd(){var a=xd();return a?a:null}
;function zd(a,b){(a=A(a))&&a.style&&(a.style.display=b?"":"none",Ha(a,"hid",!b))}
function Ad(a){w(arguments,function(a){!da(a)||a instanceof Element?zd(a,!0):w(a,function(a){Ad(a)})})}
function Bd(a){w(arguments,function(a){!da(a)||a instanceof Element?zd(a,!1):w(a,function(a){Bd(a)})})}
;function Cd(a){this.type="";this.state=this.source=this.data=this.currentTarget=this.relatedTarget=this.target=null;this.charCode=this.keyCode=0;this.shiftKey=this.ctrlKey=this.altKey=!1;this.clientY=this.clientX=0;this.changedTouches=null;if(a=a||window.event){this.event=a;for(var b in a)b in Dd||(this[b]=a[b]);(b=a.target||a.srcElement)&&3==b.nodeType&&(b=b.parentNode);this.target=b;if(b=a.relatedTarget)try{b=b.nodeName?b:null}catch(c){b=null}else"mouseover"==this.type?b=a.fromElement:"mouseout"==
this.type&&(b=a.toElement);this.relatedTarget=b;this.clientX=void 0!=a.clientX?a.clientX:a.pageX;this.clientY=void 0!=a.clientY?a.clientY:a.pageY;this.keyCode=a.keyCode?a.keyCode:a.which;this.charCode=a.charCode||("keypress"==this.type?this.keyCode:0);this.altKey=a.altKey;this.ctrlKey=a.ctrlKey;this.shiftKey=a.shiftKey}}
Cd.prototype.preventDefault=function(){this.event&&(this.event.returnValue=!1,this.event.preventDefault&&this.event.preventDefault())};
Cd.prototype.stopPropagation=function(){this.event&&(this.event.cancelBubble=!0,this.event.stopPropagation&&this.event.stopPropagation())};
Cd.prototype.stopImmediatePropagation=function(){this.event&&(this.event.cancelBubble=!0,this.event.stopImmediatePropagation&&this.event.stopImmediatePropagation())};
var Dd={stopImmediatePropagation:1,stopPropagation:1,preventMouseEvent:1,preventManipulation:1,preventDefault:1,layerX:1,layerY:1,scale:1,rotation:1,webkitMovementX:1,webkitMovementY:1};var La=p("yt.events.listeners_")||{};u("yt.events.listeners_",La);var Ed=p("yt.events.counter_")||{count:0};u("yt.events.counter_",Ed);function Fd(a,b,c,d){a.addEventListener&&("mouseenter"!=b||"onmouseenter"in document?"mouseleave"!=b||"onmouseenter"in document?"mousewheel"==b&&"MozBoxSizing"in document.documentElement.style&&(b="MozMousePixelScroll"):b="mouseout":b="mouseover");return Ka(function(e){return e[0]==a&&e[1]==b&&e[2]==c&&e[4]==!!d})}
function N(a,b,c,d){if(a&&(a.addEventListener||a.attachEvent)){d=!!d;var e=Fd(a,b,c,d);if(!e){var e=++Ed.count+"",f=!("mouseenter"!=b&&"mouseleave"!=b||!a.addEventListener||"onmouseenter"in document),g;g=f?function(d){d=new Cd(d);if(!xb(d.relatedTarget,function(b){return b==a},!0))return d.currentTarget=a,d.type=b,c.call(a,d)}:function(b){b=new Cd(b);
b.currentTarget=a;return c.call(a,b)};
g=Db(g);a.addEventListener?("mouseenter"==b&&f?b="mouseover":"mouseleave"==b&&f?b="mouseout":"mousewheel"==b&&"MozBoxSizing"in document.documentElement.style&&(b="MozMousePixelScroll"),a.addEventListener(b,g,d)):a.attachEvent("on"+b,g);La[e]=[a,b,c,g,d]}}}
;var O={},Gd="ontouchstart"in document;function Hd(a,b,c){var d;switch(a){case "mouseover":case "mouseout":d=3;break;case "mouseenter":case "mouseleave":d=9}return xb(c,function(a){return Ea(a,b)},!0,d)}
function P(a){var b="mouseover"==a.type&&"mouseenter"in O||"mouseout"==a.type&&"mouseleave"in O,c=a.type in O||b;if("HTML"!=a.target.tagName&&c){if(b){var b="mouseover"==a.type?"mouseenter":"mouseleave",c=O[b],d;for(d in c.f){var e=Hd(b,d,a.target);e&&!xb(a.relatedTarget,function(a){return a==e},!0)&&c.K(d,e,b,a)}}if(b=O[a.type])for(d in b.f)(e=Hd(a.type,d,a.target))&&b.K(d,e,a.type,a)}}
N(document,"blur",P,!0);N(document,"change",P,!0);N(document,"click",P);N(document,"focus",P,!0);N(document,"mouseover",P);N(document,"mouseout",P);N(document,"mousedown",P);N(document,"keydown",P);N(document,"keyup",P);N(document,"keypress",P);N(document,"cut",P);N(document,"paste",P);Gd&&(N(document,"touchstart",P),N(document,"touchend",P),N(document,"touchcancel",P));function Id(a){this.o=a;this.g={};this.L=[];this.l=[]}
function Q(a,b){return"yt-uix"+(a.o?"-"+a.o:"")+(b?"-"+b:"")}
Id.prototype.unregister=function(){Bc(this.L);this.L.length=0;ec(this.l);this.l.length=0};
Id.prototype.init=aa;Id.prototype.dispose=aa;function Jd(a,b,c){a.l.push(G(b,c,a))}
function R(a,b,c){var d=Q(a,void 0),e=t(c,a);b in O||(O[b]=new E);O[b].subscribe(d,e);a.g[c]=e}
function T(a,b,c){if(b in O){var d=O[b];Vb(d,Q(a,void 0),a.g[c]);0>=Xb(d)&&(d.dispose(),delete O[b])}delete a.g[c]}
function Kd(a,b){gc(a,"tooltip-text",b)}
;function Ld(){Id.call(this,"tooltip");this.b=0;this.f={}}
v(Ld,Id);ba(Ld);m=Ld.prototype;m.register=function(){R(this,"mouseover",this.J);R(this,"mouseout",this.B);R(this,"focus",this.$);R(this,"blur",this.Y);R(this,"click",this.B);R(this,"touchstart",this.ga);R(this,"touchend",this.M);R(this,"touchcancel",this.M)};
m.unregister=function(){T(this,"mouseover",this.J);T(this,"mouseout",this.B);T(this,"focus",this.$);T(this,"blur",this.Y);T(this,"click",this.B);T(this,"touchstart",this.ga);T(this,"touchend",this.M);T(this,"touchcancel",this.M);this.dispose();Ld.T.unregister.call(this)};
m.dispose=function(){for(var a in this.f)this.B(this.f[a]);this.f={}};
m.J=function(a){if(!(this.b&&1E3>na()-this.b)){var b=parseInt(H(a,"tooltip-hide-timer"),10);b&&(ic(a,"tooltip-hide-timer"),window.clearTimeout(b));var b=t(function(){Md(this,a);ic(a,"tooltip-show-timer")},this),c=parseInt(H(a,"tooltip-show-delay"),10)||0,b=Cb(b,c);
gc(a,"tooltip-show-timer",b.toString());a.title&&(Kd(a,Nd(a)),a.title="");b=(a[ga]||(a[ga]=++ja)).toString();this.f[b]=a}};
m.B=function(a){var b=parseInt(H(a,"tooltip-show-timer"),10);b&&(window.clearTimeout(b),ic(a,"tooltip-show-timer"));b=t(function(){if(a){var b=A(Od(this,a));b&&(Pd(b),b&&b.parentNode&&b.parentNode.removeChild(b),ic(a,"content-id"));(b=A(Od(this,a,"arialabel")))&&b.parentNode&&b.parentNode.removeChild(b)}ic(a,"tooltip-hide-timer")},this);
b=Cb(b,50);gc(a,"tooltip-hide-timer",b.toString());if(b=H(a,"tooltip-text"))a.title=b;b=(a[ga]||(a[ga]=++ja)).toString();delete this.f[b]};
m.$=function(a){this.b=0;this.J(a)};
m.Y=function(a){this.b=0;this.B(a)};
m.ga=function(a,b,c){c.changedTouches&&(this.b=0,(a=Hd(b,Q(this),c.changedTouches[0].target))&&this.J(a))};
m.M=function(a,b,c){c.changedTouches&&(this.b=na(),(a=Hd(b,Q(this),c.changedTouches[0].target))&&this.B(a))};
function Qd(a,b){Kd(a,b);var c=H(a,"content-id");(c=A(c))&&qb(c,b)}
function Nd(a){return H(a,"tooltip-text")||a.title}
function Md(a,b){if(b){var c=Nd(b);if(c){var d=A(Od(a,b));if(!d){d=document.createElement("div");d.id=Od(a,b);d.className=Q(a,"tip");var e=document.createElement("div");e.className=Q(a,"tip-body");var f=document.createElement("div");f.className=Q(a,"tip-arrow");var g=document.createElement("div");g.setAttribute("aria-hidden","true");g.className=Q(a,"tip-content");var k=Rd(a,b),h=Od(a,b,"content");g.id=h;gc(b,"content-id",h);e.appendChild(g);k&&d.appendChild(k);d.appendChild(e);d.appendChild(f);var l=
tb(b),h=Od(a,b,"arialabel"),f=document.createElement("div");Fa(f,Q(a,"arialabel"));f.id=h;l=b.hasAttribute("aria-label")?b.getAttribute("aria-label"):"rtl"==document.body.getAttribute("dir")?c+" "+l:l+" "+c;qb(f,l);b.setAttribute("aria-labelledby",h);h=yd()||document.body;h.appendChild(f);h.appendChild(d);Qd(b,c);(c=parseInt(H(b,"tooltip-max-width"),10))&&e.offsetWidth>c&&(e.style.width=c+"px",Fa(g,Q(a,"normal-wrap")));g=Ea(b,Q(a,"reverse"));Sd(a,b,d,e,k,g)||Sd(a,b,d,e,k,!g);var q=Q(a,"tip-visible");
Cb(function(){Fa(d,q)},0)}}}}
function Sd(a,b,c,d,e,f){Ha(c,Q(a,"tip-reverse"),f);var g=0;f&&(g=1);a=pd(b);f=new y((a.width-10)/2,f?a.height:0);var k=mb(b),h=new y(0,0),l;l=k?mb(k):document;l=!z||9<=Number(gb)||pb(kb(l).b)?l.documentElement:l.body;if(b!=l){l=nd(b);var q=kb(k).b,k=q.scrollingElement?q.scrollingElement:!Ya&&pb(q)?q.documentElement:q.body||q.documentElement,q=q.parentWindow||q.defaultView,k=z&&fb("10")&&q.pageYOffset!=k.scrollTop?new y(k.scrollLeft,k.scrollTop):new y(q.pageXOffset||k.scrollLeft,q.pageYOffset||k.scrollTop);
h.i=l.left+k.i;h.j=l.top+k.j}f=new y(h.i+f.i,h.j+f.j);f=new y(f.i,f.j);h=(g&8&&"rtl"==md(c,"direction")?g^4:g)&-9;g=pd(c);l=new Sa(g.width,g.height);f=new y(f.i,f.j);l=new Sa(l.width,l.height);0!=h&&(h&4?f.i-=l.width+0:h&2&&(f.i-=l.width/2),h&1&&(f.j-=l.height+0));h=new ld(0,0,0,0);h.left=f.i;h.top=f.j;h.width=l.width;h.height=l.height;h=f=h;l=new y(h.left,h.top);l instanceof y?(h=l.i,l=l.j):(h=l,l=void 0);c.style.left=od(h);c.style.top=od(l);l=new Sa(f.width,f.height);if(!(g==l||g&&l&&g.width==l.width&&
g.height==l.height))if(g=l,h=pb(kb(mb(c)).b),!z||fb("10")||h&&fb("8"))f=c.style,Xa?f.MozBoxSizing="border-box":Ya?f.WebkitBoxSizing="border-box":f.boxSizing="border-box",f.width=Math.max(g.width,0)+"px",f.height=Math.max(g.height,0)+"px";else if(f=c.style,h){z?(h=sd(c,"paddingLeft"),l=sd(c,"paddingRight"),k=sd(c,"paddingTop"),q=sd(c,"paddingBottom"),h=new kd(k,l,q,h)):(h=M(c,"paddingLeft"),l=M(c,"paddingRight"),k=M(c,"paddingTop"),q=M(c,"paddingBottom"),h=new kd(parseFloat(k),parseFloat(l),parseFloat(q),
parseFloat(h)));if(!z||9<=Number(gb))l=M(c,"borderLeftWidth"),k=M(c,"borderRightWidth"),q=M(c,"borderTopWidth"),U=M(c,"borderBottomWidth"),l=new kd(parseFloat(q),parseFloat(k),parseFloat(U),parseFloat(l));else{l=ud(c,"borderLeft");var k=ud(c,"borderRight"),q=ud(c,"borderTop"),U=ud(c,"borderBottom");l=new kd(q,k,U,l)}f.pixelWidth=g.width-l.left-h.left-h.right-l.right;f.pixelHeight=g.height-l.top-h.top-h.bottom-l.bottom}else f.pixelWidth=g.width,f.pixelHeight=g.height;g=window.document;g=pb(g)?g.documentElement:
g.body;f=new Sa(g.clientWidth,g.clientHeight);1==c.nodeType?(c=nd(c),l=new y(c.left,c.top)):(c=c.changedTouches?c.changedTouches[0]:c,l=new y(c.clientX,c.clientY));c=pd(d);k=Math.floor(c.width/2);g=!!(f.height<l.j+a.height);a=!!(l.j<a.height);h=!!(l.i<k);f=!!(f.width<l.i+k);l=(c.width+3)/-2- -5;b=H(b,"force-tooltip-direction");if("left"==b||h)l=-5;else if("right"==b||f)l=20-c.width-3;b=Math.floor(l)+"px";d.style.left=b;e&&(e.style.left=b,e.style.height=c.height+"px",e.style.width=c.width+"px");return!(g||
a)}
function Od(a,b,c){a=Q(a);var d=b.__yt_uid_key;d||(d=vd(),b.__yt_uid_key=d);b=a+d;c&&(b+="-"+c);return b}
function Rd(a,b){var c=null;Za&&Ea(b,Q(a,"masked"))&&((c=A("yt-uix-tooltip-shared-mask"))?(c.parentNode.removeChild(c),Ad(c)):(c=document.createElement("iframe"),c.src='javascript:""',c.id="yt-uix-tooltip-shared-mask",c.className=Q(a,"tip-mask")));return c}
function Pd(a){var b=A("yt-uix-tooltip-shared-mask"),c=b&&xb(b,function(b){return b==a},!1,2);
b&&c&&(b.parentNode.removeChild(b),Bd(b),document.body.appendChild(b))}
;function V(){Id.call(this,"subscription-button");this.f=this.b=!1}
v(V,Id);ba(V);V.prototype.register=function(){R(this,"click",this.N);Jd(this,Xc,this.ca);Jd(this,Yc,this.ba);Jd(this,K,this.Ca);Jd(this,ad,this.ca);Jd(this,bd,this.ba);Jd(this,L,this.Da);Jd(this,dd,this.xa);Jd(this,ed,this.wa)};
V.prototype.unregister=function(){T(this,"click",this.N);V.T.unregister.call(this)};
V.prototype.w=function(a){return!!H(a,"is-subscribed")};
var wb={U:"hover-enabled",ka:"yt-uix-button-subscribe",la:"yt-uix-button-subscribed",Ea:"ypc-enabled",ma:"yt-uix-button-subscription-container",na:"yt-subscription-button-disabled-mask-container"},Td={Fa:"channel-external-id",oa:"subscriber-count-show-when-subscribed",pa:"subscriber-count-tooltip",qa:"subscriber-count-title",Ga:"href",Ha:"insecure",V:"is-subscribed",Ia:"parent-url",Ja:"clicktracking",ra:"style-type",W:"subscription-id",Ka:"target",sa:"ypc-enabled"};m=V.prototype;
m.N=function(a){var b=H(a,"href"),c=H(a,"insecure"),d=jd(),e=!(this.b&&d),c=c&&!this.f;if(b&&(e||c))a=H(a,"target")||"_self",window.open(b,a);else if(!c)if(d)if(b=H(a,"channel-external-id"),d=H(a,"clicktracking"),H(a,"ypc-enabled")?(e=H(a,"ypc-item-type"),c=H(a,"ypc-item-id"),e={itemType:e,itemId:c,subscriptionElement:a}):e=null,c=H(a,"parent-url"),H(a,"is-subscribed")){var f=H(a,"subscription-id");F($c,new Tc(b,f,e,a,d,c))}else F(Wc,new Rc(b,e,d,c));else Ud(this,a)};
m.ca=function(a){this.D(a.b,this.ea,!0)};
m.ba=function(a){this.D(a.b,this.ea,!1)};
m.Ca=function(a){this.D(a.b,this.fa,!0,a.f)};
m.Da=function(a){this.D(a.b,this.fa,!1)};
m.xa=function(a){this.D(a.b,this.va)};
m.wa=function(a){this.D(a.b,this.ua)};
m.fa=function(a,b,c){b?(gc(a,Td.V,"true"),c&&gc(a,Td.W,c)):(ic(a,Td.V),ic(a,Td.W));Vd(a)};
m.ea=function(a,b){var c;c=vb(a);Ha(c,wb.na,b);a.setAttribute("aria-busy",b?"true":"false");a.disabled=b};
function Vd(a){var b=H(a,Td.ra),c=!!H(a,"is-subscribed"),b="-"+b,d=wb.la+b;Ha(a,wb.ka+b,!c);Ha(a,d,c);H(a,Td.pa)&&!H(a,Td.oa)&&(b=Q(Ld.A()),Ha(a,b,!c),a.title=c?"":H(a,Td.qa));c?Cb(function(){Fa(a,wb.U)},1E3):Ga(a,wb.U)}
m.va=function(a){var b=!!H(a,"ypc-item-type"),c=!!H(a,"ypc-item-id");!H(a,"ypc-enabled")&&b&&c&&(Fa(a,"ypc-enabled"),gc(a,Td.sa,"true"))};
m.ua=function(a){H(a,"ypc-enabled")&&(Ga(a,"ypc-enabled"),ic(a,"ypc-enabled"))};
function Wd(a,b){return ta(nb(Q(a)),function(a){return b==H(a,"channel-external-id")},a)}
m.ta=function(a,b,c){var d=Ca(arguments,2);w(a,function(a){b.apply(this,ya(a,d))},this)};
m.D=function(a,b,c){var d=Wd(this,a);this.ta.apply(this,ya([d],Ca(arguments,1)))};
function Ud(a,b){var c=t(function(a){a.discoverable_subscriptions&&Bb("SUBSCRIBE_EMBED_DISCOVERABLE_SUBSCRIPTIONS",a.discoverable_subscriptions);this.N(b)},a);
id(c)}
;var Xd=window.yt&&window.yt.uix&&window.yt.uix.widgets_||{};u("yt.uix.widgets_",Xd);/*
 gapi.loader.OBJECT_CREATE_TEST_OVERRIDE &&*/
var Yd=window,Zd=document,$d=Yd.location;function ae(){}
var be=/\[native code\]/;function W(a,b,c){return a[b]=a[b]||c}
function ce(a){for(var b=0;b<this.length;b++)if(this[b]===a)return b;return-1}
function de(a){a=a.sort();for(var b=[],c=void 0,d=0;d<a.length;d++){var e=a[d];e!=c&&b.push(e);c=e}return b}
function X(){var a;if((a=Object.create)&&be.test(a))a=a(null);else{a={};for(var b in a)a[b]=void 0}return a}
var ee=W(Yd,"gapi",{});var Y;Y=W(Yd,"___jsl",X());W(Y,"I",0);W(Y,"hel",10);function fe(){var a=$d.href,b;if(Y.dpo)b=Y.h;else{b=Y.h;var c=RegExp("([#].*&|[#])jsh=([^&#]*)","g"),d=RegExp("([?#].*&|[?#])jsh=([^&#]*)","g");if(a=a&&(c.exec(a)||d.exec(a)))try{b=decodeURIComponent(a[2])}catch(e){}}return b}
function ge(a){var b=W(Y,"PQ",[]);Y.PQ=[];var c=b.length;if(0===c)a();else for(var d=0,e=function(){++d===c&&a()},f=0;f<c;f++)b[f](e)}
function he(a){return W(W(Y,"H",X()),a,X())}
;var ie=W(Y,"perf",X());W(ie,"g",X());var je=W(ie,"i",X());W(ie,"r",[]);X();X();function ke(a,b,c){b&&0<b.length&&(b=le(b),c&&0<c.length&&(b+="___"+le(c)),28<b.length&&(b=b.substr(0,28)+(b.length-28)),c=b,b=W(je,"_p",X()),W(b,c,X())[a]=(new Date).getTime(),b=ie.r,"function"===typeof b?b(a,"_p",c):b.push([a,"_p",c]))}
function le(a){return a.join("__").replace(/\./g,"_").replace(/\-/g,"_").replace(/\,/g,"_")}
;var me=X(),ne=[];function Z(a){throw Error("Bad hint"+(a?": "+a:""));}
ne.push(["jsl",function(a){for(var b in a)if(Object.prototype.hasOwnProperty.call(a,b)){var c=a[b];"object"==typeof c?Y[b]=W(Y,b,[]).concat(c):W(Y,b,c)}if(b=a.u)a=W(Y,"us",[]),a.push(b),(b=/^https:(.*)$/.exec(b))&&a.push("http:"+b[1])}]);
var oe=/^(\/[a-zA-Z0-9_\-]+)+$/,pe=[/\/amp\//,/\/amp$/,/^\/amp$/],qe=/^[a-zA-Z0-9\-_\.,!]+$/,re=/^gapi\.loaded_[0-9]+$/,se=/^[a-zA-Z0-9,._-]+$/;function te(a,b,c,d){var e=a.split(";"),f=e.shift(),g=me[f],k=null;g?k=g(e,b,c,d):Z("no hint processor for: "+f);k||Z("failed to generate load url");b=k;c=b.match(ue);(d=b.match(ve))&&1===d.length&&we.test(b)&&c&&1===c.length||Z("failed sanity: "+a);return k}
function xe(a,b,c,d){function e(a){return encodeURIComponent(a).replace(/%2C/g,",")}
a=ye(a);re.test(c)||Z("invalid_callback");b=ze(b);d=d&&d.length?ze(d):null;return[encodeURIComponent(a.za).replace(/%2C/g,",").replace(/%2F/g,"/"),"/k=",e(a.version),"/m=",e(b),d?"/exm="+e(d):"","/rt=j/sv=1/d=1/ed=1",a.X?"/am="+e(a.X):"",a.da?"/rs="+e(a.da):"",a.ja?"/t="+e(a.ja):"","/cb=",e(c)].join("")}
function ye(a){"/"!==a.charAt(0)&&Z("relative path");for(var b=a.substring(1).split("/"),c=[];b.length;){a=b.shift();if(!a.length||0==a.indexOf("."))Z("empty/relative directory");else if(0<a.indexOf("=")){b.unshift(a);break}c.push(a)}a={};for(var d=0,e=b.length;d<e;++d){var f=b[d].split("="),g=decodeURIComponent(f[0]),k=decodeURIComponent(f[1]);2==f.length&&g&&k&&(a[g]=a[g]||k)}b="/"+c.join("/");oe.test(b)||Z("invalid_prefix");c=0;for(d=pe.length;c<d;++c)pe[c].test(b)&&Z("invalid_prefix");c=Ae(a,
"k",!0);d=Ae(a,"am");e=Ae(a,"rs");a=Ae(a,"t");return{za:b,version:c,X:d,da:e,ja:a}}
function ze(a){for(var b=[],c=0,d=a.length;c<d;++c){var e=a[c].replace(/\./g,"_").replace(/-/g,"_");se.test(e)&&b.push(e)}return b.join(",")}
function Ae(a,b,c){a=a[b];!a&&c&&Z("missing: "+b);if(a){if(qe.test(a))return a;Z("invalid: "+b)}return null}
var we=/^https?:\/\/[a-z0-9_.-]+\.google\.com(:\d+)?\/[a-zA-Z0-9_.,!=\-\/]+$/,ve=/\/cb=/g,ue=/\/\//g;function Be(){var a=fe();if(!a)throw Error("Bad hint");return a}
me.m=function(a,b,c,d){(a=a[0])||Z("missing_hint");return"https://apis.google.com"+xe(a,b,c,d)};
var Ce=decodeURI("%73cript"),De=/^[-+_0-9\/A-Za-z]+={0,2}$/;function Ee(a,b){for(var c=[],d=0;d<a.length;++d){var e=a[d];e&&0>ce.call(b,e)&&c.push(e)}return c}
function Fe(){var a=Y.nonce;if(void 0!==a)return a&&a===String(a)&&a.match(De)?a:Y.nonce=null;var b=W(Y,"us",[]);if(!b||!b.length)return Y.nonce=null;for(var c=Zd.getElementsByTagName(Ce),d=0,e=c.length;d<e;++d){var f=c[d];if(f.src&&(a=String(f.getAttribute("nonce")||"")||null)){for(var g=0,k=b.length;g<k&&b[g]!==f.src;++g);if(g!==k&&a&&a===String(a)&&a.match(De))return Y.nonce=a}}return null}
function Ge(a){if("loading"!=Zd.readyState)He(a);else{var b=Fe(),c="";null!==b&&(c=' nonce="'+b+'"');Zd.write("<"+Ce+' src="'+encodeURI(a)+'"'+c+"></"+Ce+">")}}
function He(a){var b=Zd.createElement(Ce);b.setAttribute("src",a);a=Fe();null!==a&&b.setAttribute("nonce",a);b.async="true";(a=Zd.getElementsByTagName(Ce)[0])?a.parentNode.insertBefore(b,a):(Zd.head||Zd.body||Zd.documentElement).appendChild(b)}
function Ie(a,b){var c=b&&b._c;if(c)for(var d=0;d<ne.length;d++){var e=ne[d][0],f=ne[d][1];f&&Object.prototype.hasOwnProperty.call(c,e)&&f(c[e],a,b)}}
function Je(a,b,c){Ke(function(){var c;c=b===fe()?W(ee,"_",X()):X();c=W(he(b),"_",c);a(c)},c)}
function Le(a,b){var c=b||{};"function"==typeof b&&(c={},c.callback=b);Ie(a,c);var d=a?a.split(":"):[],e=c.h||Be(),f=W(Y,"ah",X());if(f["::"]&&d.length){for(var g=[],k=null;k=d.shift();){var h=k.split("."),h=f[k]||f[h[1]&&"ns:"+h[0]||""]||e,l=g.length&&g[g.length-1]||null,q=l;l&&l.hint==h||(q={hint:h,features:[]},g.push(q));q.features.push(k)}var U=g.length;if(1<U){var ra=c.callback;ra&&(c.callback=function(){0==--U&&ra()})}for(;d=g.shift();)Me(d.features,c,d.hint)}else Me(d||[],c,e)}
function Me(a,b,c){function d(a,b){if(U)return 0;Yd.clearTimeout(q);ra.push.apply(ra,S);var d=((ee||{}).config||{}).update;d?d(f):f&&W(Y,"cu",[]).push(f);if(b){ke("me0",a,ib);try{Je(b,c,l)}finally{ke("me1",a,ib)}}return 1}
a=de(a)||[];var e=b.callback,f=b.config,g=b.timeout,k=b.ontimeout,h=b.onerror,l=void 0;"function"==typeof h&&(l=h);var q=null,U=!1;if(g&&!k||!g&&k)throw"Timeout requires both the timeout parameter and ontimeout parameter to be set";var h=W(he(c),"r",[]).sort(),ra=W(he(c),"L",[]).sort(),ib=[].concat(h);0<g&&(q=Yd.setTimeout(function(){U=!0;k()},g));
var S=Ee(a,ra);if(S.length){var S=Ee(a,h),ha=W(Y,"CP",[]),ia=ha.length;ha[ia]=function(a){function b(){var a=ha[ia+1];a&&a()}
function c(b){ha[ia]=null;d(S,a)&&ge(function(){e&&e();b()})}
if(!a)return 0;ke("ml1",S,ib);0<ia&&ha[ia-1]?ha[ia]=function(){c(b)}:c(b)};
if(S.length){var bc="loaded_"+Y.I++;ee[bc]=function(a){ha[ia](a);ee[bc]=null};
a=te(c,S,"gapi."+bc,h);h.push.apply(h,S);ke("ml0",S,ib);b.sync||Yd.___gapisync?Ge(a):He(a)}else ha[ia](ae)}else d(S)&&e&&e()}
function Ke(a,b){if(Y.hee&&0<Y.hel)try{return a()}catch(c){b&&b(c),Y.hel--,Le("debug_error",function(){try{window.___jsl.hefn(c)}catch(d){throw c;}})}else try{return a()}catch(c){throw b&&b(c),c;
}}
ee.load=function(a,b){return Ke(function(){return Le(a,b)})};function Ne(a){a=ea(a)?{callback:a}:a||{};if(a.gapiHintOverride||B("GAPI_HINT_OVERRIDE")){var b;b=document.location.href;-1!=b.indexOf("?")?(b=(b||"").split("#")[0],b=b.split("?",2),b=sc(1<b.length?b[1]:b[0])):b={};(b=b.gapi_jsh)&&Na(a,{_c:{jsl:{h:b}}})}Le("gapi.iframes:gapi.iframes.style.common",a)}
;function Oe(){return p("gapi.iframes.getContext")()}
function Pe(a){(Oe()||Oe()).connectIframes(a)}
function Qe(a,b){Oe().addOnConnectHandler("yt",a,void 0,b)}
function Re(){return Oe().getParentIframe()}
;var Se="http://www.youtube.com https://www.youtube.com https://plus.google.com https://plus.googleapis.com https://plus.sandbox.google.com https://plusone.google.com https://plusone.sandbox.google.com https://apis.google.com https://apis.sandbox.google.com".split(" "),Te=[Xc,Yc,K,ad,bd,L,Zc,cd],Ue=[Xc,Yc,K,ad,bd,L,dd,ed];function Ve(a){this.b=a;this.v=null;B("SUBSCRIBE_EMBED_HOVERCARD_URL")&&(We(this),N(this.b,"mouseover",t(this.l,this)),N(this.b,"mouseout",t(this.O,this)),N(this.b,"click",t(this.O,this)),G(K,ma(this.f,!0),this),G(L,ma(this.f,!1),this),Xe(this))}
function We(a){var b={url:B("SUBSCRIBE_EMBED_HOVERCARD_URL"),style:"bubble",hideClickDetection:!0,show:!1,anchor:a.b,relayOpen:"-1"};a=t(a.g,a);Oe().open(b,a)}
function Xe(a){jd()||zc("LOGGED_IN",function(){this.v&&(this.O(),this.v.close(),this.v=null,We(this))},a)}
Ve.prototype.g=function(a){this.v=a;a=V.A().w(this.b);this.f(a)};
Ve.prototype.l=function(){this.v&&this.v.restyle({show:!0})};
Ve.prototype.O=function(){this.v&&this.v.restyle({show:!1})};
Ve.prototype.f=function(a){if(this.v){a={isSubscribed:a};try{var b=p("gapi.iframes.SAME_ORIGIN_IFRAMES_FILTER");this.v.send("msg-hovercard-subscription",a,void 0,b)}catch(c){}}};na();function Ye(a){if(da(a))return Ze(a);if(fa(a)&&!ea(a)&&!(fa(a)&&0<a.nodeType))return $e(a);try{return n.JSON.stringify(a),a}catch(b){}}
function $e(a){return Ja(a,function(a){return Ye(a)})}
function Ze(a){return ua(a,function(a){return Ye(a)})}
;function af(a){this.f=null;this.b=a;a=Re();var b=Math.floor(2147483648*Math.random()).toString(36)+Math.abs(Math.floor(2147483648*Math.random())^na()).toString(36);a&&(Pe({role:"ytsubscribe",iframe:a,data:{id:b}}),Qe(t(function(a){this.f=a},this),this.b))}
af.prototype.register=function(a,b){if(this.f)this.f.register(a,b,this.b);else{var c=t(this.register,this,a,b,this.b);Qe(c,this.b)}};
af.prototype.send=function(a,b){if(this.f)this.f.send(a,b,void 0,this.b);else{var c=t(this.send,this,a,b);Qe(c,this.b)}};function bf(){this.b=this.f=null}
function cf(a,b){var c=p("gapi.iframes.CROSS_ORIGIN_IFRAMES_FILTER");try{var d=c||df(a),e=Re();e&&e.send("onytevent",b,void 0,d)}catch(f){}}
bf.prototype.g=function(a,b){if("pubsub2"==b.eventType){var c=b.topicString;c&&a(c,b.serializedData||null)}};
function df(a){if(!a.f){var b;b=p("gapi.iframes.makeWhiteListIframesFilter")(Se);a.f=b}return a.f}
;function ef(){this.b=new bf;this.g=!1;this.f={}}
function ff(a){w(Te,function(a){if(!this.f[a.toString()]){var b=G(a,function(b){var c=this.b;b=b?{version:b.version,args:b.args}:null;c.b&&(b={eventType:"pubsub2",topicString:a.toString(),serializedData:Ye(b)},c.b.send("msg-youtube-pubsub",b))},this);
b&&(this.f[a.toString()]=b)}},a)}
ef.prototype.l=function(a,b){var c=wa(Ue,function(b){return b.toString()==a});
if(c&&(!c.H||b)){var d;if(c.H)try{d=Gb(c.H,b)}catch(f){return}var e=this.f[c.toString()];e?dc(e,c,d):F(c,d)}};
ef.prototype.o=function(a){gf(this)&&cf(this.b,{eventType:"subscribe",channelExternalId:a.b})};
ef.prototype.w=function(a){gf(this)&&cf(this.b,{eventType:"unsubscribe",channelExternalId:a.b})};
function gf(a){return a.g||!!B("SUBSCRIBE_EMBED_DISCOVERABLE_SUBSCRIPTIONS")}
;function hf(){Ne(function(){var a;a=pd(A("yt-subscribe"));a={width:a.width,height:a.height};var b=jf;Oe().ready(a,null,b)})}
function jf(a){if(a.length&&a[a.length-1]){var b=a[a.length-1];a=b.eurl;var b=b.notificationsPipeSupported,c=A("yt-subscribe"),d=V.A(),d=Q(d),e=c||document,f=null;e.getElementsByClassName?f=e.getElementsByClassName(d)[0]:e.querySelectorAll&&e.querySelector?f=e.querySelector("."+d):f=ob(d,c)[0];c=f||null;a&&c&&(V.A(),gc(c,"parent-url",a));kf()?(V.A().f=!0,b&&(V.A().b=!0)):c&&new Ve(c);a=new ef;G(K,a.o,a);G(L,a.w,a);if(kf()){b=a.b;b.b=new af(df(b));ff(a);b=a.b;c=t(a.l,a);if(b.b)try{b.b.register("cmd-youtube-pubsub",
ma(b.g,c))}catch(g){}a.g=!0}}}
function kf(){var a=Re().getOrigin();return xa(Se,a)}
;function lf(a){for(var b=0;b<a.length;b++){var c=a[b];"send_follow_on_ping_action"==c.name&&c.data&&c.data.follow_on_url&&(c=c.data.follow_on_url)&&(B("USE_NET_AJAX_FOR_PING_TRANSPORT",!1)?Dc(c,void 0):Oc(c))}}
;function mf(a){C.call(this,1,arguments);this.b=a}
v(mf,C);function nf(a,b){C.call(this,2,arguments);this.f=a;this.b=b}
v(nf,C);function of(a,b,c,d){C.call(this,1,arguments);this.b=b;this.f=c||null;this.itemId=d||null}
v(of,C);function pf(a,b){C.call(this,1,arguments);this.f=a;this.b=b||null}
v(pf,C);function qf(a){C.call(this,1,arguments)}
v(qf,C);var rf=new D("ypc-core-load",mf),sf=new D("ypc-guide-sync-success",nf),tf=new D("ypc-purchase-success",of),uf=new D("ypc-subscription-cancel",qf),vf=new D("ypc-subscription-cancel-success",pf),wf=new D("ypc-init-subscription",qf);var xf=!1,yf=[];function zf(a){a.b?xf?F(Zc,a):F(rf,new mf(function(){F(wf,new qf(a.b))})):Af(a.f,a.l,a.g,a.source)}
function Bf(a){a.b?xf?F(cd,a):F(rf,new mf(function(){F(uf,new qf(a.b))})):Cf(a.f,a.o,a.l,a.g,a.source)}
function Df(a){Ef(za(a.b))}
function Ff(a){Gf(za(a.b))}
function Hf(a){If(a.g,a.f,a.b)}
function Jf(a){var b=a.itemId,c=a.b.subscriptionId;b&&c&&F(K,new Sc(b,c,a.b.channelInfo))}
function Kf(a){var b=a.b;Ia(a.f,function(a,d){F(K,new Sc(d,a,b[d]))})}
function Lf(a){F(L,new J(a.f.itemId));a.b&&a.b.length&&(Mf(a.b,L),Mf(a.b,dd))}
function Af(a,b,c,d){var e=new J(a);F(Xc,e);var f={};f.c=a;c&&(f.eurl=c);d&&(f.source=d);c={};(d=B("PLAYBACK_ID"))&&(c.plid=d);(d=B("EVENT_ID"))&&(c.ei=d);b&&Nf(b,c);Hc("/subscription_ajax?action_create_subscription_to_channel=1",{method:"POST",ha:f,C:c,F:function(b,c){var d=c.response;F(K,new Sc(a,d.id,d.channel_info));d.show_feed_privacy_dialog&&Cc("SHOW-FEED-PRIVACY-SUBSCRIBE-DIALOG",a);d.actions&&lf(d.actions)},
S:function(){F(Yc,e)}})}
function Cf(a,b,c,d,e){var f=new J(a);F(ad,f);var g={};d&&(g.eurl=d);e&&(g.source=e);d={};d.c=a;d.s=b;(a=B("PLAYBACK_ID"))&&(d.plid=a);(a=B("EVENT_ID"))&&(d.ei=a);c&&Nf(c,d);Hc("/subscription_ajax?action_remove_subscriptions=1",{method:"POST",ha:g,C:d,F:function(a,b){var c=b.response;F(L,f);c.actions&&lf(c.actions)},
S:function(){F(bd,f)}})}
function If(a,b,c){if(a){var d={};d.channel_id=a;switch(b){case "receive-all-updates":d.receive_all_updates=!0;break;case "receive-no-updates":d.receive_no_updates=!0;d.receive_post_updates=!1;break;case "receive-highlight-updates":d.receive_all_updates=!1;d.receive_no_updates=!1;break;default:return}null===c||d.receive_no_updates||(d.receive_post_updates=c);var e=new Qc(a,b,c);Hc("/subscription_ajax?action_update_subscription_preferences=1",{method:"POST",C:d,onError:function(){F(hd,e)},
F:function(){F(gd,e)}})}}
function Ef(a){if(a.length){var b=Ba(a,0,40);F("subscription-batch-subscribe-loading");Mf(b,Xc);var c={};c.a=b.join(",");var d=function(){F("subscription-batch-subscribe-loaded");Mf(b,Yc)};
Hc("/subscription_ajax?action_create_subscription_to_all=1",{method:"POST",C:c,F:function(c,f){d();var e=f.response,k=e.id;if("array"==ca(k)&&k.length==b.length){var h=e.channel_info_map;w(k,function(a,c){var d=b[c];F(K,new Sc(d,a,h[d]))});
a.length?Ef(a):F("subscription-batch-subscribe-finished")}},
onError:function(){d();F("subscription-batch-subscribe-failure")}})}}
function Gf(a){if(a.length){var b=Ba(a,0,40);F("subscription-batch-unsubscribe-loading");Mf(b,ad);var c={};c.c=b.join(",");var d=function(){F("subscription-batch-unsubscribe-loaded");Mf(b,bd)};
Hc("/subscription_ajax?action_remove_subscriptions=1",{method:"POST",C:c,F:function(){d();Mf(b,L);a.length&&Gf(a)},
onError:function(){d()}})}}
function Mf(a,b){w(a,function(a){F(b,new J(a))})}
function Nf(a,b){var c=sc(a),d;for(d in c)b[d]=c[d]}
;u("yt.setConfig",Bb);u("ytbin.www.subscribeembed.init",function(){xf=!0;yf.push(G(Wc,zf),G($c,Bf));xf||yf.push(G(Zc,zf),G(cd,Bf),G(Uc,Df),G(Vc,Ff),G(fd,Hf),G(tf,Jf),G(vf,Lf),G(sf,Kf));var a=V.A(),b=Q(a);b in Xd||(a.register(),a.L.push(zc("yt-uix-init-"+b,a.init,a)),a.L.push(zc("yt-uix-dispose-"+b,a.dispose,a)),Xd[b]=a);hf()});}).call(this);
