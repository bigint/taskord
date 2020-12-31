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
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;

class Helper
{
    public static function getCDNImage($url, $resolution = 500)
    {
        if (App::environment() === 'production') {
            $cleaned_url = str_replace('https://taskord.com/storage/', '', $url);

            return "https://ik.imagekit.io/taskordimg/tr:w-{$resolution}/{$cleaned_url}";
        }

        return $url;
    }

    public static function togglePraise($entity, $type)
    {
        $user = Auth::user();
        $hasLiked = $user->hasLiked($entity);

        ($hasLiked)
            ? $user->unlike($entity)
            : $user->like($entity);

        if ($type === 'TASK'
            || $entity->source !== 'GitHub'
            && $entity->source !== 'Gitlab'
        ) {
            ($hasLiked)
                ? undoPoint(new PraiseCreated($entity))
                : givePoint(new PraiseCreated($entity));
        }

        if (!$hasLiked) {
            switch ($type) {
                case 'TASK':
                    $entity->user->notify(new TaskPraised($entity, $user->id));
                    break;
                case 'COMMENT':
                    $entity->user->notify(new CommentPraised($entity, $user->id));
                    break;
                case 'QUESTION':
                    $entity->user->notify(new QuestionPraised($entity, $user->id));
                    break;
                case 'ANSWER':
                    $entity->user->notify(new AnswerPraised($entity, $user->id));
                    break;
                default:
                    break;
            }
        }

        $entity->refresh();
        $user->touch();
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

    public static function getUsernamesFromMentions($text)
    {
        preg_match_all("/(@[\w-]+)/u", $text, $matches);

        if ($matches) {
            $usernames = collect($matches[0])->values()->all();
        }

        return str_replace('@', '', $usernames);
    }

    public static function parseUserMentionsToMarkdownLinks($markdown, $mentions)
    {
        foreach ($mentions as $user) {
            $markdown = str_replace("@$user", sprintf('[@%s](/@%s)', $user, $user), $markdown);
        }

        return $markdown;
    }

    public static function getProductIDFromMention($string)
    {
        preg_match_all("/(#[\w-]+)/u", $string, $matches);

        if ($matches) {
            $mentions = collect($matches[0])->values()->all();
        }

        $products = collect(str_replace('#', '', $mentions));

        return $products
            ->map(fn ($product) => Product::where('slug', $product)->first())->whereNotNull('id')
            ->filter(fn ($product) => $product->user_id === Auth::id() or Auth::user()->products->contains($product))
            ->pluck('id')->first();
    }

    public static function removeProtocol($url)
    {
        return trim(preg_replace('#^[^:/.]*[:/]+#i', '', $url), '/');
    }

    public static function renderTask($task)
    {
        $urlRegex = "/(http|https|ftp|ftps)\:\/\/[a-zA-Z0-9\-\.]+\.[a-zA-Z]{2,100}(\/\S*)?/";

        $task = preg_replace('/#([\w-]+)/', '<a href="/product/$1">#$1</a>', $task);
        $task = preg_replace('/@([\w-]+)/', '<a href="/@$1">@$1</a>', $task);

        if (preg_match($urlRegex, $task, $url)) {
            $truncate = strlen($url[0]) > 30 ? substr($url[0], 0, 30).'...' : $url[0];

            return preg_replace($urlRegex, "<a class='link' href='$url[0]'>$truncate</a>", $task);
        }

        return $task;
    }

    public static function renderDueDate(Carbon $date)
    {
        $difference = Carbon::today()->diffInDays($date, false);
        $days = abs($difference);

        if ($difference > 1) {
            $due = ['class' => 'text-success', 'text' => "Due in {$days} days"];
        }

        if ($difference === 1) {
            $due = ['class' => 'text-info', 'text' => 'Due tomorrow'];
        }

        if ($difference === 0) {
            $due = ['class' => 'text-danger', 'text' => 'Due today'];
        }

        if ($difference < 0) {
            $due = ['class' => 'text-danger', 'text' => "Overdue by {$days} day"];

            if ($days > 1) {
                $due = ['class' => 'text-danger', 'text' => "Overdue by {$days} days"];
            }
        }

        return "<time datetime='{$date->format('Y-m-d')}' class='me-2 {$due['class']}'>{$due['text']}</time>";
    }
}
