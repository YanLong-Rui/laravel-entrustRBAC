<?php
/**
 * Created by PhpStorm.
 * User: RYL
 * Date: 2019/2/19
 * Time: 10:28
 * 实现将 response 转换为 array 的类
 * 根据使用的 driver 自动转换结果。
 */

namespace App\Curl\bin;


use App\Exceptions\ResponseNotJsonException;
use App\Exceptions\ResponseNotXMLException;
use SimpleXMLElement;
class ApiData2ArrayFactory
{
    public static function make(CurlInterfaceDriver $curl)
    {
        if ($curl instanceof JsonHttpCurlDriver) {
            return static::json2Array($curl->getResponse());
        }

        if ($curl instanceof XMLHttpCurlDriver) {
            return static::xml2Array($curl->getResponse());
        }
        if ($curl instanceof StringCurlDriver) {
            return static::string2Array($curl->getResponse());
        }
    }

    /**
     * json 转数组
     *
     * @param $json
     * @return array
     * @date 2019/01/25
     * @author ycz
     * @throws ResponseNotJsonException
     */
    private static function json2Array($json)
    {
        try {
            $data = \GuzzleHttp\json_decode($json, true);
        } catch (\InvalidArgumentException $e) {
            throw new ResponseNotJsonException();
        }

        return $data;
    }
    /**
     * String 转数组
     *
     * @param $json
     * @return array
     * @date 2019/01/25
     * @author ycz
     * @throws ResponseNotJsonException
     */
    private static function string2Array($string)
    {
        $data = explode(',',$string);
        return $data;
    }
    /**
     * @param $xml
     * @return array
     * @date 2019/01/25
     * @author ycz
     * @throws ResponseNotXMLException
     */
    private static function xml2Array($xml)
    {
        if (!static::isXml($xml)) {
            throw new ResponseNotXMLException();
        }
        function _XML2Array(SimpleXMLElement $parent)
        {
            $array = array();

            foreach ($parent as $name => $element) {
                ($node = &$array[$name])
                && (1 === count($node) ? $node = array($node) : 1)
                && $node = &$node[];

                $node = $element->count() ? _XML2Array($element) : trim($element);
            }

            return $array;
        }

        $xml = new SimpleXMLElement($xml);
        $data = _XML2Array($xml);

        return $data;
    }

    /**
     * @param $xml
     * @return int
     * @date 2019/01/25
     * @author ycz
     */
    private static function isXml($xml)
    {
        return xml_parse(xml_parser_create(), $xml, true);
    }
}