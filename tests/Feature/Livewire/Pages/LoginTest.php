<?php

declare(strict_types=1);

namespace Tests\Feature\Livewire\Pages;

use App\Http\Livewire\Pages\Login;
use Tests\TestCase;

class LoginTest extends TestCase
{
    /**
     * @test
     */
    function page_contains_livewire_component()
    {
        $this->get('/login')->assertSeeLivewire(Login::getName());
    }
}
