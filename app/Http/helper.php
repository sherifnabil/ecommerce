<?php
if(!function_exists('aurl'))
{
    function aurl($arg = null)
    {
        return url('admin/' . $arg);

    }


}

if(!function_exists('admin'))
{
    function admin()
    {
        return  auth()->guard('admin');

    }



}
