<?php

if (function_exists('printPre') === false)
{
    /**
     * @param string $method
     * @param mixed $data
     * @param bool $exit
     *
     * @return void
     */
    function printPre(string $method, mixed $data, bool $exit = true): void
    {
        if (str_contains($method, '::') OR $method === '{closure}') {

            echo '<pre>';
            print_r([$method => $data]);
            echo '</pre>';
            if ($exit) exit;

        } else {

            exit('USE printPre( __METHOD__, you_data);');
        }
    }
}