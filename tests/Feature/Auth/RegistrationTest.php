<?php

test('registration screen can be rendered', function () {
    $response = $this->get(route('register'));

    $response->assertStatus(200);
});

test('new users can register', function () {
    $response = $this->post(route('register.store'), [
        'first_name' => 'Test',
        'last_name' => 'User',
        'phone' => '+39 333 1234567',
        'email' => 'test@example.com',
        'password' => 'Xk7$mP!9qL2b',
        'password_confirmation' => 'Xk7$mP!9qL2b',
    ]);

    $this->assertAuthenticated();
    $response->assertRedirect(route('dashboard', absolute: false));
});
