<?php

namespace Itworks\classes;

class Input
{
 /**
     * Retorna um valor via post
     *
     * @param  string $param
     * @param  int $filter
     * @return mixed
     */
    public static function post(
        string $param, int $filter = FILTER_UNSAFE_RAW
    ) {
        return filter_input(INPUT_POST, $param, $filter);
    }

    /**
     * Retorna um valor via get
     *
     * @param  string $param
     * @param  int $filter
     * @return mixed
     */
    public static function get(
        string $param, int $filter = FILTER_UNSAFE_RAW
    ) {
        return filter_input(INPUT_GET, $param, $filter);
    }
}