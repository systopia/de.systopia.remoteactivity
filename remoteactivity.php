<?php

require_once 'remoteactivity.civix.php';
// phpcs:disable
use CRM_Remoteactivity_ExtensionUtil as E;
// phpcs:enable

/**
 * Implements hook_civicrm_config().
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_config/
 */
function remoteactivity_civicrm_config(&$config): void {
  _remoteactivity_civix_civicrm_config($config);
}

/**
 * Implements hook_civicrm_install().
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_install
 */
function remoteactivity_civicrm_install(): void {
  _remoteactivity_civix_civicrm_install();
}

/**
 * Implements hook_civicrm_enable().
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_enable
 */
function remoteactivity_civicrm_enable(): void {
  _remoteactivity_civix_civicrm_enable();
}
