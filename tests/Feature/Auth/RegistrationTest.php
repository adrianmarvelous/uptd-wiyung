<?php

test('registration page is unavailable', function () {
    $this->get('/register')->assertNotFound();
});

test('public registration cannot create a user', function () {
    $this->post('/register', [
        'name' => 'Test User',
        'username' => 'testuser',
        'password' => 'password',
        'password_confirmation' => 'password',
    ])->assertNotFound();

    $this->assertGuest();
    $this->assertDatabaseCount('users', 0);
});
