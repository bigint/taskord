<?php

// Code within app\Helpers\Helper.php

namespace App\Helpers;

use Carbon\Carbon;

class Helper
{
    public static function removeProtocol($url)
    {
        return trim(preg_replace('#^[^:/.]*[:/]+#i', '', $url), '/');
    }

    public static function renderTask($task)
    {
        $reg_exUrl = "/(http|https|ftp|ftps)\:\/\/[a-zA-Z0-9\-\.]+\.[a-zA-Z]{2,3}(\/\S*)?/";
        $users = preg_replace('/@(\w+)/', '<a class="font-weight-bold" href="@$1">@$1</a>', $task);
        if (preg_match($reg_exUrl, $users, $url)) {
            $truncate = strlen($url[0]) > 30 ? substr($url[0], 0, 30).'...' : $url[0];

            return preg_replace($reg_exUrl, "<a class='link' href=$url[0]>$truncate</a> ", $users);
        } else {
            return $users;
        }
    }

    public static function dueDate($date)
    {
        $diff = Carbon::today()->diffInDays(Carbon::parse($date), false);
        $days = abs($diff);
        $format = Carbon::parse($date)->format('M d, Y');

        if ($diff > 1) {
            return "<span title='$format' class='mr-2 text-success'>Due in $days days</span>";
        }

        if ($diff === 1) {
            return "<span title='$format' class='mr-2 text-info'>Due tomorrow</span>";
        }

        if ($diff === 0) {
            return "<span title='$format' class='mr-2 text-danger'>Due today</span>";
        }

        if ($diff < 0) {
            if ($days > 1) {
                return "<span title='$format' class='mr-2 text-danger'>Overdue by $days days</span>";
            } else {
                return "<span title='$format' class='mr-2 text-danger'>Overdue by $days day</span>";
            }
        }
    }
}
