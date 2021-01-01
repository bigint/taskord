<?php

declare(strict_types=1);

use Illuminate\Foundation\Application;

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
    function git(string $args)
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
     * Return current Laravel version
     *
     * @return string
     */
    function laravel_version(): string
    {
        return Application::VERSION;
    }
}
