<?php
/**
 * Created by PhpStorm.
 * User: RYL
 * Date: 2019/2/19
 * Time: 11:20
 */

namespace App\Exceptions;

use Exception;
use \Illuminate\Http\Request;
class ResponseNotJsonException extends Exception
{
    /**
     * 报告这个异常。
     *
     * @return void
     */
    public function report()
    {
    }

    /**
     * 将异常渲染至 HTTP 响应值中。
     *
     * @param  \Illuminate\Http\Request
     * @return \Illuminate\Http\Response
     */
    public function render(Request $request)
    {
        return response()->view(
            'errors.notJson',
            array(
                'exception' => $this
            )
        );
    }
}