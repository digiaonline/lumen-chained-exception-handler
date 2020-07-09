<?php

namespace Nord\Lumen\ChainedExceptionHandler;

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
    public function report(\Throwable $e)
    {
        $this->primaryHandler->report($e);

        foreach ($this->secondaryHandlers as $handler) {
            $handler->report($e);
        }
    }


    /**
     * @inheritdoc
     */
    public function render($request, \Throwable $e)
    {
        return $this->primaryHandler->render($request, $e);
    }


    /**
     * @inheritdoc
     */
    public function renderForConsole($output, \Throwable $e)
    {
        $this->primaryHandler->renderForConsole($output, $e);
    }

    /**
     * @inheritdoc
     */
    public function shouldReport(\Throwable $e)
    {
        $this->primaryHandler->shouldReport($e);
    }
    
}
