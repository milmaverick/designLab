<?php
class AdminModel extends Model
{
  public function getAdmin($admin)
  {
    // code...
    $errors= array();
    $query = "SELECT * FROM `admin` WHERE `login`='".$admin."'  limit 1";
    $user= $this->db->query($query)->fetchAll();
    return $user;
  }

  public function isLog()
  {
    $status=isset($_SESSION['logged_user']) ?  true : false ;
    return $status;
  }

  public function isPass($id)
  {
    try {
      $query = "UPDATE `comments` SET `isPass` = ".$id['isPass']." WHERE `comments`.`id` = ".$id['id'];
      $this->db->exec($query);
      return 'true';
    }
    catch (PDOException $e) {
      return $e;
    }
  }


  public function update($params)
  {
    // code...
    try {
      $id = $params['id'];
      $name = $params['name'];
      $email = $params['email'];
      $text = $params['text'];
      $query = "UPDATE `comments` SET `name` = '".$name."', `email` = '".$email."', `text` = '".$text."',
       `isChanged`= '1' WHERE `comments`.`id` = ".$params['id'];
      $this->db->exec($query);
      echo "true";
    }
    catch (PDOException $e) {
      echo $e;
    }
  }

}


?>
