<?php
/**
 * Created by PhpStorm.
 * User: Hong
 * Date: 2018/4/10
 * Time: 14:59
 * Function:
 */

namespace Tanmo\Api\Exceptions;


use Symfony\Component\HttpKernel\Exception\HttpException;
use Tanmo\Api\Http\Response;

class ApiException extends HttpException
{
    /**
     * @return Response
     */
    public function render()
    {
        $debug = [
            'line' => $this->getLine(),
            'file' => $this->getFile(),
            'class' => get_class($this),
            'trace' => explode("\n", $this->getTraceAsString()),
        ];

        return (new Response($this->getMessage(), $this->getStatusCode(), $this->getHeaders()))->setDebugData($debug);
    }
}