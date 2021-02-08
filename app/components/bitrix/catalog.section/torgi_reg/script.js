function create_ajax_() {
  if (window.XMLHttpRequest) {
    return new XMLHttpRequest();
  } else if (window.ActiveXObject) {
    var _vr =  ['MSXML2.XMLHttp.5.0','MSXML2.XMLHttp.4.0','MSXML2.XMLHttp.3.0','MSXML2.XMLHTTP','Microsoft.XMLHTTP'];
    for (var i=0;i<_vr.length;i++) try {		  
	  var q = new ActiveXObject(_vr[i]);
	  if (q!=undefined&&q!=null) return q;
    } catch (e) {  };
  };
  return undefined;
};

function addNewEvent_(eve,func,obj) {
  obj = obj || document.documentElement || document.body;
  var oldEvent = obj[eve];
  if (!oldEvent) oldEvent = obj['on'+eve];
  if (obj.addEventListener) { obj.addEventListener(eve,func,false); }
  else if (obj.attachEvent) obj.attachEvent('on'+eve,func);
  else { if (typeof(oldEvent)=='function') obj['on'+eve] = function(e) { var r = oldEvent(e); if (r===true||r==undefined||r===1) return func(e); else return false; }; else obj['on'+eve] = func; };
};
addNewEvent_('load',function() {
  var a = document.getElementsByTagName('A');
  var c = 0;
  for (var i=0;i<a.length;i++) if (a[i].href.indexOf('?ELEMENT_ID=')>-1) addNewEvent_('click',function(e) {
    e = e || window.event;	if (!e) return false;
	var el = (!e.srcElement) ? e.target : e.srcElement;
	while (el.nodeName!='A') el = el.parentNode;
	var td = el.parentNode;
	el.style.visibility = 'hidden';
	td.className = 'aloader';
    var query = create_ajax_();
	var timerId = 0;
    if (query==undefined||query==null) return true;
    query.onreadystatechange = function() {
      if (query.readyState == 4) {
        if (query.status==200) {
		  clearTimeout(timerId);
		  td.className = '';
	      var div = document.createElement('DIV'); div.style.position = 'absolute'; div.style.visibility = 'hidden'; div.style.left = '0px'; div.style.top = '0px';
		  div.innerHTML = query.responseText;
		  document.body.appendChild(div);
		  var eh = div.offsetHeight;
		  document.body.removeChild(div);
		  div.style.position = 'relative';  
		  var ch = el.offsetHeight;
		  div.style.height = ch.toString()+'px'; 
		  div.style.overflow = 'hidden'; 
		  div.style.visibility = 'visible';
		  var co = 0;
		  if (document.all) div.style.filter = 'alpha(Opacity=0)'; else  div.style.opacity = 0;
		  el.parentNode.replaceChild(div,el);
	          var ho = 5;
                  var coo = 100/((eh - ch) / ho);
		  var sInterval = setInterval(function() {
		    co = parseInt(Math.min(100,co+coo));
		    ch = Math.min(eh,ch+ho);
		    if (ch>=eh&&co==100) clearInterval(sInterval);
		    div.style.height = parseInt(ch).toString()+'px';
		    if (document.all) div.style.filter = 'alpha(Opacity='+co.toString()+')'; else  div.style.opacity = (co/100).toString();
		  },35); // время открытия
		}
	  }
	}
    query.open('GET',el.href.substr(0,el.href.indexOf('#'))+'&file_list',true);
    query.send(null);
    timerId = setTimeout(function() { query.abort(); location.replace(el.href); },5000);
    e.returnValue = false;
    if (e.stopPropagation) e.stopPropagation();
    if (e.preventDefault) e.preventDefault();
	return false;
  },a[i]);
},window);