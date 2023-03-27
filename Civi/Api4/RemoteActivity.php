<?php

namespace Civi\Api4;

use Civi\Api4\Generic\AbstractEntity;
use Civi\RemoteActivity\Api4\Action\Remote\DAOGetAction;
use Civi\RemoteActivity\Api4\Permissions;
use Civi\RemoteActivity\Api4\Action\Remote\GetFieldsAction;
use Civi\RemoteTools\Api4\Traits\EntityNameTrait;

class RemoteActivity extends AbstractEntity {

  use EntityNameTrait;

  /**
   * @inheritDoc
   */
  public static function getFields() {
    return new GetFieldsAction(static::getEntityName(), __FUNCTION__);
  }

  public static function get(): DAOGetAction {
    return new DAOGetAction(static::getEntityName());
  }

  /**
   * @inheritDoc
   *
   * @return array<string, array<string|string[]>>
   *
   * @noinspection PhpMissingParentCallCommonInspection
   */
  public static function permissions(): array {
    return [
      'meta' => [Permissions::ACCESS_REMOTEACTIVITY],
      'default' => [Permissions::ACCESS_REMOTEACTIVITY],
    ];
  }

}
