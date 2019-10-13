<?php
/**
 * Created by PhpStorm.
 * User: 86136
 * Date: 2019/10/13
 * Time: 15:56
 */

namespace app\api\controller;
use think\Controller;
use think\Db;
use think\facade\Request;

class User extends Controller
{
    public function userInfo()
    {
        $token = Request::post('token');
        $find = Db::table('user')->where(['token'=>$token])->find();
        if($find){
            return _success('',$find);
        }else{
            return _fail('token错误！');
        }
    }

    public function upload(){
        // 获取表单上传文件 例如上传了001.jpg
        $file = request()->file('image');
        // 移动到框架应用根目录/uploads/ 目录下
        $info = $file->move( './uploads');
        if($info){
            // 成功上传后 获取上传信息
            $url = str_replace("\\",'/',$info->getSaveName());
            $data = Request::post();
            $data['ewm'] = '/uploads/'.$url;
            Db::table('user')->where(['token'=>$data['token']])->update($data);
            echo $data['ewm'];
        }else{
            // 上传失败获取错误信息
            echo $file->getError();
        }
    }
}