 var
 mouse_on_color = '#c00',             // マウスオンの文字色
 mouse_on_background_color = '',  // マウスオンの背景色
 mouse_out_color = '#06c',            // マウスアウトの文字色
 mouse_out_background_color = ''; // マウスアウトの背景色

function setToggleFunc() {

 var elm;

 if ( document.getElementsByTagName ) {
  for ( var i=1;elm=(document.getElementsByTagName( "*" )[i]);i++ ) {
   if ( !elm.className ) continue;
   if ( elm.parentNode.firstChild == elm ) {
    elm.className.replace( /\bjs_[open|close]\b/, '' );
    continue;
   }
   if ( !elm.className.match(/js_[open|close]/) ) continue;
   var objTrigger = elm.previousSibling;

   while( !objTrigger || objTrigger.nodeType != 1 ) {
    objTrigger = objTrigger.previousSibling;
   }
   if ( !objTrigger ) continue;

   objTrigger.style.cursor = 'pointer';
   objTrigger.className += ' js_mouse_out';
   objTrigger.title += ( elm.className.match(/js_close/) ) ? '' : '';
   
   objTrigger.onclick = function () {
    var objTarget = this.nextSibling;
    while ( objTarget.nodeType != 1 ) {
     objTarget = objTarget.nextSibling;
    }

    objTarget.flag = objTarget.className.match(/js_close/);
    if ( objTarget.flag ) {
     objTarget.className = objTarget.className.replace( /\bjs_close\b/, 'js_open' );
     this.title = this.title.replace( /click to open/, 'click to close' );
    } else {
     objTarget.className = objTarget.className.replace( /\bjs_open\b/, 'js_close' );
     this.title = this.title.replace( /click to close/, 'click to open' );
    }
   }

   objTrigger.onmouseover = function () {
    this.className = this.className.replace( /\bjs_mouse_out\b/, 'js_mouse_on' );
    //this.style.color = mouse_on_color;
    //this.style.backgroundColor = mouse_on_background_color;
   }

   objTrigger.onmouseout = function () {
    this.className = this.className.replace( /\bjs_mouse_on\b/, 'js_mouse_out' );
    this.style.color = mouse_out_color;
    this.style.backgroundColor = mouse_out_background_color;
   }

  }
 }
}

var _OK = false;
if ( navigator.appVersion.match( /MSIE (\d+\.\d+)/i ) ) {
 if ( ( RegExp.$1+0 ) >= 5.5 ) _OK = true;
} else _OK = true

function window_onload( f ) {
 if ( _OK ) {
  if ( window.addEventListener ) {
   window.addEventListener( "load", f, false );
  } else if ( window.attachEvent ) {
   window.attachEvent( "onload", f );
  }
 }
}

window_onload( setToggleFunc );

with ( document ) {
 if ( _OK && getElementsByTagName ) {
  var s = "<style type='text\/css'> .js_open { display: block} .js_close { display: none; } .js_mouse_on { color: " + mouse_on_color + " !important; background-color: " + mouse_on_background_color + " !important; } .js_mouse_out { color: " + mouse_out_color + " !important; background-color: " + mouse_out_background_color + " !important; }<\/style>";
  write(s);
 }
}
