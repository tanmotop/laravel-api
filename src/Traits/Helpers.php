<?php
/**
 * Created by PhpStorm.
 * User: Hong
 * Date: 2018/4/9
 * Time: 17:25
 * Function:
 */

namespace Tanmo\Api\Traits;


use Tanmo\Api\Http\Factory;

trait Helpers
{
    /**
     * @return \Tanmo\Api\Http\Factory
     */
    public function response()
    {
        return app(Factory::class);
    }
}