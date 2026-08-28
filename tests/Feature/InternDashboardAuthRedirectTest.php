<?php

namespace Tests\Feature;

use Tests\TestCase;

class InternDashboardAuthRedirectTest extends TestCase
{
    public function test_intern_dashboard_redirects_to_intern_login_when_not_authenticated(): void
    {
        $response = $this->get('/intern/dashboard');

        $response->assertRedirect(route('intern.login'));
    }
}
