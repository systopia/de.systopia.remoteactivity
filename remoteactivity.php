<?php
declare(strict_types = 1);

// phpcs:disable PSR1.Files.SideEffects
require_once 'remoteactivity.civix.php';
// phpcs:enable

use Civi\Remoteactivity\Api4\Permissions;
use Civi\Remoteactivity\RemoteActivityDefaultEntityProfile;
use Civi\RemoteTools\EntityProfile\ReadOnlyRemoteEntityProfile;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use CRM_Remoteactivity_ExtensionUtil as E;

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
  if (class_exists(ReadOnlyRemoteEntityProfile::class)) {
    $container->autowire(RemoteActivityDefaultEntityProfile::class)
      ->addTag(RemoteActivityDefaultEntityProfile::SERVICE_TAG);
  }
}

/**
 * Implements hook_civicrm_permission().
 *
 * @phpstan-param array<string, string|array{string, string}> $permissions
 */
function remoteactivity_civicrm_permission(array &$permissions): void {
  $permissions[Permissions::ACCESS_REMOTE_ACTIVITY] = [
    'label' => E::ts('CiviCRM: remote access to Activity'),
    'description' => E::ts('Access remote API of the Activity entity'),
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
