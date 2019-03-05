<?php
/**
 * Created by PhpStorm.
 * User: luanjun
 * Date: 2017/6/28
 * Time: 16:11
 */

namespace App\Tools;

class App
{

    public function __construct()
    {

    }

    public static function alert($code = 200, $title = "", $msg = "", $data = "", $type = "json")
    {
        $return = [
            "code" => $code,
            "title" => $title,
            "msg" => $msg,
        ];
        if ($data) {
            $return["data"] = $data;
        }

        if ($type == "json") {
            return response()->json($return);
        } else {
            return $return;
        }
    }

    public static function error($msg = "操作失败", $type = "json")
    {
        $return = [
            "code" => 300,
            "title" => "操作失败",
            "msg" => $msg,
        ];

        if ($type == "json") {
            return response()->json($return);
        } else {
            return $return;
        }
    }

    public static function success($msg = "操作成功", $data = "", $type = "json")
    {
        $return = [
            "code" => 200,
            "title" => "操作成功",
            "msg" => $msg,
        ];
        if ($data) {
            $return["data"] = $data;
        }

        if ($type == "json") {
            return response()->json($return);
        } else {
            return $return;
        }
    }
}