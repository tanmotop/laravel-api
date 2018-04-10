<?php

if (!function_exists('api_path')) {

    /**
     * Get api path.
     *
     * @param string $path
     *
     * @return string
     */
    function api_path($path = '')
    {
        return ucfirst(config('api.directory')).($path ? DIRECTORY_SEPARATOR.$path : $path);
    }
}

if (!function_exists('api')) {

    /**
     * Get api Factory
     *
     * @return \Tanmo\Api\Http\Factory
     */
    function api()
    {
        return app(\Tanmo\Api\Http\Factory::class);
    }
}