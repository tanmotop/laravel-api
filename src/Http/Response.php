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
     * @var bool
     */
    protected $debug;

    /**
     * @var
     */
    protected $debugData;

    /**
     * Response constructor.
     * @param string $content
     * @param int $status
     * @param array $headers
     */
    public function __construct($content = '', $status = 200, array $headers = array())
    {
        $this->debug = config('api.debug');

        parent::__construct($content, $status, $headers);
    }

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
            return $this->resource->response($request)->setStatusCode($this->status());
        }

        ///
        $data = [
            'status_code' => $this->getStatusCode(),
            'message' => $this->getContent(),
        ];

        if ($this->debug && !empty($this->debugData)) {
            $data['debug'] = $this->debugData;
        }

        return response()->json($data, $this->status());
    }

    /**
     * @param $data
     * @return $this
     */
    public function setDebugData($data)
    {
        $this->debugData = $data;

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
     *
     */
    public function noContent()
    {
        $this->setStatusCode(self::HTTP_NO_CONTENT);

        return $this;
    }
}