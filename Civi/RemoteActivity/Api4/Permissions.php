<?php
declare(strict_types = 1);

namespace Civi\RemoteActivity\Api4;

final class Permissions {

  /**
   * CiviCRM core permission.
   *
   * @see \CRM_Core_Permission::getCorePermissions For CiviCRM core permissions.
   */
  public const ACCESS_CIVICRM = 'access CiviCRM';

  public const ACCESS_REMOTEACTIVITY = 'access CiviRemote Activity';

}
