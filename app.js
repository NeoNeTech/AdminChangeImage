var myOptions = {
  defaultColor: true,
  change: function(event, ui) {},
  clear: function() {},
  hide: true,
  palettes: true
};

$('.my-color-field').wpColorPicker(myOptions);

$(document).ready(function(){
  $("#informations").hide();
  $("#option-click").click(function(){
    $("#options").show();
    $("#informations").hide();
  });
  $("#info-click").click(function(){
    $("#options").hide();
    $("#informations").show();
  });
});
