<?php
/**
 * Created by PhpStorm.
 * User: RYL
 * Date: 2019/2/18
 * Time: 14:44
 */

namespace App\Http\Controllers\Admin;


use App\Http\Controllers\Controller;
use App\Curl\Amazon\AmazonCurl;
use \Illuminate\Http\Request;
class IndexController extends Controller
{

    public function index(Request $request)
    {
        /*$amazonCurl = new AmazonCurl();
        $result = $amazonCurl->getProductList();
        echo "<pre>";
        print_r($result);
        exit;*/
        return view('admin.index.index');
    }
}