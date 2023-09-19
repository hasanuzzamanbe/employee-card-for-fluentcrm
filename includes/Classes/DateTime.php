<?php

namespace EmployeeCard\Classes;
use DateTimeZone;
use DateTime as PHPDateTime;
use InvalidArgumentException;
class DateTime extends PHPDateTime
{
    /**
     * Construct the DateTime Object
     *
     * @param string $datetime
     * @param \DateTimeZone $timezone|null
     */
    public function __construct($datetime = "now", $timezone = null)
    {
        $timezone = $timezone ?: $this->getTimezone();

        parent::__construct($datetime, $timezone);
    }

    /**
     * Create a new DateTime Object with current time
     *
     * @return self
     */
    public static function now()
    {
        return new static;
    }

    /**
     * Get the timezone
     *
     * @return \DateTimeZone
     */
    #[\ReturnTypeWillChange]
    public function getTimezone()
    {
        // if site timezone string exists, return it
        if ($timezone = wp_timezone_string()) {
            return new DateTimeZone($timezone);
        }

        // get UTC offset, if it isn't set then return UTC
        $utcOffset = get_option('gmt_offset', 0);
        if ($utcOffset === 0) {
            return new DateTimeZone('UTC');
        }

        // Adjust UTC offset from hours to seconds
        $utcOffset *= 3600;

        // Attempt to guess the timezone string from the UTC offset
        $timezone = timezone_name_from_abbr('', $utcOffset, 0);
        if ($timezone) {
            return new DateTimeZone($timezone);
        }

        // Guess timezone string manually
        $isDst = date('I');
        foreach (timezone_abbreviations_list() as $abbr) {
            foreach ($abbr as $city) {
                if ($city['dst'] == $isDst && $city['offset'] == $utcOffset) {
                    $timezoneId = $city['timezone_id'];
                    $timezone = $timezoneId ?: timezone_name_from_abbr('', $timezoneId, 0);
                    if ($timezone) return new DateTimeZone($timezone);
                }
            }
        }

        // Fallback
        return new DateTimeZone('UTC');
    }

    /**
     * Get the default date format
     *
     * @return string
     */
    public function getDateFormat()
    {
        return 'Y-m-d H:i:s';
    }

    /**
     * {@inheritdoc}
     */
    #[\ReturnTypeWillChange]
    public static function createFromFormat($format, $datetimeString, $timezone = null)
    {
        $timezone = $timezone ?: (new static)->getTimezone();

        if (!($timezone instanceof DateTimeZone)) {
            $timezone = new DateTimeZone($timezone);
        }

        $dateTime = new PHPDateTime($datetimeString, $timezone);

        if ($dateTime instanceof PHPDateTime) {
            return new static($dateTime->format($format), $timezone);
        }

        throw new InvalidArgumentException('Unable to handle datetime.');
    }

    /**
     * Parse a datetime string
     * @param  string $datetimeString
     * @param  string $timezone
     * @return self
     * @throws InvalidArgumentException
     */
    public static function parse($datetimeString, $timezone = null)
    {
        $parsedDate = date_parse($datetimeString);

        $datetimeString = date('Y-m-d H:i:s', mktime(
            $parsedDate['hour'],
            $parsedDate['minute'],
            $parsedDate['second'],
            $parsedDate['month'],
            $parsedDate['day'],
            $parsedDate['year']
        ));

        if ($timezone && is_scalar($timezone)) {
            $timezone = new DateTimeZone($timezone);
        } elseif (isset($parsedDate['tz_id'])) {
            $timezone = new DateTimeZone($parsedDate['tz_id']);
        }

        $dateTime = new PHPDateTime($datetimeString, $timezone);

        if ($dateTime instanceof PHPDateTime) {
            return new static($datetimeString, $timezone);
        }

        throw new InvalidArgumentException('Unable to handle datetime.');
    }

    /**
     * Get human friendly time difference
     * @param  \DateTime|string $datetime The datetime to compare with
     * @param  boolean $full Wheather to show days, hours in details
     * @return string Human readable string, ie. 5 days ago
     */
    public function diffForHumans($dateTime = null, $full = false)
    {
        if (is_null($dateTime)) {
            $ago = new PHPDateTime($this->format($this->getDateFormat()));
        } else {
            $ago = $dateTime instanceof PHPDateTime ? $dateTime : new PHPDateTime($dateTime);
        }

        $now = new PHPDateTime;
        $diff = $now->diff($ago);
        $diff->w = floor($diff->d / 7);
        $diff->d -= $diff->w * 7;

        $string = array(
            'y' => 'year',
            'm' => 'month',
            'w' => 'week',
            'd' => 'day',
            'h' => 'hour',
            'i' => 'minute',
            's' => 'second',
        );

        foreach ($string as $k => &$v) {
            if ($diff->$k) {
                $v = $diff->$k . ' ' . $v . ($diff->$k > 1 ? 's' : '');
            } else {
                unset($string[$k]);
            }
        }

        if (!$full) {
            $string = array_slice($string, 0, 1);
        }

        return $string ? implode(', ', $string) . ' ago' : 'just now';
    }

    /**
     * Return the ISO-8601 string
     *
     * @see https://stackoverflow.com/a/11173072/741747
     *
     * @return mixed
     */
    public function toJSON()
    {
        return date('c', $this->getTimestamp());
    }

    public function __toString()
    {
        return $this->format($this->getDateFormat());
    }
}