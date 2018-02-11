<?php

namespace Drupal\borderless_grid_pages\Form;

use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;

class SettingsForm extends ConfigFormBase {

    private $baseName = 'borderless_grid_pages';

    /**
     * {@inheritdoc}
     */
    public function getFormId() {
        return $this->baseName . '_settings';
    }

    /**
     * {@inheritdoc}
     */
    public function buildForm(array $form, FormStateInterface $form_state) {
        $form = parent::buildForm($form, $form_state);
        $config = $this->config($this->getEditableConfigNames()[0]);
        $form['theme_machine_name'] = array(
            '#type' => 'textfield',
            '#title' => $this->t('Theme machine name'),
            '#default_value' => $config->get('theme_machine_name'),
            '#description' => $this->t('The machine name of the borderless theme to use'),
        );
        return $form;
    }

    /**
     * {@inheritdoc}
     */
    public function validateForm(array &$form, FormStateInterface $form_state) {

    }

    /**
     * {@inheritdoc}
     */
    public function submitForm(array &$form, FormStateInterface $form_state) {
        $config = $this->config($this->getEditableConfigNames()[0]);
        $config->set('theme_machine_name', $form_state->getValue('theme_machine_name'));
        $config->save();
        parent::submitForm($form, $form_state);
    }

    /**
     * {@inheritdoc}
     */
    protected function getEditableConfigNames() {
        return [
            $this->baseName . '.settings',
        ];
    }
}