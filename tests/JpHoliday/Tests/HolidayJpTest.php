<?php
namespace JpHoliday\Tests;

use PHPUnit\Framework\TestCase;
use Symfony\Component\Yaml\Yaml;
use JpHoliday\JpHoliday;
use DateTime;

date_default_timezone_set('Asia/Tokyo');

class JpHolidayTest extends TestCase
{
    /**
     * test_holidays
     *
     */
    public function test_holidays() {
        $this->assertEquals(JpHoliday\Holidays::$holidays['1973-04-30']['name'], '天皇誕生日 振替休日');
    }

    /**
     * test_between
     *
     */
    public function test_between(){
        $holidays = JpHoliday::between(new DateTime('2009-01-01'), new DateTime('2009-01-31'));
        $new_year_day = $holidays[0];
        $this->assertEquals(new DateTime('2009-01-01'), $new_year_day['date']);
        $this->assertEquals('元日', $new_year_day['name']);
        $this->assertEquals("New Year's Day", $new_year_day['name_en']);
        $this->assertEquals('木', $new_year_day['week']);

        $this->assertEquals(new DateTime('2009-01-12'), $holidays[1]['date']);
        $this->assertEquals('成人の日', $holidays[1]['name']);

        $holidays = JpHoliday::between(new DateTime('2008-12-23'), new DateTime('2009-01-12'));
        $this->assertEquals(new DateTime('2008-12-23'), $holidays[0]['date']);
        $this->assertEquals(new DateTime('2009-01-01'), $holidays[1]['date']);
        $this->assertEquals(new DateTime('2009-01-12'), $holidays[2]['date']);
    }

    /**
     * test_isHoliday
     *
     */
    public function test_isHoliday(){
        $date = new DateTime('2011-09-19');
        $this->assertTrue(JpHoliday::isHoliday($date));
        $date = new DateTime('2011-09-18');
        $this->assertFalse(JpHoliday::isHoliday($date));
    }

    /**
     * test_MountainDayFrom2016
     *
     */
    public function test_MountainDayFrom2016(){
        $date = new DateTime('2015-08-11');
        $this->assertFalse(JpHoliday::isHoliday($date));

        for ($year = 2016; $year <= 2050; $year++) {
            if ($year == 2020) {
                $date = new DateTime($year . '-08-10');
            } else if ($year == 2021) {
                $date = new DateTime($year . '-08-08');
            } else {
                $date = new DateTime($year . '-08-11');
            }
            $this->assertTrue(JpHoliday::isHoliday($date));
        }
    }

    /**
     * test_betweenSeconds
     *
     */
    public function test_betweenSeconds(){
       $holidays = JpHoliday::between(new DateTime('2014-09-23 00:00:01'), new DateTime('2014-09-23 00:00:01'));
       $this->assertEquals(1, count($holidays));
    }

    /**
     * test_countHolidays
     *
     */
    public function test_countHolidays(){
        $yamlDate = Yaml::parse(file_get_contents('https://raw.githubusercontent.com/holiday-jp/holiday_jp/master/holidays_detailed.yml'));
        $holidays = JpHoliday::between(new DateTime('1970-01-01'), new DateTime('2050-12-31'));
        $this->assertEquals(count($yamlDate), count($holidays));
    }

    /**
     * test_fullHolidays
     *
     */
    public function test_fullHolidays(){
        $yamlDate = Yaml::parse(file_get_contents('https://raw.githubusercontent.com/holiday-jp/holiday_jp/master/holidays_detailed.yml'));
        foreach ($yamlDate as $date => $value) {
            $this->assertTrue(JpHoliday::isHoliday(new DateTime(date('Y-m-d', $date))));
            $actual = JpHoliday\Holidays::$holidays[date('Y-m-d', $date)];
            $value['date'] = date('Y-m-d', $value['date']);
            $this->assertEquals($actual, $value);
        }
    }

}
