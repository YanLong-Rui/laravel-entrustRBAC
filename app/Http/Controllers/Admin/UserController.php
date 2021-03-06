<?php
/**
 * Created by PhpStorm.
 * User: RYL
 * Date: 2019/2/18
 * Time: 14:44
 */

namespace App\Http\Controllers\Admin;


use App\Http\Controllers\Controller;
use App\Models\Countries;
use \Illuminate\Http\Request;
use App\Models\Role;
use App\User;
use App\Tools\App;
use Illuminate\Support\Facades\Hash;
use App\Models\RoleUser;
use \Exception;
use App\Post;
use App\Http\Resources\User as UserResource;
use App\Comments;
class UserController extends Controller
{

    public function index(Request $request)
    {


        /*$post = Post::find(1);

        echo "<pre>";
        print_r($post->comments->toArray());
        exit;*/
        //collection tests
        /*$data = collect([
            10 => ['user' => 1, 'skill' => 1, 'roles' => ['Role_1', 'Role_3']],
            20 => ['user' => 2, 'skill' => 1, 'roles' => ['Role_1', 'Role_2']],
            30 => ['user' => 3, 'skill' => 2, 'roles' => ['Role_1']],
            40 => ['user' => 4, 'skill' => 2, 'roles' => ['Role_2']],
        ]);
        $result = $data->groupBy([
            'skill',
            function ($item) {
                return $item['roles'];
            },
        ], $preserveKeys = true)->toArray();
        echo "<pre>";
        print_r($result);
        exit;*/
        //模型远程一对多调用测试
        /*$userData = new Countries();
        $userData = $userData::find(27);
        echo "<pre>";
        print_r($userData->posts->toArray());
        exit;*/




        if($request->isMethod("post")){
            $page = $request->input("page");//当前页
            $rows = $request->input("rows");//每页记录数
            $sidx = $request->input("sidx");//排序字段名
            $sord = $request->input("sord");//排序方式：asc， desc

            $list = new User();
            $list = $list->skip(($page - 1) * $rows)->take($rows);
            if ($sidx) {
                $list = $list->orderBy($sidx, $sord);
            }
            $data = $list->get();

            $count = User::count();
            $return["page"]    = (int)$page;
            $return["total"]   = ceil($count / $rows);
            $return["records"] = $count;

            if (!$data->isEmpty()) {
                $data = $data->toArray();
                foreach ($data as $k => $v) {
                    $return["rows"][$k]["id"] = $v['id'];
                    $return["rows"][$k]["name"] = $v["name"];
                    $return["rows"][$k]["email"] = $v["email"];
                    $operations = "<button class='btn btn-info btn-edit' type='button' data-id='" . $v["id"] . "'>编辑</button>";
                    $return["rows"][$k]["operations"] = $operations;
                }
            }
            return response()->json($return);
        }
        return view('admin.author.index');
    }
    //用户添加
    public function add(User $User,Request $request){
        if ($request->isMethod("post")) {
            $User->name     = $request->input('name');
            $User->email    = $request->input('email');
            $User->password = Hash::make($request->input('password'));

            if ($User->save()) {
                return App::success();
            }
                return App::error('添加失败');
        }

            $url    = $request->input('url');
            $render = view('admin.author.add',['url'=>$url])->render();
            return App::success($render);
    }

    public function edit(Request $request)
    {
        $id = $request->id;
        $user = User::find($id);

        $role = Role::where("state", 1)->get();

        $user_role = RoleUser::where("user_id", $id)->first();
        $user_role_id = $user_role ? $user_role->role_id : "";

        if ($request->isMethod("post")) {
            try {
                $password    = $request->password;
                $role_id     = $request->role_id;
                $user->name  = $request->name;
                $user->email = $request->email;

                if(!Hash::check($password, $user->password)){
                    $user->password = Hash::make($password);
                }

                //修改用户组
                if ($user_role) {
                    $result = RoleUser::where("user_id", $id)->update(["role_id" => $role_id]);
                } else {
                    $result = RoleUser::insert(["user_id" => $id, "role_id" => $role_id]);
                }

                if ($result === false) {
                    throw new Exception('用户组修改失败');
                }

                if (!$user->save()) {
                    throw new Exception('用户信息修改失败');
                }

                return App::success();
            } catch (Exception $exception) {
                return App::error($exception->getMessage());
            }
        }

        $render = view('admin.author.permission.useredit_new', compact("user", "role", "user_role_id"))->render();
        return App::success($render);
    }

    public function getUserByEmail(Request $request){
        $data = $request->input('data');
        $column = $request->input('verify');
        $user_id = $request->input('user_id');

        $userData = User::instance()
            ->where($column,$data)
            ->where('id','!=',$user_id)
            ->first();

        if(!empty($userData)){
            return response()->json('false');
        }else{
            return response()->json('true');
        }
    }
}