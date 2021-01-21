<?php

class Helpers
{
    static function alert($msg)
    {
        echo "<script type='text/javascript'>alert('$msg');</script>";
    }

    static function convertDbTime($time)
    {
        return substr($time, 0, -3); //From hh:mm:ss to hh:mm
    }
}