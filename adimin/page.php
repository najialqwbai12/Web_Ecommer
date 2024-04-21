<?php

$do = isset($_GET['do'])?$_GET['do']:"manege";

if($do=='manege'){
    echo 'Welcom Yoe are :';
        echo '<a href="?do=inser">Add new insert+</a>';
}

elseif($do=='add'){
    echo 'Welcom Yoe are :  Add'; 
}
elseif($do=='inser'){
    echo 'Welcom Yoe are :  Insert';
}else{
        echo 'Error  Yoe are :';

}