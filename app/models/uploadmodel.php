<?php

class UploadModel extends DbModel {
  protected $sanitized = array();
  protected $user;
  
  # Allowed types
  protected $allowed = array("jpg", "png", "jpeg", "gif");
  protected $imgs = array();
  # Max size (2MB)
  protected $max_size = 2 * 1024 * 1024;
  # Max image upload
  protected $limit = 3;
  
  # Upload required
  public function required() {
    if (!isset($_POST["user"]) || $_POST["user"] == "") {
      $_SESSION["error"][] = "Invalid entry";
    }    
    $this->error_check("gallery");
  }
  
  # Sanitize user input
  public function sanitize_post() {
    $this->sanitized = array();
    
    foreach ($_POST as $key => $value) {
      $this->sanitized[$key] = $this->open_link()->real_escape_string($value);
    }
    
    return $this->sanitized;
  }
  
  # Empty submit check
  public function empty_submit() {
    # Empty array check    
    if (empty(array_filter($_FILES["images"]["name"]))) {
      $_SESSION["error"][] = "No images selected";
    }
    
    $this->error_check("gallery");
  }
  
  # Max image size
  public function max_images() {
    if (count($_FILES["images"]["name"]) > $this->limit) {
      $_SESSION["error"][] = "Please upload only " . $this->limit . " images";
      $this->error_check("gallery");
    }
  }
  
  # File type check
  public function type_check() {
    foreach ($_FILES["images"]["tmp_name"] as $key => $value) {
      $file_name = $_FILES["images"]["name"][$key];
      $file_ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));
      
      if (!in_array($file_ext, $this->allowed)) {
        $_SESSION["error"][] = "Invalid image file type: " . $file_ext;
      }
    }
    
    $this->error_check("gallery");
  }
  
  # Max size check
  public function size_check() {
    foreach ($_FILES["images"]["tmp_name"] as $key => $value) {
      $file_size = $_FILES["images"]["size"][$key];
      
      if ($file_size > $this->max_size) {
        $_SESSION["error"][] = "Images should be less than 2 MB";
      }
    }
    
    $this->error_check("gallery");
  }
  
  # Upload
  public function upload() {
    # Target dir
    $target_dir = UPLOAD;
    
    foreach ($_FILES["images"]["tmp_name"] as $key => $value) {
      $file_tempname = $_FILES["images"]["tmp_name"][$key];
      $file_name = $_FILES["images"]["name"][$key];
      $file_ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));
      
      $hash = uniqid("", TRUE);
      $hash = md5($hash);
      $hash = $this->open_link()->real_escape_string($hash);
      $this->close_link();
      
      $file_path = $target_dir . $hash . "." . $file_ext;
      
      if (move_uploaded_file($file_tempname, $file_path)) {
        $this->imgs[] = $file_name;
      }
      else {
        $_SESSION["error"][] = "Error uploading " . $file_name;
      }
    }
    
    $this->error_check("gallery");
  }
  
  # Error check method
  protected function error_check($page) {
    if (count($_SESSION["error"]) > 0) {
      error_log("Error : " . $this->user);
      $this->redirect(PATH . "/" . $page);
    }
  }
  
  # Redirect
  private function redirect($page) {
    header ("Location: /" . $page);
    exit();
  }
  
}

?>
