#!/bin/bash
set -eu -o pipefail

XCM_VERSION=1.12.0
IDENTITYTRACKER_BRANCH=master
REMOTETOOLS_BRANCH=master

EXT_DIR=$(dirname "$(dirname "$(realpath "$0")")")
EXT_NAME=$(basename "$EXT_DIR")

i=0
while ! mysql -h "$CIVICRM_DB_HOST" -P "$CIVICRM_DB_PORT" -u "$CIVICRM_DB_USER" --password="$CIVICRM_DB_PASS" -e 'SELECT 1;' >/dev/null 2>&1; do
  i=$((i+1))
  if [ $i -gt 10 ]; then
    echo "Failed to connect to database" >&2
    exit 1
  fi

  echo -n .
  sleep 1
done

echo

export XDEBUG_MODE=off
if mysql -h "$CIVICRM_DB_HOST" -P "$CIVICRM_DB_PORT" -u "$CIVICRM_DB_USER" --password="$CIVICRM_DB_PASS" "$CIVICRM_DB_NAME" -e 'SELECT 1 FROM civicrm_setting LIMIT 1;' >/dev/null 2>&1; then
  cv flush
else
  # For headless tests it is required that CIVICRM_UF is defined using the corresponding env variable.
  sed -E "s/define\('CIVICRM_UF', '([^']+)'\);/define('CIVICRM_UF', getenv('CIVICRM_UF') ?: '\1');/g" \
    -i /var/www/html/sites/default/civicrm.settings.php
  civicrm-docker-install

  cv ext:download "de.systopia.xcm@https://github.com/systopia/de.systopia.xcm/releases/download/$XCM_VERSION/de.systopia.xcm-$XCM_VERSION.zip"
  cv ext:download "de.systopia.identitytracker@https://github.com/systopia/de.systopia.identitytracker/archive/refs/heads/$IDENTITYTRACKER_BRANCH.zip"
  cv ext:download "de.systopia.remotetools@https://github.com/systopia/de.systopia.remotetools/archive/refs/heads/$REMOTETOOLS_BRANCH.zip"
  # In the container used for tests there seems to be psr/cache 1 installed somewhere.
  # This conflicts with symfony/cache >=6, thus we use version 5 here.
  composer --working-dir="$EXT_DIR/../de.systopia.remotetools" require --no-update 'symfony/cache:^5'
  composer --working-dir="$EXT_DIR/../de.systopia.remotetools" update --no-dev --no-progress --prefer-dist --optimize-autoloader
  cv ext:enable "$EXT_NAME"

  # For headless tests these files need to exist.
  touch /var/www/html/sites/all/modules/civicrm/sql/test_data.mysql
  touch /var/www/html/sites/all/modules/civicrm/sql/test_data_second_domain.mysql
fi

cd "$EXT_DIR"
composer update --no-progress --prefer-dist --optimize-autoloader --no-dev
composer composer-phpunit -- update --no-progress --prefer-dist
