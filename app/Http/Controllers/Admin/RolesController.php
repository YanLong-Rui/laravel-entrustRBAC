<?php
/**
 * Created by PhpStorm.
 * User: RYL
 * Date: 2019/2/18
 * Time: 14:44
 */

namespace App\Http\Controllers\Admin;


use App\Http\Controllers\Controller;
use \Illuminate\Http\Request;
use App\Models\Role;
use App\Models\Permission;
use \DB;
use App\Tools\App;
use App\User;
use App\Models\RoleUser;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use App\Events\UserPermission;
class RolesController extends Controller
{

    //角色列表页
    function index(Request $request)
    {
        if ($request->isMethod("post")) {
            $page = $request->input("page");//当前页
            $rows = $request->input("rows");//每页记录数
            $sidx = $request->input("sidx");//排序字段名
            $sord = $request->input("sord");//排序方式：asc， desc

            $list = Role::instance();

            $list = $list->skip(($page - 1) * $rows)->take($rows);
            if ($sidx) {
                $list = $list->orderBy($sidx, $sord);
            }
            $data = $list->get();

            $count = Role::count();
            $return["page"] = (int)$page;
            $return["total"] = ceil($count / $rows);
            $return["records"] = $count;

            if (!$data->isEmpty()) {
                $data = json_decode(json_encode($data), true);
                foreach ($data as $k => $v) {
                    $return["rows"][$k]["id"] = $v['id'];
                    $return["rows"][$k]["name"] = $v["name"];
                    $return["rows"][$k]["display_name"] = $v['display_name'];
                    $return["rows"][$k]["description"] = $v["description"];

                    $authorize = "<button class='btn btn-success btn-xs btn-user-role' type='button' data-id='" . $v["id"] . "'>该组中的用户</button>";
                    $authorize .= "<button class='btn btn-danger btn-xs btn-authorize' type='button' data-id='" . $v["id"] . "'>已授权的权限</button>";
                    $return["rows"][$k]["authorize"] = $authorize;

                    if ($v['state'] == "1") {
                        $operations = "<button class='btn btn-outline btn-danger btn-xs btn-edit-state' type='button' data-id='" . $v["id"] . "' data-state='0'>禁用</button><button class='btn btn-outline btn-default btn-xs btn-del' type='button' data-id='" . $v["id"] . "'>删除</button>";
                        $state = "正常";
                    } else {
                        $operations = "<button class='btn btn-outline btn-primary btn-xs btn-edit-state' type='button' data-id='" . $v["id"] . "' data-state='1'>启用</button><button class='btn btn-outline btn-default btn-xs btn-del' type='button' data-id='" . $v["id"] . "'>删除</button>";
                        $state = "冻结";
                    }
                    $return["rows"][$k]["operations"] = $operations;
                    $return["rows"][$k]["state"] = $state;
                }
            }

            return response()->json($return);
        }

        return view('admin.author.permission.roles');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        /*
         * 创建角色表单页
         */
        if ($request->isMethod("post")) {
            $user = new Role;
            $user->name = $request->name;
            $user->display_name = $request->display_name;
            $user->description = $request->description;
            if (!empty($request->state)) {
                $user->state = "1";
            } else {
                $user->state = "0";
            }

            if ($user->save()) {
                return redirect('permission/roles');
            } else {
                return back()->withInput();
            }
        }
        return view('admin.author.permission.rolescreate');
    }

    /**
    * 权限分配用户列表
    * $request->id 角色ID Get
     * $data 已拥有当前角色用户列表
    * $rid 角色ID
    */
    function userRoleList(Request $request)
    {
        //这个角色已经有的用户
        $data = RoleUser::instance()->where('role_id',$request->id)->get();
        return view('admin.author.permission.roleuserlist')->with(["data" => $data, "rid" => $request->id]);
    }

    function rolePermList(Request $request)
    {
        $role_id = $request->input("role_id");
        if ($request->isMethod("post")) {
            //添加权限
            $rules = $request->input("rules");

            DB::table('permission_role')->where('role_id', $role_id)->delete();
            $array = [];
            foreach ($rules as $value) {
                $array[] = ['role_id' => $role_id, 'permission_id' => $value];
            }
            $result = DB::table('permission_role')->insert($array);


            if($result) {
                event(new UserPermission(Auth::id()));
                return App::success();
            }
            return App::error();
        }

        $data = Permission::instance()->orderBy('sort', 'asc')->get();
        if ($data->isEmpty()) {
            return App::error("系统中暂无权限可管理！");
        }

        $data    = $data->toArray();
        $getData = $this->get_attr($data);
        //获取已有操作权限ID
        $permid = DB::table("permission_role")->select("permission_id")->where('role_id', $role_id)->get()->toArray();
        $perm = [];
        foreach ($permid as $p) {
            $perm[] = $p->permission_id;
        }

        $view = view('admin.author.permission.rolepermlist_new', compact("getData", "role_id", "perm"))->render();
        return App::alert(200, "访问授权", $view);
    }
    public function get_attr($data, $pid = "0")
    {
        $tree = [];                                //每次都声明一个新数组用来放子元素
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

    function userRoleAdd(Request $request)
    {
        $rid = $request->input("rid");

        $role_user = DB::table("role_user")
            ->join("users", "users.id", "=", "role_user.user_id")
            ->where("role_id", $rid)
            ->select('role_user.*', 'users.name')
            ->get();

        if ($request->isMethod("post")) {
            $type = $request->input("type");
            if ($type == "user") {
                $page = $request->input("page");//当前页
                $rows = $request->input("rows");//每页记录数
                $sidx = $request->input("sidx");//排序字段名
                $sord = $request->input("sord");//排序方式：asc， desc

                $list = User::instance();
                if ($keyword = $request->input("keyword")) {
                    $list = $list->where("name", "like", "%" . $keyword . "%")
                        ->orWhere("phone", "like", "%" . $keyword . "%");
                }
                $state = $request->input("state", "");
                if ($state !== '' && $state != null) {
                    $list = $list->where("state", $state);
                }
                $list = $list->skip(($page - 1) * $rows)->take($rows);
                if ($sidx) {
                    $list = $list->orderBy($sidx, $sord);
                }
                $data = $list->get();

                $count = User::count();
                $return["page"] = (int)$page;
                $return["total"] = ceil($count / $rows);
                $return["records"] = $count;

                if ($user = $request->input("user")) {
                    $user_array = $user;
                } else {
                    $role_user_array = json_decode(json_encode($role_user), true);
                    $user_array = array_column($role_user_array, "user_id");
                }

                foreach ($data as $k => $v) {
                    $checked = in_array($v["id"], $user_array) ? "checked" : "";
                    $return["rows"][$k]["checkbox"] = "<input type='checkbox' name='selUser' $checked  value='" . $v["id"] . "' user-name='" . $v["name"] . "' />";
                    $return["rows"][$k]["id"] = $v["id"];
                    $return["rows"][$k]["name"] = $v["name"];
                    $return["rows"][$k]["email"] = $v["email"];
                    $return["rows"][$k]["created_at"] = $v->created_at->format('Y-m-d H:i:s');
                    $return["rows"][$k]["updated_at"] = $v->updated_at->format('Y-m-d H:i:s');
                }
                return response()->json($return);
            } else {
                //添加操作
                $user = $request->input("data");

                //删除当前组内的所有成员
                RoleUser::instance()->where("role_id", $rid)->delete();

                //删除选择用户的权限（防止用户在其他组）
                RoleUser::instance()->whereIn("user_id", $user)->delete();

                $data = [];
                foreach ($user as $k => $v) {
                    $data[$k] = ["role_id" => $rid, "user_id" => $v];
                }

                $result = RoleUser::instance()->insert($data);
                if ($result) {
                    return App::success();
                } else {
                    return App::error();
                }
            }
        }

        $render = view('admin.author.permission.roleAdd', compact("rid", "role_user"))->render();
        return App::success($render);
    }

    /**
     * 解除用户权限
     * @param Request $request
     * @return array|\Illuminate\Http\JsonResponse
     */
    function userRoleDel(Request $request)
    {
        $uid = $request->uid;
        $rid = $request->rid;
        $db = DB::table('role_user')
            ->where("role_id", "=", $rid)
            ->where("user_id", "=", $uid)
            ->delete();
        //return array("state" => $db);
        if ($db) {
            return App::success();
        } else {
            return App::error();
        }
    }

    /**
 * 删除用户组 记得删除2张关联表
 * $arr 返回成功参数     1：成功
 */
    public function delRole(Request $request)
    {

        $db = DB::transaction(function () use ($request) {
            DB::table('permission_role')->where('role_id', '=', $request->id)->delete();
            DB::table('role_user')->where('role_id', '=', $request->id)->delete();
            DB::table('roles')->where('id', '=', $request->id)->delete();
        });
        $role = DB::table('roles')->find($request->id);
        if (empty($role)) {
            $arr = array("state" => "1");
            return $arr;
        } else {
            $arr = array("state" => "0");
            return $arr;
        }
    }

    /**
     * 删除用户组 记得删除2张关联表
     * $arr 返回成功参数     1：成功
     */
    public function roleEdit(Request $request)
    {
        $user = Role::find($request->id);
        $user->state = $request->state;
        if ($user->save()) {
            if (!$request->state) {
                $arr = array("state" => "1", 'statename' => '冻结', "html" => "<button class='btn btn-outline btn-primary' type='button' onclick=editState('" . $request->id . "','1',this)>启用</button><button class='btn btn-outline btn-default' type='button' onclick=delRole('" . $request->id . "',this)>删除</button>");
            } else {
                $arr = array("state" => "1", 'statename' => '正常', "html" => "<button class='btn btn-outline btn-danger' type='button' onclick=editState('" . $request->id . "','0',this)>禁用</button><button class='btn btn-outline btn-default' type='button' onclick=delRole('" . $request->id . "',this)>删除</button>");
            }
            return $arr;
        } else {
            $arr = array("state" => "0");
            return $arr;
        }
    }
}