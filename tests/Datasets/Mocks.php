<?php

/*
|--------------------------------------------------------------------------
| Test user roles
|--------------------------------------------------------------------------
|
| 1 => Staff
| 2 => Test User
| 3 => Suspended User
| 4 => Spammy/Flagged User
| 5 => Un-verified User
|
*/

dataset('model-data', [
    ['Hello world from test!', 2, true],
    ['😊🤗💜✨👍', 2, true],
    ['', 2, false],
    ['12', 2, false],
    ['123', 2, true],
    ['Hello from suspended account!', 3, false],
    ['Hello from spammy account!', 4, false],
    ['Hello from un-verified account!', 5, false],
]);

dataset('like-data', [
    [2, true],
    [3, false],
    [4, false],
    [5, false],
]);
