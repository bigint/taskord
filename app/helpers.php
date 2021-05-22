<?php

declare(strict_types=1);

use App\Jobs\LogActivity;
use App\Models\Feature;
use App\Models\User;
use Illuminate\Foundation\Application;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;
use League\CommonMark\GithubFlavoredMarkdownConverter;

/**
 * This file contains helper functions for Taskord.
 * php version 7.4+.
 *
 * @category Helpers
 */
if (! function_exists('git')) {

    /**
     * Execute git command
     * Should be used safetly
     * No direct end-user access.
     *
     * @param string $args
     *
     * @return string|null
     */
    function git(string $args): ?string
    {
        $approved_args = ['rev-parse'];
        $arguments = explode(' ', $args);

        if (! in_array($arguments[0], $approved_args, true)) {
            return null;
        }

        $output = shell_exec(escapeshellcmd("git $args"));

        if (is_null($output) || str_contains('fatal', $output)) {
            return null;
        }

        return trim($output);
    }
}

if (! function_exists('laravel_version')) {
    /**
     * Return current Laravel version.
     *
     * @return string
     */
    function laravel_version(): string
    {
        return Application::VERSION;
    }
}

if (! function_exists('memory_usage')) {
    /**
     * Get formatted memory usage.
     *
     * @author Jeff Peck <jeff.peck@snet.net>
     * @link   https://www.php.net/manual/en/function.memory-get-usage.php#93012
     *
     * @return string
     */
    function memory_usage(): string
    {
        $mem_usage = memory_get_usage(true);

        if ($mem_usage < 1024) {
            $format = sprintf('%dB', $mem_usage);
        } elseif ($mem_usage < 1048576) {
            $format = sprintf('%dKB', round($mem_usage / 1024, 2));
        } else {
            $format = sprintf('%dMB', round($mem_usage / 1048576, 2));
        }

        return $format;
    }
}

if (! function_exists('str_plural')) {
    /**
     * Get the plural form of an English word.
     *
     * @param string $word  Word
     * @param int    $count Count
     *
     * @return string
     */
    function str_plural($word, $count): string
    {
        return Str::plural($word, $count);
    }
}

if (! function_exists('carbon')) {

    /**
     * Returns new Carbon object.
     *
     * @param mixed ...$args arguments
     *
     * @author Caleb Porzio <calebporzio@gmail.com>
     * @link   https://github.com/calebporzio/awesome-helpers
     *
     * @return \Illuminate\Support\Carbon|null
     */
    function carbon(...$args): ?Carbon
    {
        try {
            return new Carbon(...$args);
        } catch (Exception $exception) {
            return null;
        }
    }
}

if (! function_exists('loggy')) {
    function loggy($request, $type, $user, $message)
    {
        return LogActivity::dispatch($request->ip(), $request->header('User-Agent'), $type, $user, $message);
    }
}

if (! function_exists('formatBytes')) {
    function formatBytes($size, $precision = 2)
    {
        $base = log($size, 1024);
        $suffixes = ['', 'KB', 'MB', 'GB', 'TB'];

        return round(pow(1024, $base - floor($base)), $precision).' '.$suffixes[floor($base)];
    }
}

if (! function_exists('markdown')) {
    function markdown($content)
    {
        $converter = new GithubFlavoredMarkdownConverter([
            'html_input' => 'strip',
            'allow_unsafe_links' => false,
        ]);

        return $converter->convertToHtml($content);
    }
}

if (! function_exists('feature')) {
    function feature($slug)
    {
        try {
            return Feature::enabled($slug);
        } catch (Throwable $e) {
            return false;
        }
    }
}

if (! function_exists('toast')) {
    function toast($livewire, $type, $body)
    {
        return $livewire->dispatchBrowserEvent('toast', [
            'type' => $type,
            'body' => $body,
        ]);
    }
}
