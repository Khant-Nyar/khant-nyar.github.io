<?php
    session_start();    
    // session_destroy();

    /**
     *  Database Connection configuration
     *      db_host = / or 127.0.0.1 or localhost and your online server name
     *      db_user = db user name
     *      db_pass = db user password
     *      db_name = db name
     */
    defined("db_host") ? null : define("db_host","localhost");      //edit here
    defined("db_user") ? null : define("db_user","root");           //edit here
    defined("db_pass") ? null : define("db_pass","");               //edit here
    defined("db_name") ? null : define("db_name","personal");  //edit here

    /**
     *  File Directory setup configuration
     *      
     */

    defined("DS") ? null : define("DS",DIRECTORY_SEPARATOR);

	defined("root") ? null : define("root", dirname(__DIR__));
    defined("dashboard") ? null : define("dashboard",root.DS."dashboard");
    defined("resources") ? null : define("resources",root.DS."resources");
    defined("vendors") ? null : define("vendors",root.DS."vendors"); 
    defined("web") ? null : define("web", resources.DS."template/front/");   //edit here for your home path       
    defined("backend") ? null : define("backend", resources.DS."template/backend");         //edit here for your admin path
    defined("App") ? null : define("App", resources.DS."Applications");

    $root = root ."<br>";//to use path 
    $dashboard = dashboard ."<br>";
    $resources = resources ."<br>";
    $vendors = vendors ."<br>";
    $web = web ."<br>";
    $backend = backend ."<br>";
  	$App = App.DS;
    // $connection = mysqli_connect(db_host,db_user,db_pass,db_name);

    /**
     *  Run The All Class Files with spl_autoload_register(function($class){});
     *      
     */

    if (!isset($_SERVER["REMOTE_ADDR"]) || $_SERVER["REMOTE_ADDR"] == '/') {
        define("_CLIENT_PATH", dirname(__DIR__));
    } else {
        define("_CLIENT_PATH", dirname(__DIR__));
    }
    
    spl_autoload_register(function($className){
        //example: "MyController" is converted to "my_controller"  
        $fileName = strtolower(preg_replace('/(?<!^)[A-Z]/', '_$0', $className));
        //by our convention all class are looking like this "class_my_contoller.php"
        $fileName =  $fileName . ".php";
        $paths    = array(
            '',
            'Applications',
            'Applications/classes',
            'Applications/classes/Controllers'
        );
        foreach ($paths as $path) {
            $curPath = _CLIENT_PATH . "/resources/" . $path .DS. $fileName;
            
            if (file_exists($curPath)) {
                // echo $curPath."<br>";
                require_once($curPath);
                break;
            }
        }
    });
    // $obj = new classes/name;
    $db = new Database();
    // $db->Test("Lee LAr");


 ?>
<?php

// require_once App.DS.'classes/database.php';
// require_once App.DS.'classes/Controllers/crud.php';

// $Hello = new Database();
// $World = new Crud();

        // ======   OR  ==========

    // if (!isset($_SERVER["REMOTE_ADDR"]) || $_SERVER["REMOTE_ADDR"] == 'localhost') {
    //     define("_CLIENT_PATH", dirname(__DIR__));
    // } else {
    //     define("_CLIENT_PATH", dirname(__DIR__));
    // }
    
    // spl_autoload_register(function($className){
    //     //example: "MyController" is converted to "my_controller"  
    //     $fileName = strtolower(preg_replace('/(?<!^)[A-Z]/', '_$0', $className));
    //     //by our convention all class are looking like this "class_my_contoller.php"
    //     $fileName =  $fileName . ".php";
    //     $paths    = array(
    //         '',
    //         'Applications',
    //         'Applications/classes',
    //         'Applications/classes/Controllers'
    //     );
    //     foreach ($paths as $path) {
    //         $curPath = _CLIENT_PATH . "/resources/" . $path .DS. $fileName;
            
    //         if (file_exists($curPath)) {
    //             // echo $curPath."<br>";
    //             require_once($curPath);
    //             break;
    //         }
    //     }
    // });
    // // $obj = new classes/name;
    // $db = new Database();

 ?>





<!-- //  Your Order Number is: 1960596866
// khantsithuphyo2001
// studyof-hacking2001
//   <img align="center" src="https://github-readme-stats.vercel.app/api?username=Khant-Nyar&show_icons=true&theme=tokyonight"/> -->
