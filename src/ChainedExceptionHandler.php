<?php

namespace Nord\Lumen\ChainedExceptionHandler;

use Throwable;
use Illuminate\Contracts\Debug\ExceptionHandler;

/**
 * Class ChainedExceptionHandler
 * @package Nord\Lumen\ChainedExceptionHandler
 */
class ChainedExceptionHandler implements ExceptionHandler
{

    /**
     * @var ExceptionHandler
     */
    private $primaryHandler;

    /**
     * @var ExceptionHandler[]
     */
    private $secondaryHandlers;


    /**
     * ChainedExceptionHandler constructor.
     *
     * @param ExceptionHandler   $primaryHandler
     * @param ExceptionHandler[] $secondaryHandlers (optional)
     */
    public function __construct(ExceptionHandler $primaryHandler, array $secondaryHandlers = [])
    {
        $this->primaryHandler    = $primaryHandler;
        $this->secondaryHandlers = $secondaryHandlers;
    }


    /**
     * @inheritdoc
     */
    public function report(Throwable $t)
    {
        $this->primaryHandler->report($t);

        foreach ($this->secondaryHandlers as $handler) {
            $handler->report($t);
        }
    }


    /**
     * @inheritdoc
     */
    public function render($request, Throwable $t)
    {
        return $this->primaryHandler->render($request, $t);
    }


    /**
     * @inheritdoc
     */
    public function renderForConsole($output, Throwable $t)
    {
        $this->primaryHandler->renderForConsole($output, $t);
    }

    /**
     * @inheritdoc
     */
    public function shouldReport(Throwable $t)
    {
        $this->primaryHandler->shouldReport($t);
    }
    
}
