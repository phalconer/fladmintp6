<?php
/**
 * *
 *  * ============================================================================
 *  * Created by PhpStorm.
 *  * User: Jack
 *  * 邮箱: 1276789849@qq.com
 *  * 网址: https://fladmin.cn
 *  * Date: 2022/6/20 下午5:19
 *  * ============================================================================.
 */

declare(strict_types=1);

namespace app\common\service;

use think\Service;
use think\facade\Env;
use think\helper\Str;
use think\facade\Cache;
use think\facade\Event;
use think\facade\Route;
use think\facade\Config;
use app\common\middleware\Addon;
use app\common\middleware\FastInit;

/**
 * 服务服务
 */
class AddonService extends Service
{
    public function register()
    {
        // 服务目录
        ! defined('ADDON_PATH') && define('ADDON_PATH', app()->getRootPath().'addons'.DIRECTORY_SEPARATOR);
        ! defined('DS') && define('DS', DIRECTORY_SEPARATOR);
        // 如果服务目录不存在则创建
        if (! is_dir(ADDON_PATH)) {
            @mkdir(ADDON_PATH, 0755, true);
        }
        //注册服务路由
        $this->addon_route();
        //注册服务事件
        $this->addon_event();
    }

    /**
     * 注册服务事件.
     */
    private function addon_event()
    {
        $hooks = Env::get('APP_DEBUG') ? [] : Cache::get('hooks', []);
        if (empty($hooks)) {
            $hooks = (array) Config::get('addons.hooks');
            // 初始化钩子
            foreach ($hooks as $key => $values) {
                if (is_string($values)) {
                    $values = explode(',', $values);
                } else {
                    $values = (array) $values;
                }
                $hooks[$key] = array_filter(array_map(function ($v) use ($key) {
                    return [get_addon_class($v), Str::camel($key)];
                }, $values));
            }
            Cache::set('hooks', $hooks);
        }
        //如果在服务中有定义app_init，则直接执行
        Event::listenEvents($hooks);
        if (isset($hooks['app_init'])) {
            foreach ($hooks['app_init'] as $k => $v) {
                Event::trigger('app_init', $v);
            }
        }
    }

    /**
     * 注册服务路由.
     */
    private function addon_route()
    {
        Route::rule('addons/:addon/[:controller]/[:action]', '\\think\\addons\\Route::execute')
            ->middleware([FastInit::class,Addon::class]);

        //注册路由
        $routeArr = (array) Config::get('addons.route');
        $execute = '\\think\\addons\\Route::execute';
        foreach ($routeArr as $k => $v) {
            if (is_array($v)) {
                $domain = $v['domain'];
                $drules = [];
                foreach ($v['rule'] as $m => $n) {
                    [$addon, $controller, $action] = explode('/', $n);
                    $drules[$m] = [
                        'addon'    => $addon, 'controller' => $controller, 'action' => $action,
                        'indomain' => 1,
                    ];
                }
                Route::domain($domain, function () use ($drules, $execute) {
                    // 动态注册域名的路由规则
                    foreach ($drules as $k => $rule) {
                        Route::rule($k, $execute)
                            ->middleware([FastInit::class,Addon::class])
                            ->name($k)
                            ->completeMatch(true)
                            ->append($rule);
                    }
                });
            } else {
                if (! $v) {
                    continue;
                }
                [$addon, $controller, $action] = explode('/', $v);
                Route::rule($k, $execute)
                    ->middleware([FastInit::class,Addon::class])
                    ->name($k)
                    ->completeMatch(true)
                    ->append(['addon' => $addon, 'controller' => $controller, 'action' => $action]);
            }
        }
    }
}
