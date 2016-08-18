<?php

/**
 * @file
 * Contains \Drupal\stripe_color_field\Plugin\Field\FieldWidget\StripeColorWidget.
 */

namespace Drupal\stripe_color_field\Plugin\Field\FieldWidget;

use Drupal\Core\Field\FieldItemListInterface;
use Drupal\Core\Field\WidgetBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Plugin implementation of the 'stripe_color_widget' widget.
 *
 * @FieldWidget(
 *   id = "stripe_color_widget",
 *   label = @Translation("Stripe Color Field Widget"),
 *   field_types = {
 *     "stripe_color_type"
 *   }
 * )
 */
class StripeColorWidget extends WidgetBase {
  /**
   * {@inheritdoc}
   */
  public static function defaultSettings() {
    return parent::defaultSettings();
  }

  /**
   * {@inheritdoc}
   */
  public function formElement(FieldItemListInterface $items, $delta, array $element, array &$form, FormStateInterface $form_state) {
    $configService = \Drupal::service('config.storage');
    $custom_colors_config = $configService->read('stripe_color_field.settings')['custom'];
    $select_options = [];

    foreach ($custom_colors_config as $color_config) {
      if (!$color_config) {
        continue;
      }

      $select_options[$color_config['key']] = $color_config['display_name'];
    }

    $element['value'] = [
      '#title' => $this->t('Color'),
      '#type' => 'select',
      '#default_value' => isset($items[$delta]->value) ? $items[$delta]->value : NULL,
      '#options' => $select_options,
      '#custom_colors_config' => $this->convertConfig($custom_colors_config),
      '#theme' => 'stripe_color_select',
    ];

    return $element;
  }


  private function convertConfig($custom_colors_config) {
    $array = [];

    foreach ($custom_colors_config as $color_config) {
      $array[$color_config['key']] = [
        'display_name' => $color_config['display_name'],
        'code' => $color_config['code'],
      ];
    }

    return $array;
  }
}
