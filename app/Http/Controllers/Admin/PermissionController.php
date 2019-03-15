<?php
/**
 * Created by PhpStorm.
 * User: RYL
 * Date: 2019/2/18
 * Time: 14:44
 */

namespace App\Http\Controllers\Admin;


use App\Http\Controllers\Controller;
use App\Jobs\AlertJob;
use \Illuminate\Http\Request;
use App\Models\Role;
use App\Models\Permission;
use App\User;
use App\Tools\App;
use \DB;
class PermissionController extends Controller
{

    public function index(Request $request)
    {
/*
        $job = (new AlertJob());
        $res = $job::dispatch()->delay(30);
        echo "<pre>";
        var_dump($res);
        exit;*/

        if ($request->isMethod("post")) {
            $items = new Permission();
            $items = $items->orderBy("sort", "asc")->get()->toArray();
            $selector = $this->get_attr($items);
            if ($request->has("selector")) {
                return App::success($selector);
            } else {
                $render = view('admin.author.permission.nestable', ["data" => $selector])->render();
                return App::success($render);
            }
        }

        return view('admin.author.permission.index');
    }


    public function get_attr($data, $pid = "0")
    {
        $tree = array();                                //每次都声明一个新数组用来放子元素
        foreach ($data as $v) {
            if ($v['parent_id'] == $pid) {                      //匹配子记录
                $v['children'] = $this->get_attr($data, $v['id']); //递归获取子记录
                if ($v['children'] == null) {
                    unset($v['children']);             //如果子元素为空则unset()进行删除，说明已经到该分支的最后一个元素了（可选）
                }
                $tree[] = $v;                           //将记录存入新数组
            }
        }
        return $tree;                                  //返回新数组
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $perm = new Permission;
        $perm->name = $request->name;
        $perm->display_name = $request->display_name;
        $perm->description = $request->description;
        $perm->parent_id = $request->parent;

        //自动生成排序
        $items = new Permission();
        $count = $items->where("parent_id", $request->parent)->count();
        $perm->sort = $count + 1;
        if ($perm->save()) {
            return App::success();
        } else {
            return App::error();
        }
    }

    /**
     * 权限管理删除
     * @param Request $request
     * @return array|\Illuminate\Http\JsonResponse
     */
    public function delPerm(Request $request)
    {
        $id = $request->id;
        $perm = new Permission;
        $data = $perm->where('parent_id', $id)->first();
        if (!empty($data->id)) {
            //return ['code' => 1];
            return App::error("存在子级节点，不可删除");
        } else {
            $data = $perm->destroy($id);
            if ($data) {
                $result = DB::table('permission_role')->where("permission_id", $id)->delete();
                if ($result !== false) {
                    return App::success();
                } else {
                    return App::error();
                }
                //return ['code' => 0];
            } else {
                //return ['code' => 2, 'message' => '删除失败'];
                return App::error();
            }
        }

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Permission $permission
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request)
    {
        $id = $request->input("id");
        $info = Permission::find($id);
        if ($request->isMethod("post")) {
            $info->name = $request->name;
            $info->display_name = $request->display_name;
            $info->description = $request->description;
            $info->parent_id = $request->parent_id;

            if ($info->save()) {
                return App::success();
            } else {
                return App::error();
            }
        }
        $items = Permission::instance()->orderBy("sort", "asc")->get()->toArray();
        $tree = $this->get_attr($items);
        $render = view('admin.author.permission.permedit', ["info" => $info, "selector" => $tree])->render();
        return App::success($render);
    }
}