<?php declare(strict_types=1);

/**
 * This file contains helper functions for Taskord.
 * php version 7.4+
 *
 * @category Helpers
 * @package  Taskord
 * @author   Kim Hallberg <hallberg.kim@gmail.com>
 * @license  https://mit-license.org/ MIT
 * @link     http://taskord.com
 */

if (! function_exists('git')) {

    /**
     * Execute git command
     * Should be used safetly
     * No direct end-user access
     *
     * @param string $args arguments
     *
     * @return string|null output
     */
    function git(string $args)
    {
        $approved_args = ['rev-parse'];
        $arguments = explode(" ", $args);

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
