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
  $("#preview").hide();
  $("#option-click").click(function(){
    $("#options").show();
    $("#informations").hide();
    $("#preview").hide();
  });
  $("#preview-click").click(function(){
    $("#options").hide();
    $("#informations").hide();
    $("#preview").show();
  });
  $("#info-click").click(function(){
    $("#options").hide();
    $("#informations").show();
    $("#preview").hide();
});
});

$( "#text-url" )
  .keyup(function() {
    var value = $( this ).val();
    $( "#imgOutput" ).attr( "src", value );
  })
  .keyup();

  $( "#bg-url" )
    .keyup(function() {
      var value = $( this ).val();
      $( "#bgOutput" ).attr( "src", value );
    })
    .keyup();
