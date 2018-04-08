<?php
/**
 * Created by PhpStorm.
 * User: NaDou329
 * Date: 2018/4/8
 * Time: 11:14
 */
//将该用户所有的购物车数据删除
session_start();

$userid = 1;
//$userid = $_SESSION['memberid'];
try{
    $pdo = new PDO("mysql:host=localhost:3306;dbname=shooping","root","123456",
        array(PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION));
    $pdo->query("set names utf8");
    $sql = "delete from shop_chart where userid=?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(array($userid));
    $rows = $stmt->rowCount();
}catch (PDOException $e){
    echo $e->getMessage();
}
//4.返回结果
if($rows){
    $response = array(
        'errno'         => 0,
        'errmsg'      => 'success',
        'data'          => true,
    );
}else{
    $response = array(
        'errno'         => -1,
        'errmsg'      => 'fail',
        'data'          => false,
    );
}

echo json_encode($response);