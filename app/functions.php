<?php

/*
|--------------------------------------------------------------------------
| 覆盖&补充 Laravel 助手函数库
|--------------------------------------------------------------------------
|
| 原文件路径
| Illuminate/Support/helpers.php
|
*/

/**
 * 无断点调试，结合 barryvdh/laravel-debugbar
 * @return void
 */
function d()
{
    array_map(function($x) { Debugbar::info($x); }, func_get_args());
}
// 如果必须要在非视图响应中使用
function d_()
{
    echo '<span></span>';
    array_map(function($x) { Debugbar::info($x); }, func_get_args());
}





/*
|--------------------------------------------------------------------------
| 自定义核心函数库
|--------------------------------------------------------------------------
|
*/

/**
 * 拓展分页输出，支持临时指定分页模板
 * @param  Illuminate\Pagination\Paginator  $paginator  分页查询结果的最终实例
 * @param  string                           $viewName   分页视图名称
 * @return \Illuminate\View\View
 */
function pagination(Illuminate\Pagination\Paginator $paginator, $viewName=null)
{
    $viewName = $viewName ?: Config::get('view.pagination');
    $paginator->getEnvironment()->setViewName($viewName);
    return $paginator->links();
}

/**
 * 保持原格式的参数文件修改（原参数值将会在下一行以注释的形式备份）
 * @param  string  $configName  需要修改的参数
 * @param  string  $newConfig   新的参数值
 * @param  string  $comment     当存在同名参数时用以区分的注释字符串
 * @return 成功时返回写入到文件内数据的字节数，失败时返回FALSE
 */
function change_config($configName, $newConfig, $comment='')
{
    $oldConfig      = Config::get($configName);
    $pathArr        = explode('.', $configName);
    $configFilePath = app_path('config/'.$pathArr[0].'.php');
    $oldContent     = File::get($configFilePath);
    
    $befor      = "/([^\n]+)'{$pathArr[count($pathArr)-1]}' => '{$oldConfig}'(.*{$comment}|[^\n])/";
    $after      = "\\1'{$pathArr[count($pathArr)-1]}' => '{$newConfig}'\\2#'{$oldConfig}'";
    $newContent = preg_replace($befor, $after, $oldContent, 1);

    return File::put($configFilePath, $newContent);
}

/**
 * 样式别名加载（支持批量加载）
 * @param  string|array $aliases    配置文件中的别名
 * @param  array        $attributes 标签中需要加入的其它参数的数组
 * @return string
 */
function style($aliases, $attributes=array(), $interim='')
{
    if (is_array($aliases))
    {
        foreach ($aliases as $k => $v)
        {
            $interim .= (is_int($k)) ? style($v, $attributes, $interim) : style($k, $v, $interim);
        }
        return $interim;
    }
    $cssAliases = Config::get('extend.webAssets.cssAliases');
    $url = isset($cssAliases[$aliases]) ? $cssAliases[$aliases] : $aliases;
    return HTML::style($url, $attributes);
}

/**
 * 脚本别名加载（支持批量加载）
 * @param  string|array $aliases    配置文件中的别名
 * @param  array        $attributes 标签中需要加入的其它参数的数组
 * @return string
 */
function script($aliases, $attributes=array(), $interim='')
{
    if (is_array($aliases))
    {
        foreach ($aliases as $k => $v)
        {
            $interim .= (is_int($k)) ? script($v, $attributes, $interim) : script($k, $v, $interim);
        }
        return $interim;
    }
    $jsAliases = Config::get('extend.webAssets.jsAliases');
    $url = isset($jsAliases[$aliases]) ? $jsAliases[$aliases] : $aliases;
    return HTML::script($url, $attributes);
}

/**
 * 脚本别名加载（补充）用于 js 的 document.write(）中
 * @param  string $aliases    配置文件中的别名
 * @param  array  $attributes 标签中需要加入的其它参数的数组
 * @return string
 */
function or_script($aliases, $attributes=array())
{
    $jsAliases = Config::get('extend.webAssets.jsAliases');
    $url = isset($jsAliases[$aliases]) ? $jsAliases[$aliases] : $aliases;
    $attributes['src'] = URL::asset($url);
    return "'<script".HTML::attributes($attributes).">'+'<'+'/script>'";
}

/**
 * 友好的日期输出
 * @param  string $theDate 待处理的时间字符串
 * @return string          友好的时间字符串
 */
function friendly_date($theDate)
{
    // 获取待处理的日期对象
    $theDate = \Carbon\Carbon::createFromTimestamp(strtotime($theDate));
    // 取得英文日期描述
    $friendlyDateString = $theDate->diffForHumans(\Carbon\Carbon::now());
    // 本地化
    $friendlyDateArray  = explode(' ', $friendlyDateString);
    $friendlyDateString = $friendlyDateArray[0]
        .Lang::get('friendlyDate.'.$friendlyDateArray[1])
        .Lang::get('friendlyDate.'.$friendlyDateArray[2]);
    // 数据返回
    return $friendlyDateString;
}




/*
|--------------------------------------------------------------------------
| 公共函数库
|--------------------------------------------------------------------------
|
*/
