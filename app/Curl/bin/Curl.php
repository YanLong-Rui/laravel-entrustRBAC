<?php
/**
 * Created by PhpStorm.
 * User: RYL
 * Date: 2019/2/19
 * Time: 10:31
 */

namespace App\Curl\bin;


class Curl
{
    private $curlDriver = null;

    public function __construct(CurlInterfaceDriver $curl)
    {
        $this->curlDriver = $curl;
    }

    public function __call($name, $arguments)
    {
        $this->curlDriver->$name(...$arguments);

        return ApiData2ArrayFactory::make($this->curlDriver);
    }
}