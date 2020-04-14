<?php

use Mockery as m;

class ExceptionHandlerTest extends TestCase {
    use m\Adapter\Phpunit\MockeryPHPUnitIntegration;

    /** @test */
    public function it_returns_html_when_json_is_not_excepted() {
        $subject = m::mock(\App\Exceptions\Handler::class)->makePartial();
        $subject->shouldNotReceive('isDebugMode');

        $request = m::mock(\Illuminate\Http\Request::class);
        $request->shouldReceive('expectsJson')->andReturn(false);

        $exception = m::mock(Exception::class, ['Error!']);
        $exception->shouldNotReceive('getStatusCode');
        $exception->shouldNotReceive('getMessage');
        $exception->shouldNotReceive('getTrace');

        $result = $subject->render($request, $exception);

        $this->assertNotInstanceOf(\Illuminate\Http\JsonResponse::class, $result);
    }

    /** @test */
    public function it_returns_json_when_excepted() {
        $this->markTestIncomplete('test pending');
    }

    /** @test */
    public function it_returns_400_for_non_http_exceptions() {
        $this->markTestIncomplete('test pending');
    }

    /** @test */
    public function it_returns_http_status_codes_for_http_exceptions() {
        $this->markTestIncomplete('test pending');
    }

    /** @test */
    public function it_returns_debug_info_when_debugging_enabled() {
        $this->markTestIncomplete('test pending');
    }

    /** @test */
    public function it_skips_debug_info_when_debugging_disabled() {
        $this->markTestIncomplete('test pending');
    }
}
