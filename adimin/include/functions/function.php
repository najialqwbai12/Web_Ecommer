<?php

  //Function Is Home
  function getAllFroms($filed,$table,$where=NULL,$and=Null,$orderfiled,$ordering="DESC")
          {
            global $conn;
  
              $getAll=$conn->prepare("SELECT $filed from $table $where $and ORDER BY $orderfiled $ordering");
              $getAll->execute();
              $all=$getAll->fetchAll();
              return $all;
          }

            //function Titel Page
  function getTitle(){
    global $pageTitle;
    if(isset($pageTitle)){
        echo $pageTitle;
    }else {
        echo "Default";
    }
  }

//Rediract Function
  
  function Rediract($theMsg,$url=null,$seconds=5){
    if($url===null){
      $url="index.php";
    }else{
      $url=isset($_SERVER['HTTP_REFERER']) && $_SERVER['HTTP_REFERER'] !==''?$_SERVER['HTTP_REFERER'] :'index.php' ;
    }
    echo $theMsg;
    //echo "<div class='alert alert-danger'>$theMsg</div>";
     echo "<div class='alert alert-info'>Yoe Will Be Rediract To  After $seconds Seconds</div>";
     header("refresh:$seconds;url=$url");
     exit();
  }


  // Check Item Database
  function checkItem($select,$from,$value){
      global $conn;
      $stmt=$conn->prepare("SELECT $select FROM $from WHERE $select=?");
      $stmt->execute(array($value));
      $count=$stmt->rowCount();

      return $count;

  }

  // Counet Number from Database
  function counetItem($item,$table){
    global $conn;
       $stmt=$conn->prepare("SELECT COUNT($item)FROM $table");
      $stmt->execute();

      return $stmt->fetchColumn();
  }

  //lasta function

  function getLatest($select,$table,$order,$limit){
    global $conn;
    $getStmt=$conn->prepare("SELECT $select from $table ORDER BY $order DESC LIMIT $limit");
    $getStmt->execute();
    $rows=$getStmt->fetchAll();
    return $rows;
  }