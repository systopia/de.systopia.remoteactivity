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

namespace Civi\RemoteActivity\Api4\Action\Remote\Traits;

use Civi\RemoteActivity\Api4\Action\Remote\RemoteActivityActionInterface;
use Webmozart\Assert\Assert;

trait RemoteActivityActionContactIdRequiredTrait {

  /**
   * Must be initialized because it is directly accessed in AbstractAction.
   *
   * @var string|null
   * @required
   */
  protected ?string $remoteContactId = NULL;

  public function getRemoteContactId(): ?string {
    return $this->remoteContactId;
  }

  /**
   * @param string $remoteContactId
   *
   * @return $this
   */
  public function setRemoteContactId(string $remoteContactId): RemoteActivityActionInterface {
    $this->remoteContactId = $remoteContactId;

    return $this;
  }

  protected function getContactId(): int {
    Assert::integer($this->_extraParams['contactId']);
    return $this->_extraParams['contactId'];
  }

}
