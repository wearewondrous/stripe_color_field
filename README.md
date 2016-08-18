# stripe_color_field

Drupal 8 module. Special Dropdown to indicate color of a stripe.

# Usage

After install you will find a ne field Type. Use as desired. We normally add it to a Paragraph called stripe.
Then in the `paragraph--stripe.html.twig` we put the following:

``` twig
{% set classes = [
    'panel',
    content.field_stripe_color['#items'].getValue|first.value
  ]
%}

<section {{ attributes.addClass(classes) }} id="stripe-id-{{ paragraph.id() }}">
  {{ content.field_headline }}
  {{ content.field_inner_paragraphs }}
</section>

```

# Credits

code base: [github.com/WondrousLLC/stripe_color_field](https://github.com/WondrousLLC/stripe_color_field/)

developed by [WONDROUS LLC](https://www.wearewondrous.com/)