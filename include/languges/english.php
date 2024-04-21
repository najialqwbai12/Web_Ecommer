<?php
function lang($phrase){
    static $lang=array(
    
        'MESSAGE' => 'Welcome',
      
        'HOME_ADMIN' => 'Home',
        'CATEGORIES' => 'Categries',
        'ITEMS'      => 'Items',
        'MENUBAR'    =>'Members',
        'COMMENTS' => 'Comments',
        'STALISTICS' => 'Stalisitc',
        'LOGS'       => 'Logs',
        'Logout'      => 'Logout',
    );
    return $lang[$phrase];
}