protected function unauthenticated($request, AuthenticationException $exception)
{
    if ($request->expectsJson()) {
        return response()->json([
            'success' => false,
            'message' => __('messages.unauthorized'),
        ], 401);
    }

    return redirect()->guest(route(app()->getLocale() . '.login'));
}
