<?php

namespace Tests\Unit\Middleware;

use App\Http\Middleware\BearerTokenMiddleware;
use Illuminate\Http\Request;
use Orchestra\Testbench\TestCase;

class BearerTokenMiddlewareTest extends TestCase
{
    protected function getEnvironmentSetUp($app)
    {
        $app['config']->set('app.api_bearer_token', 'valid-token');
    }

    /**
     * Тест, что запрос без заголовка Authorization возвращает 401.
     */
    public function test_missing_authorization_header()
    {
        $middleware = new BearerTokenMiddleware();
        $request = Request::create('/api/resource', 'GET');

        $response = $middleware->handle($request, function () {});

        $this->assertEquals(401, $response->status());
        $this->assertEquals(['message' => 'Unauthorized'], $response->getData(true));
    }

    /**
     * Тест, что запрос с неверным токеном возвращает 401.
     */
    public function test_invalid_token()
    {
        $middleware = new BearerTokenMiddleware();
        $request = Request::create('/api/resource', 'GET');
        $request->headers->set('Authorization', 'Bearer invalid-token');

        $response = $middleware->handle($request, function () {});

        $this->assertEquals(401, $response->status());
        $this->assertEquals(['message' => 'Unauthorized'], $response->getData(true));
    }

    /**
     * Тест, что запрос с корректным токеном проходит дальше.
     */
    public function test_valid_token()
    {
        $middleware = new BearerTokenMiddleware();
        $request = Request::create('/api/resource', 'GET');
        $request->headers->set('Authorization', 'Bearer valid-token');

        $response = $middleware->handle($request, function () {
            return response('Success', 200);
        });

        $this->assertEquals(200, $response->status());
        $this->assertEquals('Success', $response->getContent());
    }
}
