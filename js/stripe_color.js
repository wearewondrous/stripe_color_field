jQuery(function ($) {
  'use strict';

  function init() {
    var $wrappers = $('.stripe-color-wrapper');

    if (!$wrappers.length) {
      return;
    }

    $wrappers.each(function () {
      var select = this.querySelector('select');
      var indicator = this.querySelector('.stripe-color-indicator');
      var options = {};

      [].forEach.call(select.options, function (item) {
        options[item.value] = item.getAttribute('data-color-code');
      });

      $(select).on('change', function () {
        indicator.style.backgroundColor = options[this.value];
      });
    });
  }

  init();

  $(document).ajaxComplete(init);
});
