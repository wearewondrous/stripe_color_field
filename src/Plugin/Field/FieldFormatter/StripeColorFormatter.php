<?php

/**
 * @file
 * Contains \Drupal\stripe_color_field\Plugin\Field\FieldFormatter\StripeColorFormatter.
 */

namespace Drupal\stripe_color_field\Plugin\Field\FieldFormatter;

use Drupal\Core\Field\FieldItemListInterface;
use Drupal\Core\Field\FormatterBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Plugin implementation of the 'stripe_color_formatter' formatter.
 *
 * @FieldFormatter(
 *   id = "stripe_color_formatter",
 *   label = @Translation("Stripe Color formatter"),
 *   field_types = {
 *     "stripe_color_type"
 *   }
 * )
 */
class StripeColorFormatter extends FormatterBase {
  /**
   * {@inheritdoc}
   */
  public static function defaultSettings() {
    return array(// Implement default settings.
    ) + parent::defaultSettings();
  }

  /**
   * {@inheritdoc}
   */
  public function settingsForm(array $form, FormStateInterface $form_state) {
    return array(// Implement settings form.
    ) + parent::settingsForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
  public function settingsSummary() {
    $summary = [];
    // Implement settings summary.

    return $summary;
  }

  /**
   * {@inheritdoc}
   */
  public function viewElements(FieldItemListInterface $items, $langcode) {
    $element = array();

    foreach ($items as $delta => $item) {
      // Render each element as markup.
      $element[$delta] = array(
        '#type' => 'markup',
        '#markup' => $item->value,
      );
    }

    return $element;
  }
}
