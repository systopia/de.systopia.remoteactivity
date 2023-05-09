<?php
/*
 * Copyright (C) 2023 SYSTOPIA GmbH
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

namespace Civi\Api4;

use Civi\API\Exception\UnauthorizedException;
use Civi\Remoteactivity\AbstractRemoteActivityHeadlessTestCase;
use Civi\Remoteactivity\Fixtures\ActivityFixture;

/**
 * @covers \Civi\Api4\RemoteActivity
 * @covers \Civi\Remoteactivity\RemoteActivityDefaultEntityProfile
 *
 * @group headless
 */
final class RemoteActivityTest extends AbstractRemoteActivityHeadlessTestCase {

  public function testDelete(): void {
    $activity = ActivityFixture::addFixture();
    $result = RemoteActivity::delete()
      ->setProfile('default')
      ->addWhere('id', '=', $activity['id'])
      ->execute();

    static::assertCount(0, $result);
  }

  public function testGet(): void {
    $result = RemoteActivity::get()
      ->setProfile('default')
      ->execute();

    static::assertCount(0, $result);

    $activity = ActivityFixture::addFixture();
    $result = RemoteActivity::get()
      ->setProfile('default')
      ->execute();

    static::assertCount(1, $result);
    static::assertSame($activity['id'], $result->single()['id']);
    static::assertFalse($result->single()['CAN_delete']);
    static::assertFalse($result->single()['CAN_update']);

    $result = RemoteActivity::get()
      ->setProfile('default')
      ->addWhere('id', '!=', $activity['id'])
      ->execute();

    static::assertCount(0, $result);
  }

  public function testGetActions(): void {
    $result = RemoteActivity::getActions()->execute();
    $actions = $result->indexBy('name')->getArrayCopy();
    static::assertArrayHasKey('get', $actions);
  }

  public function testGetCreateForm(): void {
    $this->expectException(UnauthorizedException::class);
    RemoteActivity::getCreateForm()
      ->setProfile('default')
      ->execute();
  }

  public function testGetFields(): void {
    $result = RemoteActivity::getFields()
      ->setProfile('default')
      ->execute();

    $fields = $result->indexBy('name')->getArrayCopy();
    static::assertArrayHasKey('activity_date_time', $fields);
    static::assertArrayHasKey('CAN_delete', $fields);
    static::assertArrayHasKey('CAN_update', $fields);
  }

  public function testGetUpdateForm(): void {
    $activity = ActivityFixture::addFixture();
    $this->expectException(UnauthorizedException::class);
    RemoteActivity::getUpdateForm()
      ->setProfile('default')
      ->setId($activity['id'])
      ->execute();
  }

}
