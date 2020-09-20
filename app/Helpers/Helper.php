<?php

// Code within app\Helpers\Helper.php

namespace App\Helpers;

use App\Models\Product;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class Helper
{
    public static function getUserIDFromMention($string)
    {
        $mention = false;
        preg_match_all("/(@\w+)/u", $string, $matches);
        if ($matches) {
            $mentionsArray = array_count_values($matches[0]);
            $mention = array_keys($mentionsArray);
        }
        $usernames = str_replace('@', '', $mention);

        return $usernames;
    }

    public static function getProductIDFromMention($string)
    {
        $mention = false;
        preg_match_all("/(#\w+)/u", $string, $matches);
        if ($matches) {
            $mentionsArray = array_count_values($matches[0]);
            $mention = array_keys($mentionsArray);
        }
        $products = str_replace('#', '', $mention);

        if ($products) {
            $product = Product::where('slug', $products[0])->first();
            if ($product) {
                if ($product->user_id === Auth::id()) {
                    $product_id = $product->id;
                    $type = 'product';
                } else {
                    $product_id = null;
                    $type = 'user';
                }
            } else {
                $product_id = null;
                $type = 'user';
            }
        } else {
            $product_id = null;
            $type = 'user';
        }

        return $product_id;
    }

    public static function removeProtocol($url)
    {
        return trim(preg_replace('#^[^:/.]*[:/]+#i', '', $url), '/');
    }

    public static function renderTask($task)
    {
        $reg_exUrl = "/(http|https|ftp|ftps)\:\/\/[a-zA-Z0-9\-\.]+\.[a-zA-Z]{2,100}(\/\S*)?/";
        $products = preg_replace('/#(\w+)/', '<a href="/product/$1">#$1</a>', $task);
        $users = preg_replace('/@(\w+)/', '<a href="/@$1">@$1</a>', $products);
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
