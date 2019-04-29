var myOptions = {
  defaultColor: true,
  change: function(event, ui) {},
  clear: function() {},
  hide: true,
  palettes: true
};

$('.my-color-field').wpColorPicker(myOptions);

// Options page tabs
jQuery(document).ready(function($) {

  // Tabs
  var $navs = $('.nav-tab'),
    $tabs = $('.tabs'),
    toogle = function(hash) {
      location.hash = hash || '';
      var hash = hash || $('a', $navs).context[0].hash;
      $navs.removeClass('nav-tab-active');
      var $a = hash ? $('a[href="' + hash + '"]') : $('a:first-child', $navs);
      $a.addClass('nav-tab-active');
      $tabs.hide();
      $(hash).show();
    };
  toogle(window.location.hash);

  $navs.on('click', function(e) {
    e.preventDefault();
    var hash = e.target.hash;
    toogle(hash);
    history.replaceState({
      page: hash
    }, 'title ' + hash, hash);
  });

});
