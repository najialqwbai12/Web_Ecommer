<?php

          function getAllFroms($filed,$table,$where=NULL,$and=Null,$orderfiled,$ordering="DESC"){
            global $conn;
  
              $getAll=$conn->prepare("SELECT $filed from $table $where $and ORDER BY $orderfiled $ordering");
              $getAll->execute();
              $all=$getAll->fetchAll();
              return $all;
            }
     /* Function To Get All  From Database */
     

       function getAllFrom($tableName,$orderBy,$where=NULL){
    global $conn;
  
    $getAll=$conn->prepare("SELECT * from $tableName $where ORDER BY $orderBy DESC");
    $getAll->execute();
    $all=$getAll->fetchAll();
    return $all;
  }
    /* Function To Get Categores  From Database */
  //lasta function

  function getCats(){
    global $conn;
    $getCat=$conn->prepare("SELECT * from categories ORDER BY ID DESC");
    $getCat->execute();
    $cats=$getCat->fetchAll();
    return $cats;
  }
    /* Function To Get Item  From Database */


  function getItems($where,$value,$approve = NULL){
    global $conn;
    if ($approve == NULL) {
      $sql='AND Approve = 1';
    }else{
      $sql= NULL;
    }

    $getItems=$conn->prepare("SELECT * from items WHERE $where = ? $sql ORDER BY item_ID DESC");
    $getItems->execute(array($value));
    $items=$getItems->fetchAll();
    return $items;
  }

  ////
  function getTitle(){
    global $pageTitle;
    if(isset($pageTitle)){
        echo $pageTitle;
    }else {
        echo "Default";
    }
  }
  //check  User Not Actvate
    function checkUserStatus($user){
      global $conn;
       $stmt = $conn->prepare("SELECT 
                                UserName,`RegStatus`
                            FROM 
                                users 
                            WHERE
                                UserName = ? 
                            AND  `RegStatus`=0 
                        
                            ");

        $stmt->execute(array($user));

        $statuse=$stmt->rowCount();
        return $statuse;
    }

     // Check Item Database
  function checkItem($select,$from,$value){
      global $conn;
      $stmt=$conn->prepare("SELECT $select FROM $from WHERE $select=?");
      $stmt->execute(array($value));
      $count=$stmt->rowCount();

      return $count;

  }