<?php
    /**
     * 描述：加入购物车操作
     * 1.接收传递过来的post参数
     * 2.准备要添加到购物车数据
     * 3.完成购物车数据的添加操作
     * 4.返回最终添加的结果
     */
    //strip_tags()剥去字符串中的html
//    $productid = strip_tags($_POST['productid']);
//    $num = strip_tags($_POST['num']);
    //通过使用特定的进制转换（默认是十进制），返回变量 var 的 integer 数值
    //1.接收传递过来的post参数
    $productid = intval($_POST['productid']);
    $num = intval($_POST['num']);
    //2.准备要添加到购物车数据
//    session_start();
//    $userid = $_SESSION['memberid'];
    $userid = 1;
    try{
        $pdo = new PDO("mysql:host=localhost:3306;dbname=shooping","root","123456",array(PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION));
        $pdo->query("set names utf8");
        $sql = "select price from shop_product where id=?";
        //预处理对象
        $stmt = $pdo->prepare($sql);
        //绑定参数
        $stmt->execute(array($productid));
        //PDOStatement::fetch — 从结果集中获取下一行
        $data = $stmt->fetch(PDO::FETCH_ASSOC);
        $price = $data['price'];
        // var_dump($data); 在response 或者prieview 查看
        $createtime = time();
        //3.完成购物车数据的添加操作（判断当前用户在购物车中的是否已经加入该商品）
        //优化部分
        $sql = "select * from shop_chart where userid=? and productid=?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute(array($userid,$productid));
        $data = $stmt->fetch(PDO::FETCH_ASSOC);
        if($data){
            $sql = "update shop_chart set num = num + ? where userid = ? and productid = ?";
            $params = array($num,$userid,$productid);
        }else{
            $sql = "insert into shop_chart(productid,num,userid,price,createtime) values(?,?,?,?,?)";
            $params = array($productid,$num,$userid,$price,$createtime);
        }

        $stmt = $pdo->prepare($sql);
        $stmt->execute($params);
        //获取最后的主键id
        $rows = $stmt->rowCount();
    }catch (PDOException $e){
        echo $e->getMessage();
    }
    //4.返回最终添加的结果
    if($rows){
        $response = array(
            'errno'=>0,
            'errmsg'=>'添加成功',
            'data'=>true,
        );
    }else{
        $response = array(
            'errno'=> -1,
            'errmsg'=>'添加失败',
            'data'=>false,
        );
    }
    echo json_encode($response);


