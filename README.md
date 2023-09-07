# jp-holiday PHP [![test](https://github.com/trieunguyen1988/jp-holiday-php/workflows/test/badge.svg)](https://github.com/trieunguyen1988/jp-holiday-php/actions) [![Packagist](https://img.shields.io/packagist/v/holiday-jp/holiday_jp.svg)](https://packagist.org/packages/holiday-jp/holiday_jp)

Get holidays in Japan.

## Installation

```json
{
  "require": {
    "jp-holiday/jp-holiday": "*"
  }
}
```

```php
require 'vendor/autoload.php';

use JpHoliday\JpHoliday;

$holidays = JpHoliday::between(new DateTime('2010-09-14'), new DateTime('2010-09-21'))

echo $holidays[0]['name'] // 敬老の日
```
