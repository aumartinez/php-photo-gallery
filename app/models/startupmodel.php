<?php

class StartupModel extends DbModel {
  protected $dblink;
    
  # First run setup
  public function first_run() {
    $dbname = DBNAME;    
    $this->create_db($dbname);
  }
  
  public function test_tables() {        
    $dbname = DBNAME;
    $sql = "SHOW TABLES IN {$dbname}";
    
    $result = $this->get_query($sql);
    
    if ($result){
      return true;
    }
    else {
      return false;
    }
  }
  
  # Prepare DB tables
  public function setup_tables($sql) {
    $this->set_multyquery($sql);
  }  
  
  # Create DB
  protected function create_db($dbname) {    
    $sql = "CREATE DATABASE {$dbname}
    CHARACTER SET utf8mb4
    COLLATE utf8mb4_unicode_ci";
    
    $this->dblink = new mysqli(DBHOST, DBUSER, DBPASS);
    if (!$this->dblink->query($sql) == true) {
      $_SESSION["error"][] = $this->dblink->error;
    }
    
    $this->dblink->close();    
  }
  
}

?>
