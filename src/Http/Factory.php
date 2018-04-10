<?php
/**
 * Created by PhpStorm.
 * User: Hong
 * Date: 2018/4/9
 * Time: 17:41
 * Function:
 */

namespace Tanmo\Api\Http;


use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Support\Str;
use Symfony\Component\HttpKernel\Exception\HttpException;

class Factory
{
    /**
     * @var Response
     */
    protected $response;

    /**
     * Factory constructor.
     * @param Response $response
     */
    public function __construct(Response $response)
    {
        $this->response = $response;
    }

    /**
     * @param null $location
     * @param null $content
     * @return Response
     */
    public function created($content = null, $location = null)
    {
        $this->response->created()->setContent($content);
        if (! is_null($location)) {
            $this->response->header('Location', $location);
        }

        return $this->response;
    }

    /**
     * @param null $location
     * @param null $content
     * @return Response
     */
    public function accepted($content = null, $location = null)
    {
        $this->response->accepted()->setContent($content);
        if (! is_null($location)) {
            $this->response->header('Location', $location);
        }

        return $this->response;
    }

    /**
     * @return Response
     */
    public function noContent()
    {
        return $this->response->noContent();
    }

    /**
     * @param $resource
     * @param $transformer
     * @return Response
     */
    public function item($resource, $transformer)
    {
        if (!class_exists($transformer) || !is_subclass_of($transformer, JsonResource::class)) {
            $this->errorInternal();
        }

        return $this->response->setResource(new $transformer($resource));
    }

    /**
     * @param $resources
     * @param $transformer
     * @return Response
     */
    public function collection($resources, $transformer)
    {
        if (!is_null($transformer) && is_subclass_of($transformer, ResourceCollection::class)) {
            return $this->response->setResource(new $transformer($resources));
        }

        if (!class_exists($transformer) || !is_subclass_of($transformer, JsonResource::class)) {
            $this->errorInternal();
        }

        return $this->response->setResource(new AnonymousResourceCollection($resources, $transformer));
    }

    /**
     * @param $message
     * @param $statusCode
     */
    public function error($message, $statusCode)
    {
        throw new HttpException($statusCode, $message);
    }

    /**
     * Return a 404 not found error.
     *
     * @param string $message
     *
     * @throws \Symfony\Component\HttpKernel\Exception\HttpException
     *
     * @return void
     */
    public function errorNotFound($message = 'Not Found')
    {
        $this->error($message, 404);
    }

    /**
     * Return a 400 bad request error.
     *
     * @param string $message
     *
     * @throws \Symfony\Component\HttpKernel\Exception\HttpException
     *
     * @return void
     */
    public function errorBadRequest($message = 'Bad Request')
    {
        $this->error($message, 400);
    }

    /**
     * Return a 403 forbidden error.
     *
     * @param string $message
     *
     * @throws \Symfony\Component\HttpKernel\Exception\HttpException
     *
     * @return void
     */
    public function errorForbidden($message = 'Forbidden')
    {
        $this->error($message, 403);
    }

    /**
     * Return a 500 internal server error.
     *
     * @param string $message
     *
     * @throws \Symfony\Component\HttpKernel\Exception\HttpException
     *
     * @return void
     */
    public function errorInternal($message = 'Internal Error')
    {
        $this->error($message, 500);
    }

    /**
     * Return a 401 unauthorized error.
     *
     * @param string $message
     *
     * @throws \Symfony\Component\HttpKernel\Exception\HttpException
     *
     * @return void
     */
    public function errorUnauthorized($message = 'Unauthorized')
    {
        $this->error($message, 401);
    }

    /**
     * Return a 405 method not allowed error.
     *
     * @param string $message
     *
     * @throws \Symfony\Component\HttpKernel\Exception\HttpException
     *
     * @return void
     */
    public function errorMethodNotAllowed($message = 'Method Not Allowed')
    {
        $this->error($message, 405);
    }

    /**
     * Call magic methods beginning with "with".
     *
     * @param string $method
     * @param array  $parameters
     *
     * @throws \ErrorException
     *
     * @return mixed
     */
    public function __call($method, $parameters)
    {
        if (Str::startsWith($method, 'with')) {
            return call_user_func_array([$this, Str::camel(substr($method, 4))], $parameters);

            // Because PHP won't let us name the method "array" we'll simply watch for it
            // in here and return the new binding. Gross. This is now DEPRECATED and
            // should not be used. Just return an array or a new response instance.
        } elseif ($method == 'array') {
            return new Response($parameters[0]);
        }

        throw new \ErrorException('Undefined method '.get_class($this).'::'.$method);
    }
}