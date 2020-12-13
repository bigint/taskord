<?php

// Code within app\Helpers\Helper.php

namespace App\Helpers;

use App\Gamify\Points\PraiseCreated;
use App\Models\Product;
use App\Models\User;
use App\Notifications\AnswerPraised;
use App\Notifications\CommentPraised;
use App\Notifications\Mentioned;
use App\Notifications\Question\NotifySubscribers as QuestionSubscribers;
use App\Notifications\QuestionPraised;
use App\Notifications\Task\NotifySubscribers as TaskSubscribers;
use App\Notifications\TaskPraised;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class Helper
{
    public static function togglePraise($entity, $type)
    {
        if (Auth::user()->hasLiked($entity)) {
            Auth::user()->unlike($entity);
            $entity->refresh();
            if (
                $type === 'TASK' or
                $entity->source !== 'GitHub' and
                $entity->source !== 'GitLab'
            ) {
                undoPoint(new PraiseCreated($entity));
            }
            Auth::user()->touch();
        } else {
            Auth::user()->like($entity);
            $entity->refresh();
            if ($type === 'TASK') {
                $entity->user->notify(new TaskPraised($entity, Auth::id()));
            } elseif ($type === 'COMMENT') {
                $entity->user->notify(new CommentPraised($entity, Auth::id()));
            } elseif ($type === 'QUESTION') {
                $entity->user->notify(new QuestionPraised($entity, Auth::id()));
            } elseif ($type === 'ANSWER') {
                $entity->user->notify(new AnswerPraised($entity, Auth::id()));
            }
            if (
                $type === 'TASK' or
                $entity->source !== 'GitHub' and
                $entity->source !== 'GitLab'
            ) {
                givePoint(new PraiseCreated($entity));
            }
            Auth::user()->touch();
        }
    }

    public static function hide($entity)
    {
        $entity->hidden = ! $entity->hidden;
        $entity->save();
        $entity->refresh();
    }

    public static function flagAccount($user)
    {
        $user->isFlagged = true;
        $user->save();
    }

    public static function mentionUsers($users, $task, $type)
    {
        if ($users) {
            for ($i = 0; $i < count($users); $i++) {
                $user = User::where('username', $users[$i])->first();
                if ($user !== null) {
                    if ($user->id !== Auth::id()) {
                        $user->notify(new Mentioned($task, $type));
                    }
                }
            }
        }
    }

    public static function notifySubscribers($users, $entity, $type)
    {
        $subscribers = $users->except(Auth::id());
        if ($subscribers) {
            for ($i = 0; $i < count($subscribers); $i++) {
                if ($subscribers[$i] !== null) {
                    if ($type === 'comment') {
                        $subscribers[$i]->notify(new TaskSubscribers($entity));
                    } elseif ($type === 'answer') {
                        $subscribers[$i]->notify(new QuestionSubscribers($entity));
                    }
                }
            }
        }
    }

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
                if ($product->user_id === Auth::id() or Auth::user()->products->contains($product)) {
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
            return "<span title='$format' class='me-2 text-success'>Due in $days days</span>";
        }

        if ($diff === 1) {
            return "<span title='$format' class='me-2 text-info'>Due tomorrow</span>";
        }

        if ($diff === 0) {
            return "<span title='$format' class='me-2 text-danger'>Due today</span>";
        }

        if ($diff < 0) {
            if ($days > 1) {
                return "<span title='$format' class='me-2 text-danger'>Overdue by $days days</span>";
            } else {
                return "<span title='$format' class='me-2 text-danger'>Overdue by $days day</span>";
            }
        }
    }
}
