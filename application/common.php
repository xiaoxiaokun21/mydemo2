<?php

// 管理员模块用到的状态css
function status($status){
    if($status == 1){
        $str="<span class='label label-success radius'>正常</span>";
    }
    return $str;
}
/**
 * 通用的分页样式
 */
function pagination($obj){
    if(!$obj){
        return '';
    }
    return "<div class='cl pd-5 bg-1 bk-gray mt-20 tp5-o2o'>".$obj->render()."</div>";
}
