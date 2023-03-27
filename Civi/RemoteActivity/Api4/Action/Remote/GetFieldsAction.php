<?php
/*
 * Copyright (C) 2022 SYSTOPIA GmbH
 *
 *  This program is free software: you can redistribute it and/or modify
 *  it under the terms of the GNU Affero General Public License as published by
 *  the Free Software Foundation in version 3.
 *
 *  This program is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU Affero General Public License for more details.
 *
 *  You should have received a copy of the GNU Affero General Public License
 *  along with this program.  If not, see <http://www.gnu.org/licenses/>.
 */

declare(strict_types = 1);

namespace Civi\RemoteActivity\Api4\Action\Remote;

use Civi\Core\CiviEventDispatcherInterface;
use Civi\RemoteActivity\Api4\Action\Remote\RemoteActivityActionInterface;
use Civi\RemoteActivity\Api4\Action\Remote\Traits\RemoteActivityActionContactIdTrait;
use Civi\RemoteActivity\Event\Remote\ActivityEvents;
use Civi\RemoteActivity\Event\Remote\GetFieldsEvent;
use Civi\RemoteTools\Api4\Action\EventGetFieldsAction;

class GetFieldsAction extends EventGetFieldsAction implements RemoteActivityActionInterface {

  use RemoteActivityActionContactIdTrait;

  public function __construct(string $entityName, string $actionName = 'getFields',
    CiviEventDispatcherInterface $eventDispatcher = NULL
  ) {
    parent::__construct(ActivityEvents::REQUEST_INIT_EVENT_NAME,
      ActivityEvents::REQUEST_AUTHORIZE_EVENT_NAME,
      $entityName, $actionName, $eventDispatcher);
  }

  /**
   * @noinspection PhpMissingParentCallCommonInspection
   */
  protected function getEventClass(): string {
    return GetFieldsEvent::class;
  }

}
