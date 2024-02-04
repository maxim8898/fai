isDOM=document.getElementById //DOM1 browser (MSIE 5+, Netscape 6, Opera 5+)
isMSIE=document.all && document.all.item //Microsoft Internet Explorer 4+
isNetscape4=document.layers //Netscape 4.*
isOpera=window.opera //Opera
isOpera5=isOpera && isDOM //Opera 5+
isMSIE5=isDOM && isMSIE && !isOpera //MSIE 5+
isMozilla=isNetscape6=isDOM && !isMSIE && !isOpera

var obj;

function getLayer(layerName, parentLayerName){
  if(isDOM){ return document.getElementById(layerName); }
  if(isMSIE){ return document.all[layerName]; }
  if(isNetscape4){ return eval('document.layers[layerName]'); }
  return false;
}

function la(i,what){
  mousex = i.clientX;
  mousey = i.clientY;
  pagexoff = 0;
  pageyoff = 0;
  if(isMSIE5){
    pagexoff = document.body.scrollLeft;
    pageyoff = document.body.scrollTop;
  }
  else{
    pagexoff = window.pageXOffset;
     pageyoff = window.pageYOffset;
  }
  if(getLayer(what)){
    if(isNetscape4)
      obj = getLayer(what);
    else
      obj = getLayer(what).style;
 	
  	if(obj){
	    leftoff = mousex-pagexoff;
    	obj.left = (mousex+pagexoff);
  
	    topoff = mousey-pageyoff;
    	if(isOpera && topoff <= 30)
    	  obj.top = mousey + 20;
	    else 
		if( mousey <= 30) 
	        obj.top = (mousey+pageyoff) + 20;
		else 
	      if (isOpera) 
    	    obj.top = mousey + 20;
	    else
    	  obj.top = (mousey+pageyoff) + 20;
   		
		
	    if(isNetscape4)
    	  obj.visibility = 'show';
	    else
    	  obj.visibility = 'visible';
	  }
   }
  return true;
}

function lac(){
  if(obj){
    if(isNetscape4)
      obj.visibility = 'hide';
    else
      obj.visibility='hidden';
  }
  return true
}
function foo() {

}

var theSelection = false;
var agent = navigator.userAgent.toLowerCase();
var version = parseInt(navigator.appVersion);
var is_ie = ((agent.indexOf("msie") != -1) && (agent.indexOf("opera") == -1));
var is_nav  = ((agent.indexOf('mozilla')!=-1) && (agent.indexOf('spoofer')==-1)
                && (agent.indexOf('compatible') == -1) && (agent.indexOf('opera')==-1)
                && (agent.indexOf('webtv')==-1) && (agent.indexOf('hotjava')==-1));
var is_win   = ((agent.indexOf("win")!=-1) || (agent.indexOf("16bit") != -1));
var is_mac    = (agent.indexOf("mac")!=-1);
tagscode = new Array();
tags = new Array('[b]','[/b]','[i]','[/i]','[u]','[/u]','[Quote]','[/Quote]','[Center]','[/Center]');
function getarraysize(thearray) {
	for (i = 0; i < thearray.length; i++) {
		if ((thearray[i] == "undefined") || (thearray[i] == "") || (thearray[i] == null))
			return i;
		}
	return thearray.length;
}
function arraypush(thearray,value) {
	thearray[ getarraysize(thearray) ] = value;
}
function arraypop(thearray) {
	thearraysize = getarraysize(thearray);
	retval = thearray[thearraysize - 1];
	delete thearray[thearraysize - 1];
	return retval;
}

function TagsStyle(number) {
	donotinsert = false;
	theSelection = false;
	last = 0;
	if (number == -1) {
		while (tagscode[0]) {
			butnumber = arraypop(tagscode) - 1;
			document.post.ftext.value += tags[butnumber + 1];
			buttext = eval('document.post.addtagscode' + butnumber + '.value');
			eval('document.post.addtagscode' + butnumber + '.value ="' + buttext.substr(0,(buttext.length - 1)) + '"');
		}
		document.post.ftext.focus();
		return;
	}
	if ((version >= 4) && is_ie && is_win)
	theSelection = document.selection.createRange().text;
	if (theSelection) {
		document.post.ftext.focus();
		document.selection.createRange().text = tags[number] + theSelection + tags[number+1];
		with(document.selection.createRange()) 
		collapse(false),select(); 

		theSelection = '';
		return;
	}
	for (i = 0; i < tagscode.length; i++) {
		if (tagscode[i] == number+1) {
			last = i;
			donotinsert = true;
		}
	}
	if (donotinsert) {
		while (tagscode[last]) {
				butnumber = arraypop(tagscode) - 1;
				document.post.ftext.value += tags[butnumber + 1];
				imageTag = false;
			}
			document.post.ftext.focus();
			return;
	} else {
		document.post.ftext.value += tags[number];
		arraypush(tagscode,number+1);
		document.post.ftext.focus();
		return;
	}
	storeCaret(document.post.ftext);
}

function storeCaret(textEl) {
	if (textEl.createTextRange) textEl.caretPos = document.selection.createRange().duplicate();
}

function new_window(new_url){
//window.open(new_url, "new"+new_url,"toolbar=no, scrollbars=yes, directories=no, status=no, menubar=yes, resizable=yes, location=no, width=820, height=800");
window.open(new_url, "_blank","toolbar=no, scrollbars=yes, directories=no, status=no, menubar=yes, resizable=yes, location=no, width=820, height=800");

//window.close();

}
