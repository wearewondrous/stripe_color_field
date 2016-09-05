(function ($, Drupal) {
  'use strict';

  function init(context) {
    var $wrappers = $('.stripe-color-wrapper', context);

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

  Drupal.behaviors.stripeColorField = {
    attach: init
  };
})(jQuery, Drupal);
