  
  /**
   * 
   * snap.js
   * 
   */
  
  
  var snap_margin    = 5;
  var borderColor   = '#333';
  
  
  var snap_captionCSS = {
                         color           : '#fff',
                         margin          : 0 + 'px',
                         padding         : 0 + 'px',
                         fontSize        : 24 + 'px',
                         textAlign       : 'center'
                       };
  var snap_wrapperCSS    = {
                         display         : 'none',
                         position        : 'fixed',
                         top             : '50%',
                         left            : '50%',
                         zIndex          : 102,
                         margin          : 0 + 'px',
                         padding         : 0 + 'px'
                       };
  var snap_bodyCSS    = {
                         margin          : 0 + 'px',
                         padding         : snap_margin + 'px',
                         backgroundColor : borderColor
                       };
  var snap_bgCSS      = {
                         position        : 'fixed',
                         top             : 0 + 'px',
                         left            : 0 + 'px',
                         margin          : 0 + 'px',
                         padding         : 0 + 'px',
                         zIndex          : 100,
                         width           : '100%',
                         height          : '100%',
                         backgroundColor : '#666',
                         opacity         : 0.75
                       };
  var o               = {
                         width           : 600,
                         height          : 585
                        }
  
  
  $(function(){
    
    snap_init();
    
  });
  
  function snap_init ()
  {
    
    $('a.snap').each(function(){
      var f = $(this).attr("href");
      var t = $(this).attr("title");
      $(this).attr('href', '');
      $(this).click(function(){
        snap(f,t);
        this.blur();
        return false;
      });
    });
    
  }
  
  function snap (file,caption)
  {
    
    try {
      
      if (typeof document.body.style.maxHeight === "undefined")
      {
        
        // if IE 6
        $('body, html').css({height: "100%", width: "100%"});
        $('html').css("overflow","hidden");
        if (document.getElementById("snap_HideSelect") === null) {//iframe to hide select elements in ie6
          $("body").append("<div id='snap_bg'></div><div id='snap_wrapper'></div>");
          $("#snap_bg").css(snap_bgCSS);
          $("#snap_bg").css({
                             width: document.body.scrollWidth + 'px',
                             height: document.body.scrollHeight + 'px'
                           });
          $("#snap_bg").click(snap_close);
        }
        
        $("#snap_wrapper").css(snap_wrapperCSS);
        $("#snap_bg, #snap_wrapper").css({position: 'absolute'});
        
      }
      else
      {
        
        //all others
        if(document.getElementById('snap_bg') === null){
          $("body").append("<div id='snap_bg'></div><div id='snap_wrapper'></div>");
          $("#snap_bg").css(snap_bgCSS);
          $("#snap_bg").click(snap_close);
        }
        $("#snap_wrapper").css(snap_wrapperCSS);
        
      }
      
      
      var t  = '<div id="snap_caption">' + caption + '</div>\n';
          t += '<div id="snap_body">\n';
          t += '<img src="' + file + '" ';
          t += 'width="' + o["width"] + '" height="' + o["height"] + '" />\n';
          t += '</div>\n';
      
      $("#snap_wrapper").html(t);
      $("#snap_caption").css(snap_captionCSS);
      $("#snap_body").css(snap_bodyCSS);
      
      $("#snap_wrapper").width(o["width"] + snap_margin * 2);
      
      $("#snap_wrapper").css({
                           display      : 'block',
                           marginLeft   : - $("#snap_wrapper").width() / 2 + 'px',
                           marginTop    : - $("#snap_wrapper").height() / 2 + 'px',
                           top          : '100%',
                           opacity      : 0
                         });
      $("#snap_wrapper").animate({
                               top     : '50%',
                               opacity  : 1
                             },
                             1000
                             );
      
      
      
    } catch ( e )
    {
      
    }
    
  }
  
  
  
  function snap_close ()
  {
    
    $('#imageOff, #closeButton').unbind('click');
    
    $('#snap_wrapper').fadeOut("fast",function(){
      $('#snap_wrapper, #snap_bg').trigger("unload").unbind().remove();
    });
    $("#load").remove();
    
    if (typeof document.body.style.maxHeight == "undefined") {//if IE 6
      $('body, html').css({height: "auto", width: "auto"});
      $('html').css('overflow', '');
    }
    document.onkeydown = "";
    document.onkeyup = "";
    return false;
    
  }