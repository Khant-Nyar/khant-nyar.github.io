<?php 

    /**
     *  Database Connection 
     */
    // alert('Test from Database');
    class Database{
		public $connect;
		public $error;


		public function __construct(){
			$this->connect = mysqli_connect(db_host,db_user,db_pass,db_name);
			if(!$this->connect){
				echo "<script>alert(\"Lose to Connect Database\")</script>" . mysqli_connect_error($this->connect);
			}else{
				// echo "<script>alert(\"Connect To Database\")</script>";
			}
		}

		public function Test($pre){
			echo "$pre is reply";
		}


    }
    // $Db = new Database();
 ?>