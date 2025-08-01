<?php
declare(strict_types = 1);

// phpcs:disable PSR1.Files.SideEffects
require_once 'remoteactivity.civix.php';
// phpcs:enable

use Civi\Remoteactivity\Api4\Permissions;
use CRM_Remoteactivity_ExtensionUtil as E;
use Symfony\Component\DependencyInjection\ContainerBuilder;

/**
 * Implements hook_civicrm_config().
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_config/
 */
function remoteactivity_civicrm_config(&$config): void {
  _remoteactivity_civix_civicrm_config($config);
}

/**
 * Implements hook_civicrm_container().
 */
function remoteactivity_civicrm_container(ContainerBuilder $container): void {
  if (function_exists('_remoteactivity_test_civicrm_container')) {
    _remoteactivity_test_civicrm_container($container);
  }
}

/**
 * Implements hook_civicrm_permission().
 *
 * @phpstan-param array<string, string|array{string, string}> $permissions
 */
function remoteactivity_civicrm_permission(array &$permissions): void {
  $permissions[Permissions::ACCESS_REMOTE_ACTIVITY] = [
    'label' => E::ts('CiviRemote: remote access to Activity'),
    'description' => E::ts('Access remote API of the Activity entity.'),
  ];
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
