<?php

/*
|--------------------------------------------------------------------------
| 拓展配置文件
|--------------------------------------------------------------------------
|
*/

return array(

    /**
     * 网站信息配置
     */
    'webSiteName' => 'Demo',  //  网站名称

    /**
     * 网站静态资源文件别名配置
     */
    'webAssets' => array(

        'cssAliases' => array(  //  样式文件别名配置

            'bootstrap-2.3.2'            => 'assets/bootstrap-2.3.2/css/bootstrap.min.css',
            'bootstrap-2.3.2-responsive' => 'assets/bootstrap-2.3.2/css/bootstrap-responsive.min.css',
            'bootstrap-3.0.3'            => 'assets/bootstrap-3.0.3/css/bootstrap.min.css',

        ),

        'jsAliases'  => array(  //  脚本文件别名配置

            'jquery-1.10.2'         => 'assets/js/jquery-1.10.2.min.js',
            'google::jquery-1.10.2' => 'http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js',
            'bootstrap-2.3.2'       => 'assets/bootstrap-2.3.2/js/bootstrap.min.js',
            'bootstrap-3.0.3'       => 'assets/bootstrap-3.0.3/js/bootstrap.min.js',

        ),

    ),


);