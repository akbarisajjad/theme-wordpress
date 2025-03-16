
public function testUnauthenticatedAccess()
{
    $response = $this->get('/dashboard');

    $response->assertRedirect(route(app()->getLocale() . '.login'));
}

public function testAuthenticatedAccess()
{
    $user = User::factory()->create();

    $response = $this->actingAs($user)->get('/dashboard');

    $response->assertOk();
}
