<?php
class Formatter extends CFormatter
{

    public function formatExcerpt($text, $numOfWords = 55)
    {
        $words = explode(' ', $text);
        if (count($words) > $numOfWords) {
            return implode(' ', array_slice($words, 0, $numOfWords)) . '...';
        } else {
            return $text;
        }
    }

    public static function formatOrdinal($number)
    {
        $ends = array('th', 'st', 'nd', 'rd', 'th', 'th', 'th', 'th', 'th', 'th');
        if (($number % 100) >= 11 && ($number % 100) <= 13)
            return $number . 'th';
        else
            return $number . $ends[$number % 10];
    }

    public static function truncate($string, $limit, $break = ".", $pad = "...")
    {
        if (!isset($limit))
            $limit = Yii::app()->params['posting_max_text_length'];

            $string = strip_tags($string, '<strong>');

        if (strlen($string) <= $limit) return $string;

        if (false !== ($breakpoint = strpos($string, $break, $limit))) {
            if ($breakpoint < strlen($string) - 1) {
                $string = substr($string, 0, $breakpoint) . $pad;
            }
        }

        return $string;


    }
}