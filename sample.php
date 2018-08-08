<?php

include_once "YdApi.php";
include_once "Const.php";
$ydapi = new YdApi(AESKEY, APPID, BUIN);
/*
    获取token
*/
list($errcode, $encrypt) = $ydapi->EncryptMsg(time());
if ($errcode === 0) {
    list($errcode, $rsp) = $ydapi->GetToken(API_GET_TOKEN, $encrypt);
    if ($errcode === 0) {
        echo "获取 token: $rsp 成功<br>";
    } else {
        echo "获取 token 失败 errcode : $errcode , errmsg : $rsp <br/>";
        exit();
    }
}


/*
    创建部门
*/
$msg = ["id" => 101, "name" => "新增测试", "parentId" => 0, "sortId" => 1001, "alias" => "test_add"];
$rsp = $ydapi->Submit(API_DEPT_CREATE, $msg);
if ($rsp["errcode"] === 0) {
    echo "创建部门成功 部门ID ". $rsp["decrypt"]["id"] ."<br/>";
} else {
    echo "创建部门失败 errcode: ". $rsp["errcode"] .", errmsg: ". $rsp["errmsg"] ."<br/>";
    exit();
}

$msg = ["id" => 102, "name" => "新增测试", "parentId" => 101, "sortId" => 1002, "alias" => "test_add1"];
$rsp = $ydapi->Submit(API_DEPT_CREATE, $msg);
if ($rsp["errcode"] === 0) {
    echo "创建部门成功 部门ID ". $rsp["decrypt"]["id"] ."<br/>";
} else {
    echo "创建部门失败 errcode: ". $rsp["errcode"] .", errmsg: ". $rsp["errmsg"] ."<br/>";
    exit();
}

$msg = ["id" => 103, "name" => "新增测试", "parentId" => 101, "sortId" => 1003, "alias" => "test_add2"];
$rsp = $ydapi->Submit(API_DEPT_CREATE, $msg);
if ($rsp["errcode"] === 0) {
    echo "创建部门成功 部门ID ". $rsp["decrypt"]["id"] ."<br/>";
} else {
    echo "创建部门失败 errcode: ". $rsp["errcode"] .", errmsg: ". $rsp["errmsg"] ."<br/>";
    exit();
}

/*
    修改部门
*/
$msg = ["id" => 101, "name" => "修改测试", "parentId" => 0, "sortId" => 1004, "alias" => "test_add3"];
$rsp = $ydapi->Submit(API_DEPT_UPDATE, $msg);
if ($rsp["errcode"] === 0) {
    echo "修改部门成功<br/>";
} else {
    echo "修改部门失败 errcode: ". $rsp["errcode"] .", errmsg: ". $rsp["errmsg"] ."<br/>";
    exit();
}
/*
    根据别名获取单个部门ID
*/
$msg = ["id" => "test_add3"];
$rsp = $ydapi->Submit(API_DEPT_ALIAS, $msg, "get");
if ($rsp["errcode"] === 0) {
    echo "获取单个部门ID成功 部门ID ". $rsp["decrypt"]["id"] ."<br/>";
} else {
    echo "获取单个部门ID失败 errcode: ". $rsp["errcode"] .", errmsg: ". $rsp["errmsg"] ."<br/>";
    exit();
}
/*
    获取所有有别名的部门的ID
*/
$msg = [];
$rsp = $ydapi->Submit(API_DEPT_ALIAS, $msg, "get");
if ($rsp["errcode"] === 0) {
    echo "获取所有有别名的部门的ID成功<br/>";
    var_dump($rsp["decrypt"]);
    echo "<br>";
} else {
    echo "获取所有有别名的部门的ID失败 errcode: ". $rsp["errcode"] .", errmsg: ". $rsp["errmsg"] ."<br/>";
    exit();
}

/*
    创建用户
*/
$msg = ["userId" => "700265", "name" => "test.kan", "gender" => 1, "mobile" => "13849898885", "phone" => "0756-8888999", "email" => "sample@test.com", "dept" => [69]];
$rsp = $ydapi->Submit(API_USER_CREATE, $msg);
if ($rsp["errcode"] === 0) {
    echo "创建用户成功<br/>";
} else {
    echo "创建用户失败 errcode: ". $rsp["errcode"] .", errmsg: ". $rsp["errmsg"] ."<br/>";
    exit();
}

/*
    修改用户
*/
$msg = ["userId" => "700265", "name" => "test.sun", "gender" => 0, "mobile" => "13889898985", "phone" => "0756-8888999", "email" => "sample@test.com", "dept" => [101]];
$rsp = $ydapi->Submit(API_USER_UPDATE, $msg);
if ($rsp["errcode"] === 0) {
    echo "修改用户成功<br/>";
} else {
    echo "修改用户失败 errcode: ". $rsp["errcode"] .", errmsg: ". $rsp["errmsg"] ."<br/>";
    exit();
}

/*
    创建用户
*/
$msg = ["userId" => "700266", "name" => "test.aaa", "gender" => 1, "mobile" => "13849898885", "phone" => "0756-8888999", "email" => "sample@test.com", "dept" => [101]];
$rsp = $ydapi->Submit(API_USER_CREATE, $msg);
if ($rsp["errcode"] === 0) {
    echo "创建用户: ".$msg["userId"]." 成功<br/>";
} else {
    echo "创建用户失败 errcode: ". $rsp["errcode"] .", errmsg: ". $rsp["errmsg"] ."<br/>";
    exit();
}

/*
    创建用户
*/
$msg = ["userId" => "700267", "name" => "test.bbb", "gender" => 1, "mobile" => "13849898885", "phone" => "0756-8888999", "email" => "sample@test.com", "dept" => [101]];
$rsp = $ydapi->Submit(API_USER_CREATE, $msg);
if ($rsp["errcode"] === 0) {
    echo "创建用户: ".$msg["userId"]." 成功<br/>";
} else {
    echo "创建用户失败 errcode: ". $rsp["errcode"] .", errmsg: ". $rsp["errmsg"] ."<br/>";
    exit();
}

/*
    创建用户
*/
$msg = ["userId" => "700268", "name" => "test.ccc", "gender" => 1, "mobile" => "13849898885", "phone" => "0756-8888999", "email" => "sample@test.com", "dept" => [101]];
$rsp = $ydapi->Submit(API_USER_CREATE, $msg);
if ($rsp["errcode"] === 0) {
    echo "创建用户: ".$msg["userId"]." 成功<br/>";
} else {
    echo "创建用户失败 errcode: ". $rsp["errcode"] .", errmsg: ". $rsp["errmsg"] ."<br/>";
    exit();
}

/*
    更新用户部门信息
*/
$msg = ["userId" => "700268", "deptId" => 101, "position" => "Javascript", "weight" => 3, "sortId" => 1005];
$rsp = $ydapi->Submit(API_USER_POSISTIONUPDATE, $msg);
if ($rsp["errcode"] === 0) {
    echo "更新用户部门信息: ".$msg["userId"]." 成功<br/>";
} else {
    echo "更新用户部门信息失败 errcode: ". $rsp["errcode"] .", errmsg: ". $rsp["errmsg"] ."<br/>";
    exit();
}

/*
    设置认证信息
*/
$msg = ["userId" => "700268", "authType" => 1, "passwd" => md5("Javascript")];
$rsp = $ydapi->Submit(API_USER_SETAUTH, $msg);
if ($rsp["errcode"] === 0) {
    echo "设置认证信息信息: ".$msg["userId"]." 成功<br/>";
} else {
    echo "设置认证信息信息失败 errcode: ". $rsp["errcode"] .", errmsg: ". $rsp["errmsg"] ."<br/>";
    exit();
}

/*
    获取用户信息
*/
$msg = ["userId" => "700268"];
$rsp = $ydapi->Submit(API_USER_GET, $msg, "get");
if ($rsp["errcode"] === 0) {
    echo "获取用户信息成功: <br/>";
    var_dump($rsp["decrypt"]);
    echo "<br>";
} else {
    echo "获取用户信息失败 errcode: ". $rsp["errcode"] .", errmsg: ". $rsp["errmsg"] ."<br/>";
    exit();
}

/*
    获取部门用户
*/
$msg = ["deptId" => 101];
$rsp = $ydapi->Submit(API_USER_SIMPLELIST, $msg, "get");
if ($rsp["errcode"] === 0) {
    echo "获取部门用户成功deptId (".$msg["deptId"]."): <br/>";
    var_dump($rsp["decrypt"]);
    echo "<br>";
} else {
    echo "获取部门用户失败 errcode: ". $rsp["errcode"] .", errmsg: ". $rsp["errmsg"] ."<br/>";
    exit();
}

/*
    获取部门用户详细信息
*/
$msg = ["deptId" => 101];
$rsp = $ydapi->Submit(API_USER_LIST, $msg, "get");
if ($rsp["errcode"] === 0) {
    echo "获取部门用户详细信息成功deptId (".$msg["deptId"]."):<br/>";
    var_dump($rsp["decrypt"]);
    echo "<br>";
} else {
    echo "获取部门用户详细信息失败 errcode: ". $rsp["errcode"] .", errmsg: ". $rsp["errmsg"] ."<br/>";
    exit();
}

/*
    删除用户
*/
$msg = ["userId" => "700268"];
$rsp = $ydapi->Submit(API_USER_DELETE, $msg, "get");
if ($rsp["errcode"] === 0) {
    echo "删除用户: ".$msg["userId"]." 成功<br/>";
} else {
    echo "删除用户失败 errcode: ". $rsp["errcode"] .", errmsg: ". $rsp["errmsg"] ."<br/>";
    exit();
}

/*
    批量删除用户
*/
$msg = ["delList" => ["700265", "700266", "700267"] ];
$rsp = $ydapi->Submit(API_USER_BATCH_DELETE, $msg);
if ($rsp["errcode"] === 0) {
    echo "批量删除用户成功<br/>";
} else {
    echo "批量删除用户失败 errcode: ". $rsp["errcode"] .", errmsg: ". $rsp["errmsg"] ."<br/>";
    exit();
}

/*
    获取部门用户
*/
$msg = ["deptId" => 86];
$rsp = $ydapi->Submit(API_USER_SIMPLELIST, $msg, "get");
if ($rsp["errcode"] === 0) {
    echo "获取部门用户成功deptId (".$msg["deptId"]."): <br/>";
    var_dump($rsp["decrypt"]);
    echo "<br>";
} else {
    echo "获取部门用户失败 errcode: ". $rsp["errcode"] .", errmsg: ". $rsp["errmsg"] ."<br/>";
    exit();
}

/*
    删除部门
*/
$msg = ["id" => 103];
$rsp = $ydapi->Submit(API_DEPT_DELETE, $msg, "get");
if ($rsp["errcode"] === 0) {
    echo "删除部门: ".$msg["id"]." 成功<br/>";
} else {
    echo "删除部门失败 errcode: ". $rsp["errcode"] .", errmsg: ". $rsp["errmsg"] ."<br/>";
    exit();
}

/*
    删除部门
*/
$msg = ["id" => 102];
$rsp = $ydapi->Submit(API_DEPT_DELETE, $msg, "get");
if ($rsp["errcode"] === 0) {
    echo "删除部门: ".$msg["id"]." 成功<br/>";
} else {
    echo "删除部门失败 errcode: ". $rsp["errcode"] .", errmsg: ". $rsp["errmsg"] ."<br/>";
    exit();
}

/*
    删除部门
*/
$msg = ["id" => 101];
$rsp = $ydapi->Submit(API_DEPT_DELETE, $msg, "get");
if ($rsp["errcode"] === 0) {
    echo "删除部门: ".$msg["id"]." 成功<br/>";
} else {
    echo "删除部门失败 errcode: ". $rsp["errcode"] .", errmsg: ". $rsp["errmsg"] ."<br/>";
    exit();
}