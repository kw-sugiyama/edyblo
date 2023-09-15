
  var nArr = {
               "menu01" : "#nav01, #nav02, #nav03",
               "menu02" : "#nav04, #nav05, #nav06, #nav07",
               "menu03" : "#nav08, #nav09",
               "menu04" : "#nav10, #nav11"
             };
  
  $(function(){
    $("#nav dt").click(function(){
      toggleNav($(this).attr("id"), 300);
    });
	$("#nav dt#menu06").click(function(){
      location ="exam.html";
    });
    $("#nav dt").css({
      cursor: "pointer"
    });
  });
  function toggleNav(n, s){
    $('#nav dd').hide();
    $('#nav12, #nav13').show();
    $(nArr[n]).show(s);
  }