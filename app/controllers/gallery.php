<?php

class Gallery extends Controller {
  
  protected $output;  
    
  public function __construct($controller, $method) {
    parent::__construct($controller, $method);
    
    session_start();
        
    # Any models required to interact with this controller should be loaded here    
    $this->load_model("DbModel");
    $this->load_model("PageModel");
    $this->load_model("StartupModel");
    
    # Instantiate custom view output
    $this->output = new PageView();
    
    # Startup methods
    $this->startup();
  }
  
  # Each method will request the model to present the local resource
  public function index() {        
    
    $active_key = "ACTIVE";
    $active_class = "";
    
    $this->output->add_locale($active_key, $active_class);
    
    $err_key = "UPLOAD_ERROR";
    $err_mess = "";
    
    if (isset($_SESSION["error"]) && isset($_SESSION["submit-form"])){
      $active_key = "ACTIVE";
      $active_class = "active";
      
      $this->output->add_locale($active_key, $active_class);
      
      $err_mess = "\n";
      $err_mess .= "Errors found!";
      $err_mess .= "<br />\n";
      
      foreach ($_SESSION["error"] as $error) {
        $err_mess .= $error . "<br />\n";
      }
    
      unset($_SESSION["error"]);
      unset($_SESSION["submit-form"]);
    }
    
    $this->output->add_locale($err_key, $err_mess);  
    $this->build_page("gallery");  
  }
  
  # Not found handler
  public function not_found() {
    # 404 page
    $this->build_page("not-found");    
  }
  
  # Start setup
  private function startup() {
    # If DB doesn't exists create it
    if (!$this->get_model("DbModel")->test_db()) {
      $this->get_model("StartupModel")->first_run();
      $this->redirect("gallery");
    }
    
    # If DB tables aren't setup, create them
    if (!$this->get_model("StartupModel")->test_tables()) {
      if (file_exists(ROOT . DS . "config" . DS . "createtables.sql")) {
        $sql = file_get_contents(ROOT . DS . "config" . DS . "createtables.sql");
        $this->get_model("StartupModel")->setup_tables($sql);
        $this->redirect("gallery");
      }
      else {
        $this->build_page("db-error");
      }
    }
    
  }
  
  # Controller/Model/View link
  protected function build_page($page_name) {    
    $html_src = $this->get_model("PageModel")->get_page($page_name);    
    $html = $this->output->replace_localizations($html_src);
    
    $this->get_view()->render($html);
  }
  
  # Redirect
  protected function redirect($page) {
    header ("Location: /" . PATH . "/" . $page);
    exit();
  }
  
}

?>
