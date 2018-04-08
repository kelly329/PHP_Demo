<?php
/**
 * Created by PhpStorm.
 * User: NaDou329
 * Date: 2018/4/8
 * Time: 10:34
 */
$productid =intval($_GET['productid']);
$userid = 1;

try{
    $pdo = new PDO("mysql:host=localhost:3306;dbname=shooping","root","123456", array(PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION));
    $pdo->query("set names utf8");
    $sql = "delete from shop_chart where productid=? and userid=?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(array($productid, $userid));
    $rows = $stmt->rowCount();
}catch (PDOException $e){
    echo $e->getMessage();
}
if($rows){
    $response = array(
        'errno'     =>  0,
        'errmsg'   => 'success',
        'data'       => true
    );
}else{
    $response = array(
        'errno'     =>  -1,
        'errmsg'   => 'fail',
        'data'       => false
    );
}
echo json_encode($response);
//echo json_encode($response);