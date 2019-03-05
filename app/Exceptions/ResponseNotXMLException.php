<?php
/**
 * Created by PhpStorm.
 * User: RYL
 * Date: 2019/2/19
 * Time: 11:36
 */

namespace App\Exceptions;

use \Illuminate\Http\Request;
use Exception;
class ResponseNotXMLException extends Exception
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
            'errors.notXML',
            array(
                'exception' => $this
            )
        );
    }
}