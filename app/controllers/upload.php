<?php

class Upload extends Controller {
  
  public function __construct($controller, $method) {
    parent::__construct($controller, $method);
    
    session_start();
        
    # Any models required to interact with this controller should be loaded here    
    $this->load_model("DbModel");    
    $this->load_model("UploadModel");
        
  }
  
  # Each method will request the model to present the local resource
  public function index() {        
    if (!isset($_POST["submit-form"])) {
      $this->redirect("gallery");
    }
    
    $_SESSION["submit-form"] = true;
    $_SESSION["error"] = array();
    
    $this->get_model("UploadModel")->required();    
    $this->get_model("UploadModel")->empty_submit();
    $this->get_model("UploadModel")->max_images();
    $this->get_model("UploadModel")->type_check();
    $this->get_model("UploadModel")->size_check();
    $this->get_model("UploadModel")->upload();
    
    if (count($_SESSION["error"] = 0)) {
      unset($_SESSION["error"]);
      unset($_SESSION["submit-form"]);
    }
    
    $this->redirect("gallery");
  }
  
  # Not found handler
  public function not_found() {
    # 404 page
    $this->redirect("gallery");    
  }
  
  # Redirect
  protected function redirect($page) {
    header ("Location: /" . PATH . "/" . $page);
    exit();
  }
  
}

?>
