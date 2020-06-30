var hc4HcaParam = 'hca';

function hc4AjaxGetUrlVars( href )
{
	var vars = {};
	var parts = href.replace(/[?&]+([^=&]+)=([^&]*)/gi,
	function(m,key,value){
		value = decodeURIComponent( value );
		vars[key] = value;
	});
	return vars;
}

var hc4FireEvent = function( eventName )
{
	var event; // The custom event that will be created
	if( document.createEvent ){
		event = document.createEvent("HTMLEvents");
		event.initEvent( eventName, true, true );
		event.eventName = eventName;
		document.dispatchEvent( event );
	}
	else {
		event = document.createEventObject();
		event.eventType = eventName;
		event.eventName = eventName;
		document.fireEvent( "on" + event.eventType, event );
	}
}

var hc4AjaxGet = function( url, success )
{
// console.log( 'hc4AjaxGet: ' + url );
	var xhr = window.XMLHttpRequest ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
	xhr.open( 'GET', url );
	xhr.onreadystatechange = function(){
		if (xhr.readyState>3 && xhr.status==200) success(xhr.responseText);
	};
	xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
	xhr.send();
	return xhr;
}

var hc4AjaxPost = function( url, data, success )
{
	var params = typeof data == 'string' ? data : Object.keys(data).map(
		function(k){ return encodeURIComponent(k) + '=' + encodeURIComponent(data[k]) }
		).join('&');

	var xhr = window.XMLHttpRequest ? new XMLHttpRequest() : new ActiveXObject("Microsoft.XMLHTTP");
	xhr.open( 'POST', url );
	xhr.onreadystatechange = function(){
		if (xhr.readyState>3 && xhr.status==200) { success(xhr.responseText); }
	};
	xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
	xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
	xhr.send(params);
	return xhr;
}
// example
// hc4Ajax.post('http://foo.bar/', 'p1=1&p2=Hello+World', function(data){ console.log(data); });
// example with data object
// hc4Ajax.post('http://foo.bar/', { p1: 1, p2: 'Hello World' }, function(data){ console.log(data); });

var hc4AjaxLink = function( el, target, rootTarget )
{
	this.click = function( e )
	{
		e.preventDefault();
		var href = e.target.getAttribute('href');
		href += '&hcs=zi2';

		target.style.display = "block";

		if( (typeof hc4AjaxModal != 'undefined') && (target == hc4AjaxModal.contentBox) ){
			hc4AjaxModal.contentProgressBar.animateRun();
		}
		else {
			target.innerHTML = 'Loading ... <br>' + target.innerHTML;
		}

		hc4AjaxGet( href, function(data){
			hc4AjaxResult( data, target, rootTarget );
		});

		return false;
	}

	el.addEventListener( 'click', this.click );
}

var hc4AjaxForm = function( el, target, rootTarget )
{
	var self = this;

	this.submit = function( e )
	{
		var href = e.target.getAttribute('action');
		e.preventDefault();

		// target.style.display = "block";
		if( (typeof hc4AjaxModal != 'undefined') && (target == hc4AjaxModal.contentBox) ){
			hc4AjaxModal.contentProgressBar.animateRun();
		}
		else {
			target.innerHTML = 'Loading ... <br>' + target.innerHTML;
		}

		var data = self.serialize();
		// console.log( data );
		// data += '&' + hcsName + '=' + hcsValue;

		hc4AjaxPost( href, data, function(data){
			hc4AjaxResult( data, target, rootTarget );
		});

		return false;
	}

	this.serialize = function()
	{
		var form = el;

		var field, l, s = [];
		if (typeof form == 'object' && form.nodeName == "FORM") {
			var len = form.elements.length;
			for (var i=0; i<len; i++) {
				field = form.elements[i];
				if (field.name && !field.disabled && field.type != 'file' && field.type != 'reset' && field.type != 'submit' && field.type != 'button') {
					if (field.type == 'select-multiple') {
						l = form.elements[i].options.length; 
						for (var j=0; j<l; j++) {
							if(field.options[j].selected)
								s[s.length] = encodeURIComponent(field.name) + "=" + encodeURIComponent(field.options[j].value);
						}
					} else if ((field.type != 'checkbox' && field.type != 'radio') || field.checked) {
						s[s.length] = encodeURIComponent(field.name) + "=" + encodeURIComponent(field.value);
					}
				}
			}
		}
		return s.join('&').replace(/%20/g, '+');
	}

	el.addEventListener( 'submit', this.submit );
}

var hc4AjaxResult = function( data, target, rootTarget )
{
	this.scan = function()
	{
		var ii = 0;

		var links = target.getElementsByTagName('a');
		for( ii = 0; ii < links.length; ii++ ){
			hc4AjaxLink( links[ii], target, rootTarget );
		}

		var forms = target.getElementsByTagName('form');
		for( ii = 0; ii < forms.length; ii++ ){
			hc4AjaxForm( forms[ii], target, rootTarget );
		}
	}

	this.parse = function()
	{
		var ii = 0;

	// run inline JavaScript
		var scripts = target.getElementsByTagName('script');
		for( ii = 0; ii < scripts.length; ii++ ){
			var src = scripts[ii].getAttribute('src');
			if( src ){
				var s = document.createElement('script');
				s.setAttribute( 'src', src );
				document.head.appendChild( s );
			}
			else {
				eval( scripts[ii].innerHTML );
			}
		}
	}

	var searchRedirectTag = 'hc4redirect';
	var startPos = data.indexOf( '<' + searchRedirectTag + '>' );
	if( startPos > -1 ){
		var endPos = data.indexOf( '</' + searchRedirectTag + '>' );
		var toHref = data.substring( startPos + searchRedirectTag.length + 2, endPos );
		var toHca = hc4AjaxGetUrlVars( toHref )[hc4HcaParam];

		if( typeof self.windowHca == 'undefined' ){
			self.windowHca = hc4AjaxGetUrlVars( window.location.href )[hc4HcaParam];
		}

		if( self.windowHca == toHca ){
			if( rootTarget ){
				toHref += '&hcs=zi2';

				hc4AjaxGet( toHref, function(data){
					hc4AjaxResult( data, rootTarget, rootTarget );
					target.innerHTML = '';
					target.style.display = 'none';
					if( typeof hc4AjaxModal != 'undefined' ){
						hc4AjaxModal.style.display = 'none';
						hc4AjaxModal.contentProgressBar.animateStop();
					}
				});
			}
			else {
				window.location.href = toHref;
			}
		}
		else {
			hc4AjaxGet( toHref, function(data){
				hc4AjaxResult( data, target, rootTarget );
			});
		}
	}
	else {
// console.log( data );
		target.innerHTML = data;

		// target.scrollIntoView();
		if( target != rootTarget ){
			this.scan();
		}
		this.parse();

		if( (typeof hc4AjaxModal != 'undefined') && (target == hc4AjaxModal.contentBox) ){
			hc4AjaxModal.contentContainer.scrollIntoView();
			hc4AjaxModal.contentProgressBar.animateStop();
		}
	}
}

var hc4AjaxModal;
var hc4AjaxModalLink = function( el, rootTarget )
{
	if( typeof hc4AjaxModal == 'undefined' ){
		hc4AjaxModal = document.createElement('div');
		hc4AjaxModal.style.cssText = 'display:none;position:fixed;z-index:99999;left:0;top:0;width:100%;height:100%;overflow:auto;background-color:rgb(0,0,0);background-color:rgba(0,0,0,0.4);';

		hc4AjaxModal.contentContainer = document.createElement('div');
		hc4AjaxModal.contentContainer.style.cssText = 'position:relative;margin:15% auto;width:90%;background-color:white;';
		var bodyStyle = window.getComputedStyle( document.body );
		hc4AjaxModal.contentContainer.style.backgroundColor = bodyStyle.backgroundColor;

		hc4AjaxModal.contentProgress = document.createElement('div');

		hc4AjaxModal.contentProgressBar = document.createElement('div');
		hc4AjaxModal.contentProgressBar.innerHTML = '&nbsp;';
		hc4AjaxModal.contentProgressBar.style.cssText = 'font-size:.5em;width:1%;background-color:#bbb;';

		hc4AjaxModal.contentProgressBar.animateRun = function(){
			var self = this;
			var width = 0;
			this.animation = setInterval( frame, 10 );
			function frame(){
				if (width >= 100) {
					width = 0;
				} else {
					width += 1;
					self.style.width = width + '%';
				}
			}
		}

		hc4AjaxModal.contentProgressBar.animateStop = function(){
			clearInterval( this.animation );
			this.style.width ='0%';
		}

		hc4AjaxModal.contentProgress.appendChild( hc4AjaxModal.contentProgressBar );
		hc4AjaxModal.contentContainer.appendChild( hc4AjaxModal.contentProgress );

		hc4AjaxModal.contentBox = document.createElement('div');
		hc4AjaxModal.contentBox.style.cssText = 'padding:0 2em 2em 2em;';

		hc4AjaxModal.closer = document.createElement('div');
		hc4AjaxModal.closer.innerHTML = '&times;';
		hc4AjaxModal.closer.style.cssText = 'position:absolute;right:0;top:0;font-size:3em;padding:0 .5em;';
		hc4AjaxModal.closer.className = 'hc-cursor-pointer';
		hc4AjaxModal.closer.addEventListener( 'click', function(e){
			hc4AjaxModal.contentBox.innerHTML = '';
			hc4AjaxModal.style.display = 'none';
		});

		hc4AjaxModal.contentContainer.appendChild( hc4AjaxModal.closer );
		hc4AjaxModal.contentContainer.appendChild( hc4AjaxModal.contentBox );

		hc4AjaxModal.appendChild( hc4AjaxModal.contentContainer );
		document.body.appendChild( hc4AjaxModal );

		hc4AjaxModal.addEventListener( 'click', function(event){
			if( event.target == hc4AjaxModal ){
				hc4AjaxModal.style.display = "none";
			}
		});
	}

	hc4AjaxLink( el, hc4AjaxModal.contentBox, rootTarget );

	this.click = function( e )
	{
		hc4AjaxModal.style.display = 'block';
		return false;
	}

	el.addEventListener( 'click', this.click );
}