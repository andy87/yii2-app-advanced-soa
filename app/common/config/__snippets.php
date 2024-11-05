<?php

if (!function_exists('printPre')){
    function printPre(string $method, $data, $exit = true): void
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