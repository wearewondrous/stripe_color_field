<?php

/**
 * @file
 * Contains \Drupal\stripe_color_field\Form\StripeColorsForm.
 */

namespace Drupal\stripe_color_field\Form;

use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Component\Utility\Color as ColorUtility;

/**
 * Class StripeColorsForm.
 *
 * @package Drupal\stripe_color_field\Form
 */
class StripeColorsForm extends ConfigFormBase {

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'stripe_colors_form';
  }

  /**
   * {@inheritdoc}
   */
  protected function getEditableConfigNames() {
    return ['stripe_color_field.settings_custom'];
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $config = $this->config('stripe_color_field.settings');
    $setting_string = '';

    foreach ($config->get('custom') as $custom_color) {
      $setting_string .= isset($custom_color['key']) ? $custom_color['key'] . '|' . $custom_color['display_name'] . '|' . $custom_color['code'] : '';
      $setting_string .= "\r\n";
    }

    $form['description'] = [
      '#markup' => '<p>' . t('List of colors available in the dropdown.') . '</p>',
    ];

    $form['custom_colors'] = array(
      '#type' => 'textarea',
      '#title' => t('Color Codes'),
      '#cols' => 60,
      '#rows' => 8,
      '#resizable' => 'vertical',
      '#default_value' => $setting_string,
      '#description' => t("A list of classes that will be provided in the \"Stripe Color\" dropdown. Enter one or more classes on each line in the format: <code>class|Label|HEXcode</code>. Example: <code>white|White|#fff</code>.<br>These styles should be available in your theme's CSS file. Note: The provided hex color code will be used only in the backend display"),
    );

    return parent::buildForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
  public function validateForm(array &$form, FormStateInterface $form_state) {
    $custom_color_config = $this->getCustomColor($form_state->getValue('custom_colors'));

    foreach($custom_color_config as $color_config) {
      if (empty($color_config['key']) || empty($color_config['display_name']) || empty($color_config['code'])) {
        $form_state->setErrorByName('', t('<code>key</code>, <code>display_name</code> and <code>code</code> can not be empty.'));
      }

      try {
        if (!empty($color_config['code'])) {
          ColorUtility::rgbToHex(ColorUtility::hexToRgb($color_config['code']));
        }
      }
      catch (\InvalidArgumentException $e) {
        $form_state->setErrorByName('', t('<code>code</code> is not a valid color code.'));
      }
    }
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    parent::submitForm($form, $form_state);

    $custom_color_config = $this->getCustomColor($form_state->getValue('custom_colors'));

    \Drupal::configFactory()->getEditable('stripe_color_field.settings')
      ->set('custom', $custom_color_config)
      ->save();
  }

  private function getCustomColor($custom_colors_string) {
    $custom_colors_string_lines = array_filter(explode("\n", str_replace("\r\n", "\n", $custom_colors_string)), 'trim');
    $custom_color_config = [];

    foreach ($custom_colors_string_lines as $index => $line) {
      $line_settings = explode('|', $line, 3);

      if (isset($line_settings[0])) {
        $custom_color_config[$index]['key'] = $line_settings[0];
      }

      if (isset($line_settings[1])) {
        $custom_color_config[$index]['display_name'] = $line_settings[1];
      }

      if (isset($line_settings[2])) {
        $custom_color_config[$index]['code'] = $line_settings[2];
      }
    }

    return $custom_color_config;
  }
}
