<?php

namespace Tests\Feature;

use App\Http\Livewire\Admin\Adminbar;
use Livewire;
use Tests\TestCase;

class AdminBarTest extends TestCase
{
    public function test_adminbar()
    {
        if (! defined('LARAVEL_START')) {
            define('LARAVEL_START', microtime(true));
        }

        Livewire::test(Adminbar::class)
            ->assertSee('Laravel');
    }
}
