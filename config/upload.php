<?php
/**
 * *
 *  * ============================================================================
 *  * Created by PhpStorm.
 *  * User: Jack
 *  * 邮箱: 1276789849@qq.com
 *  * 网址: https://fladmin.cn
 *  * Date: 2022/6/19 下午3:38
 *  * ============================================================================.
 */

//上传配置
return [
    /**
     * 引擎
     */
    'driver'=>'local',
    /**
     * 上传地址,默认是本地上传
     */
    'uploadurl' => 'ajax/upload',
    /**
     * CDN地址
     */
    'cdnurl'    => '',
    /**
     * 文件保存格式
     */
    'uploaddir' => 'uploads',
    /**
     * 最大可上传大小
     */
    'maxsize'   => '10mb',
    /**
     * 可上传的文件类型
     */
    'mime_type'  => 'jpg,png,bmp,jpeg,gif,zip,rar,xls,xlsx,wav,mp4,mp3,pdf',
    /**
     * 是否支持批量上传
     */
    'multiple'  => false,

    /**
     * 文件保存格式
     */
    'savekey'   => '/uploads/{year}{mon}{day}/{filemd5}{.suffix}',

    /**
     * 是否支持分片上传
     */
    'chunking'  => false,
    /**
     * 默认分片大小
     */
    'chunksize' => 2097152,
];
