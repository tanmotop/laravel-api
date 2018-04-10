<?php
/**
 * Created by PhpStorm.
 * User: Hong
 * Date: 2018/4/9
 * Time: 17:37
 * Function:
 */

namespace Tanmo\Api\Http;


use Illuminate\Contracts\Support\Responsable;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Response as IlluminateResponse;

class Response extends IlluminateResponse implements Responsable
{
    /**
     * @var JsonResource
     */
    protected $resource;

    /**
     * @param $resource
     * @return $this
     */
    public function setResource($resource)
    {
        $this->resource = $resource;
        return $this;
    }

    /**
     * @param array $meta
     * @return $this
     */
    public function setMeta(array $meta = [])
    {
        if (!empty($this->resource)) {
            $this->resource->additional(['meta' => $meta]);
        }

        return $this;
    }

    /**
     * Create an HTTP response that represents the object.
     *
     * @param \Illuminate\Http\Request $request
     * @return $this|\Illuminate\Http\JsonResponse
     */
    public function toResponse($request)
    {
        if (!empty($this->resource)) {
            $response = $this->resource->toResponse($request);
            $response->setStatusCode($this->status());

            return $response;
        }

        return $this;
    }

    /**
     * @return $this
     */
    public function created()
    {
        $this->setStatusCode(self::HTTP_CREATED);

        return $this;
    }

    /**
     * @return $this
     */
    public function accepted()
    {
        $this->setStatusCode(self::HTTP_ACCEPTED);

        return $this;
    }

    /**
     * @return $this
     */
    public function noContent()
    {
        $this->setStatusCode(self::HTTP_NO_CONTENT);

        return $this;
    }
}