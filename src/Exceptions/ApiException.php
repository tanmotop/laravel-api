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
     * @var Response
     */
    protected $response;

    /**
     * ApiException constructor.
     * @param int $statusCode
     * @param null $message
     * @param \Exception|null $previous
     * @param array $headers
     * @param int $code
     */
    public function __construct($statusCode, $message = null, \Exception $previous = null, array $headers = array(), $code = 0)
    {
        $this->response = new Response($message, $statusCode, $headers);
        parent::__construct($statusCode, $message, $previous, $headers, $code);
    }

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

        return $this->response->setDebugData($debug);
    }
}