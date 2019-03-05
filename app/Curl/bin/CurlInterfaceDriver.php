<?php
/**
 * Created by PhpStorm.
 * User: RYL
 * Date: 2019/2/19
 * Time: 10:03
 */
namespace App\Curl\bin;

interface CurlInterfaceDriver
{
    public function get($url, $options = []);

    public function post($url, $options = []);

    public function request($method, $url, $options = []);
}