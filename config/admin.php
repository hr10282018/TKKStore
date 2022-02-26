<?php

return [

   
    // 登录页面的大标题，显示在登录页面
    'name' => 'TKKStore~admin',


    // 管理页面的logo设置，如果要设置为图片，可以设置为img标签
    'logo' => '<b>TKKStore</b> admin',

    

    // 当左侧边栏收起时显示的小logo，也可以设置为html标签
    'logo-mini' => '<b>TKK</b>',


    // 用来设置启动文件
    'bootstrap' => app_path('Admin/bootstrap.php'),

   

    // 后台路由配置，应用在`app/Admin/routes.php`里面
    'route' => [
        // 路由前缀
        'prefix' => env('ADMIN_ROUTE_PREFIX', 'admin'),
        // 控制器命名空间前缀
        'namespace' => 'App\\Admin\\Controllers',
        // 默认中间件列表
        'middleware' => ['web', 'admin'],
    ],

    
    // 后台的安装目录，如果在运行`admin:install`之前修改它，那么后台目录将会是这个配置的目录
    'directory' => app_path('Admin'),

  
    // 所有页面的<title>标签内容
    'title' => 'TKKStore 管理后台',

    
    // 后台是否使用https
    'https' => env('ADMIN_HTTPS', false),

    
    // 后台用户使用的用户认证配置
    'auth' => [

        'controller' => App\Admin\Controllers\AuthController::class,

        'guard' => 'admin',

        'guards' => [
            'admin' => [
                'driver'   => 'session',
                'provider' => 'admin',
            ],
        ],

        'providers' => [
            'admin' => [
                'driver' => 'eloquent',
                'model'  => Encore\Admin\Auth\Database\Administrator::class,
            ],
        ],

        
        // 是否展示 保持登录 选项
        'remember' => true,

        
        // 当用户未被授权时重定向到指定的 URI（登录页面）
        'redirect_to' => 'auth/login',


        
        // 无需用户认证即可访问的地址
        'excepts' => [
            'auth/login',
            'auth/logout',
            '_handle_action_',
        ],
    ],

    // 在Form表单中的image和file类型的默认上传磁盘和目录设置，其中disk的配置会使用在
    // config/filesystem.php里面配置的一项disk
    'upload' => [

        // 对应 filesystem.php 中的 disks
        'disk' => 'admin',

        // image和file类型表单元素的上传目录
        'directory' => [
            'image' => 'images',
            'file'  => 'files',
        ],
    ],


   // 数据库设置
    'database' => [

        // 数据库连接名称，留空即可
        'connection' => '',

        
        // 管理员用户表及模型
        'users_table' => 'admin_users',
        'users_model' => Encore\Admin\Auth\Database\Administrator::class,

         // 角色表及模型
        'roles_table' => 'admin_roles',
        'roles_model' => Encore\Admin\Auth\Database\Role::class,

        // 权限表及模型
        'permissions_table' => 'admin_permissions',
        'permissions_model' => Encore\Admin\Auth\Database\Permission::class,

        // 菜单表及模型
        'menu_table' => 'admin_menu',
        'menu_model' => Encore\Admin\Auth\Database\Menu::class,

        // Pivot table for table above.
        // 多对多关联中间表
        'operation_log_table'    => 'admin_operation_log',
        'user_permissions_table' => 'admin_user_permissions',
        'role_users_table'       => 'admin_role_users',
        'role_permissions_table' => 'admin_role_permissions',
        'role_menu_table'        => 'admin_role_menu',
    ],

   

    //  操作日志记录的配置
    'operation_log' => [

        // 是否开启日志记录，默认打开
        'enable' => true,
    
        // 允许记录请求日志的HTTP方法 
        'allowed_methods' => ['GET', 'HEAD', 'POST', 'PUT', 'DELETE', 'CONNECT', 'OPTIONS', 'TRACE', 'PATCH'],

        // 不记操作日志的路由
        'except' => [
            'admin/auth/logs*',
        ],
    ],

    // 路由是否检查权限
    'check_route_permission' => true,

    // 菜单是否检查权限
    'check_menu_roles'       => true,

    // 管理员默认头像
    'default_avatar' => '/vendor/laravel-admin/AdminLTE/dist/img/user2-160x160.jpg',

    // 地图组件提供商
    'map_provider' => 'google',

    // 页面风格  @see https://adminlte.io/docs/2.4/layout
    'skin' => 'skin-blue-light',

    /*
    |--------------------------------------------------------------------------
    | Application layout
    |--------------------------------------------------------------------------
    |
    | This value is the layout of admin pages.
    | @see https://adminlte.io/docs/2.4/layout
    |
    | Supported: "fixed", "layout-boxed", "layout-top-nav", "sidebar-collapse",
    | "sidebar-mini".
    |
    */
    // 后台布局
    'layout' => ['sidebar-mini', 'sidebar-collapse'],

    
    // 登录页背景图
    'login_background_image' => '',

    
    // 是否显示版本
    'show_version' => true,

  
    // 是否显示环境
    'show_environment' => true,

    
    // 菜单是否绑定权限
    'menu_bind_permission' => true,

   
    // 默认启用面包屑
    'enable_default_breadcrumb' => true,

    /*
    |--------------------------------------------------------------------------
    | Enable/Disable assets minify
    |--------------------------------------------------------------------------
    */
    // 是否开启静态资源文件的压缩
    'minify_assets' => [

        // 不需要被压缩的资源
        'excepts' => [

        ],

    ],

   
    // 是否启用菜单搜索
    'enable_menu_search' => true,

    
    // 顶部警告信息
    'top_alert' => '',

    /*
    |--------------------------------------------------------------------------
    | The global Grid action display class.
    |--------------------------------------------------------------------------
    */
    // 表格操作展示样式
    'grid_action_class' => \Encore\Admin\Grid\Displayers\DropdownActions::class,

    

    // 如果你要运行`php artisan admin:extend`命令来开发扩展，需要配置这一项。表示扩展所在的目录
    'extension_dir' => app_path('Admin/Extensions'),

    // 扩展设置
    'extensions' => [

    ],
];
