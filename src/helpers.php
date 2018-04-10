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