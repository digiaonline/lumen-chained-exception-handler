<?php

namespace Nord\Lumen\ChainedExceptionHandler\Tests;

use Illuminate\Contracts\Debug\ExceptionHandler;
use Nord\Lumen\ChainedExceptionHandler\ChainedExceptionHandler;

/**
 * Class ChainedExceptionHandlerTest
 * @package Nord\Lumen\ChainedExceptionHandler\Tests
 */
class ChainedExceptionHandlerTest extends \PHPUnit_Framework_TestCase
{

    /**
     * Tests that report() is propagated properly
     */
    public function testReport()
    {
        $exception = new \Exception();

        $primaryHandler = $this->getMockedHandler();
        $primaryHandler->expects($this->once())
                       ->method('report')
                       ->with($exception);

        $secondaryHandler = $this->getMockedHandler();
        $secondaryHandler->expects($this->once())
                         ->method('report');

        $chainedHandler = new ChainedExceptionHandler($primaryHandler, [$secondaryHandler]);
        $chainedHandler->report($exception);
    }


    /**
     * Tests that render() is propagated properly
     */
    public function testRender()
    {
        $exception = new \Exception();

        $primaryHandler = $this->getMockedHandler();
        $primaryHandler->expects($this->once())
                       ->method('render')
                       ->with(null, $exception);

        $secondaryHandler = $this->getMockedHandler();
        $secondaryHandler->expects($this->never())
                         ->method('render');

        $chainedHandler = new ChainedExceptionHandler($primaryHandler, [$secondaryHandler]);
        $chainedHandler->render(null, $exception);
    }


    /**
     * Tests that renderForConsole() is propagated properly
     */
    public function testRenderForConsole()
    {
        $exception = new \Exception();

        $primaryHandler = $this->getMockedHandler();
        $primaryHandler->expects($this->once())
                       ->method('renderForConsole')
                       ->with(null, $exception);

        $secondaryHandler = $this->getMockedHandler();
        $secondaryHandler->expects($this->never())
                         ->method('renderForConsole');

        $chainedHandler = new ChainedExceptionHandler($primaryHandler, [$secondaryHandler]);
        $chainedHandler->renderForConsole(null, $exception);
    }


    /**
     * Returns a mocked exception handler
     *
     * @return \PHPUnit_Framework_MockObject_MockObject|ExceptionHandler
     */
    private function getMockedHandler()
    {
        return $this->getMockBuilder(ExceptionHandler::class)
                    ->setMethods(['report', 'render', 'renderForConsole'])
                    ->getMock();
    }

}
