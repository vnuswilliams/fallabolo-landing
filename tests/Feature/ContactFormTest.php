<?php

use Livewire\Livewire;

it('renders the contact form component without error', function () {
    Livewire::test('contact-form')
        ->assertStatus(200);
});

it('can submit the contact form successfully', function () {
    Livewire::test('contact-form')
        ->set('name', 'John Doe')
        ->set('email', 'john@example.com')
        ->set('subject', 'Test Subject')
        ->set('message', 'This is a test message with more than 10 characters.')
        ->call('save')
        ->assertHasNoErrors();
});
