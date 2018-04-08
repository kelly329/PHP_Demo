<?php
session_start();
/**
 * 完成数据表的操作
 */
//1.接收参数//2.处理参数
$productid = intval($_POST['productid']);
$num = intval($_POST['num']);
$userid = 1;
//$userid = $_SESSION['memberid'];
//3.完成更新操作
try{
    $pdo = new PDO("mysql:host=localhost:3306;dbname=shooping","root","123456",
        array(PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION));
    $pdo->query("set names utf8");
    $sql = "update shop_chart set num=? where userid=? and productid=? ";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(array($num,$userid,$productid));
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