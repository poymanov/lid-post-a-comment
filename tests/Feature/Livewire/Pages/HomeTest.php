<?php

declare(strict_types=1);

namespace Tests\Feature\Livewire\Pages;

use App\Http\Livewire\Pages\Home;
use Tests\TestCase;

class HomeTest extends TestCase
{
    /**
     * @test
     */
    function page_contains_livewire_component()
    {
        $this->get('/')->assertSeeLivewire(Home::getName());
    }
}
