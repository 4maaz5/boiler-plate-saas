<?php

namespace Tests\Feature;

use Tests\TestCase;

class LocaleSwitchTest extends TestCase
{
    public function test_it_stores_a_supported_locale_in_the_session(): void
    {
        $response = $this->from('/admin')->get('/locale/ar');

        $response
            ->assertRedirect('/admin')
            ->assertSessionHas('locale', 'ar');
    }

    public function test_it_falls_back_when_the_locale_is_not_supported(): void
    {
        $response = $this->from('/admin')->get('/locale/fr');

        $response
            ->assertRedirect('/admin')
            ->assertSessionHas('locale', 'en');
    }
}
