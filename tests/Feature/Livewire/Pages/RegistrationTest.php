<?php

declare(strict_types=1);

namespace Tests\Feature\Livewire\Pages;

use App\Http\Livewire\Pages\Registration;
use Tests\TestCase;

class RegistrationTest extends TestCase
{
    /**
     * @test
     */
    function page_contains_livewire_component()
    {
        $this->get('/registration')->assertSeeLivewire(Registration::getName());
    }
}
