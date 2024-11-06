<?php

if ( function_exists('printPre') === false )
{
    /**
     * @param string $id
     * @param mixed $data
     * @param bool $exit
     *
     * @return void
     */
    function printPre( string $id, mixed $data, bool $exit = true): void
    {
        echo '<pre>';
        print_r([ $id => $data ]);
        echo '</pre>';
        if ($exit) exit;
    }
}