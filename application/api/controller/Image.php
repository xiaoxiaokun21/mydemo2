<?php
namespace app\api\controller;
use think\Controller;
use think\Request;
use think\File;
use think\Image;
class Image extends Controller
{
    /**
     * 用户头像
     * @return type
     */
    public function upload(){
        $file=Request::instance()->file('file');
        //给定一个目录
        $info=$file->move('upload');
        $name=$info->getPathname();
        //获取图片
        $image = Image::open($file);
        //等比例压缩图片
        $image->thumb(100,100)->save('./'.$name);
        if($info && $name) {
            return show(1, 'success','/mydemo/public/'.$name);
        }
        return show(0,'upload error');
    } 
}