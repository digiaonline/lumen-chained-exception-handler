<?php

namespace Nord\Lumen\ChainedExceptionHandler;

use Exception;
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
    public function report(Exception $e)
    {
        $this->primaryHandler->report($e);

        foreach ($this->secondaryHandlers as $handler) {
            $handler->report($e);
        }
    }


    /**
     * @inheritdoc
     */
    public function render($request, Exception $e)
    {
        return $this->primaryHandler->render($request, $e);
    }


    /**
     * @inheritdoc
     */
    public function renderForConsole($output, Exception $e)
    {
        $this->primaryHandler->renderForConsole($output, $e);
    }

    /**
     * @inheritdoc
     */
    public function shouldReport(Exception $e)
    {
        $this->primaryHandler->shouldReport($e);
    }
    
}
