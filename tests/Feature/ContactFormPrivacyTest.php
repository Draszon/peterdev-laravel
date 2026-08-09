<?php

use Livewire\Livewire;

test('contact form requires privacy consent before sending', function () {
    Livewire::test('sections.contact-form')
        ->set('name', 'Teszt Elek')
        ->set('email', 'teszt@example.com')
        ->set('message', 'Üzenet szövege')
        ->call('save')
        ->assertHasErrors(['privacy_consent' => 'accepted']);
});
