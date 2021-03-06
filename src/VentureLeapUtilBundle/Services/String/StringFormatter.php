<?php

namespace VentureLeapUtilBundle\Services\String;

use Symfony\Component\HttpFoundation\Request;

class StringFormatter
{
    /**
     * @var string
     */
    private $locale;

    public function __construct()
    {
        $this->locale = 'de';
    }

    /**
     * @param float  $value
     * @param string $currency
     *
     * @return string
     */
    public function formatMoney($value, $currency = '€')
    {
        if (empty($currency)) {
            $currency = '€';
        }

        return number_format($value, 2, ',', '.').' '.$currency;
    }

    /**
     * @param \DateTime|null $dateTime
     *
     * @return string
     */
    public function formatDate(\DateTime $dateTime = null)
    {
        return $dateTime ? $dateTime->format('d.m.Y') : '-';
    }

    /**
     * @param \DateTime|null $dateTime
     *
     * @return string
     */
    public function formatDateTime(\DateTime $dateTime = null)
    {
        return $dateTime ? $dateTime->format('d.m.Y H:i:s') : '-';
    }

    /**
     * @param \DateTime|null $dateTime
     *
     * @return string
     */
    public function formatShortDate(\DateTime $dateTime = null)
    {
        return $dateTime ? $dateTime->format('d.m.') : '-';
    }

    /**
     * Replace -- by an invisble space.
     *
     * @param $string
     *
     * @return string
     */
    public function getHyphenation($string)
    {
        return str_replace('--', "\xC2\xAD", $string);
    }

    /**
     * @param \DateTime $dateTime
     *
     * @return string
     */
    public function getFullWeekday(\DateTime $dateTime)
    {
        $weekday = $dateTime->format('l');

        if (in_array($this->locale, ['de', 'ch', 'at', 'de-DE', 'de-CH', 'de-AT', 'de_DE', 'de_CH', 'de_AT'])) {
            $weekday = [
                'Sonntag',
                'Montag',
                'Dienstag',
                'Mittwoch',
                'Donnerstag',
                'Freitag',
                'Samstag',
            ][$dateTime->format('w')];
        }

        return $weekday;
    }
}
