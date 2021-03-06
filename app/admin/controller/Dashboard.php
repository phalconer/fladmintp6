<?php
/**
 * *
 *  * ============================================================================
 *  * Created by PhpStorm.
 *  * User: Jack
 *  * 邮箱: 1276789849@qq.com
 *  * 网址: https://fladmin.cn
 *  * Date: 2022/6/19 下午3:33
 *  * ============================================================================.
 */

namespace app\admin\controller;

use app\admin\model\Admin;
use app\admin\model\User;
use app\common\model\Attachment;
use fast\Date;
use think\facade\Config;
use app\common\controller\Backend;
use think\facade\Db;

/**
 * 控制台.
 *
 * @icon fa fa-dashboard
 * @remark 用于展示当前系统中的统计数据、统计报表及重要实时数据
 */
class Dashboard extends Backend
{
    /**
     * 查看
     */
    public function index()
    {
        try {
            Db::execute("SET @@sql_mode='';");
        } catch (\Exception $e) {

        }
        $column = [];
        $starttime = Date::unixtime('day', -6);
        $endtime = Date::unixtime('day', 0, 'end');
        $joinlist = Db::name("user")->where('join_time', 'between time', [$starttime, $endtime])
            ->field('join_time, status, COUNT(*) AS nums, DATE_FORMAT(FROM_UNIXTIME(join_time), "%Y-%m-%d") AS join_date')
            ->group('join_date')
            ->select();
        for ($time = $starttime; $time <= $endtime;) {
            $column[] = date("Y-m-d", $time);
            $time += 86400;
        }
        $userlist = array_fill_keys($column, 0);
        foreach ($joinlist as $k => $v) {
            $userlist[$v['join_date']] = $v['nums'];
        }

        $dbTableList = Db::query("SHOW TABLE STATUS");
        $this->view->assign([
            'totaluser'       => User::count(),
            'totaladdon'      => count(get_addon_list()),
            'totaladmin'      => Admin::count(),
            'totalcategory'   => \app\common\model\Category::count(),
            'todayusersignup' => User::whereTime('join_time', 'today')->count(),
            'todayuserlogin'  => User::whereTime('login_time', 'today')->count(),
            'sevendau'        => User::whereTime('join_time|login_time|prev_time', '-7 days')->count(),
            'thirtydau'       => User::whereTime('join_time|login_time|prev_time', '-30 days')->count(),
            'threednu'        => User::whereTime('join_time', '-3 days')->count(),
            'sevendnu'        => User::whereTime('join_time', '-7 days')->count(),
            'dbtablenums'     => count($dbTableList),
            'dbsize'          => array_sum(array_map(function ($item) {
                return $item['Data_length'] + $item['Index_length'];
            }, $dbTableList)),
            'attachmentnums'  => Attachment::count(),
            'attachmentsize'  => Attachment::sum('filesize'),
            'picturenums'     => Attachment::where('mime_type', 'like', 'image/%')->count(),
            'picturesize'     => Attachment::where('mime_type', 'like', 'image/%')->sum('filesize'),
        ]);

        $this->assignconfig('column', array_keys($userlist));
        $this->assignconfig('userdata', array_values($userlist));

        return $this->view->fetch();
    }
}
