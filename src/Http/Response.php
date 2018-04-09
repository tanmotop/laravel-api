<?php
/**
 * Created by PhpStorm.
 * User: Hong
 * Date: 2018/4/9
 * Time: 17:37
 * Function:
 */

namespace Tanmo\Api\Http;


use Illuminate\Http\Response as IlluminateResponse;

class Response extends IlluminateResponse
{
    public function __construct($content = '', $status = 200, array $headers = array())
    {
        parent::__construct($content, $status, $headers);
    }
}