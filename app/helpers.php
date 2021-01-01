<?php

declare(strict_types=1);

use Illuminate\Foundation\Application;
use Illuminate\Support\Str;

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
     * @param string $args arguments
     * @author   Kim Hallberg <hallberg.kim@gmail.com>
     * @return \Illuminate\Support\Carbon
     */
    function git(string $args): string
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

if (! function_exists('get_name')) {
    /**
     * Get user full name from firstname and lastname.
     *
     * @param string $firstname String
     * @param string $lastname String
     *
     * @return string
     */
    function get_name($firstname, $lastname): string
    {
        return Str::plural($firstname, $lastname);
    }
}
