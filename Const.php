<?php

    // 假设企业号在公众平台上设置的参数如下

    define('SCHEME', 'http://');

    // define('URL_YOUDU_API', 'intr.youdu.im'); // 请填写有度服务器地址
    define('URL_YOUDU_API', '10.0.0.188:7080'); // 请填写有度服务器地址

    define('API_GET_TOKEN', SCHEME . URL_YOUDU_API . '/cgi/gettoken'); // 获取token api

    define('API_DEPT_CREATE', SCHEME . URL_YOUDU_API . '/cgi/dept/create'); // 创建部门

    define('API_DEPT_UPDATE', SCHEME . URL_YOUDU_API . '/cgi/dept/update'); // 修改部门

    define('API_DEPT_DELETE', SCHEME . URL_YOUDU_API . '/cgi/dept/delete'); // 删除部门

    define('API_DEPT_LIST', SCHEME . URL_YOUDU_API . '/cgi/dept/list'); // 获取指定部门及其下的直属子部门

    define('API_DEPT_ALIAS', SCHEME . URL_YOUDU_API . '/cgi/dept/getId'); // 获取部门ID

    define('API_USER_CREATE', SCHEME . URL_YOUDU_API . '/cgi/user/create'); // 创建用户

    define('API_USER_UPDATE', SCHEME . URL_YOUDU_API . '/cgi/user/update'); // 修改用户

    define('API_USER_POSISTIONUPDATE', SCHEME . URL_YOUDU_API . '/cgi/user/positionupdate'); //  更新用户部门信息

    define('API_USER_DELETE', SCHEME . URL_YOUDU_API . '/cgi/user/delete'); //  删除用户

    define('API_USER_BATCH_DELETE', SCHEME . URL_YOUDU_API . '/cgi/user/batchdelete'); //  批量删除用户

    define('API_USER_GET', SCHEME . URL_YOUDU_API . '/cgi/user/get'); // 获取用户信息

    define('API_USER_SIMPLELIST', SCHEME . URL_YOUDU_API . '/cgi/user/simplelist'); // 获取部门用户

    define('API_USER_LIST', SCHEME . URL_YOUDU_API . '/cgi/user/list'); // 获取部门用户详细信息
    
    define('API_USER_SETAUTH', SCHEME . URL_YOUDU_API . '/cgi/user/setauth'); // 设置认证信息


    define('BUIN', 56565656);  //请填写企业总机号

    define('AESKEY', 'jLLs7czdB+5+qiksza3Iu9YlqhQ3W44bQ/awO2uLgtw='); // 请填写企业应用回调用的AESKey
    define('APPID', 'sysOrgAssistant'); // 请填写企业应用AppId

    
?>