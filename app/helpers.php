<?php

// 针对不同路由返回class名，样式
function route_class()
{
    return str_replace('.', '-', Route::currentRouteName());
}
