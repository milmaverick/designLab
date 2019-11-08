<?php

class IndexModel extends Model
{
  public function getPage ()
  {
    return isset($_SESSION['page'])? $_SESSION['page'] :1;
  }

  public function getTask($page=1)
  {
    $_SESSION['page']= isset($page['page']) ? $page['page'] : 1;
    $sort=isset($page['sort']) ? $page['sort'] : 'date';
    $limit=3;

    $tpg=($_SESSION['page']-1)* $limit ;
    if($page['status']=='true')   $query = 'SELECT * FROM `comments` ORDER BY `'.$sort.'` desc LIMIT '.$tpg.', '.$limit;
    else $query = 'SELECT * FROM `comments` WHERE `isPass`=1 ORDER BY `'.$sort.'` desc LIMIT '.$tpg.', '.$limit;
    $comments = $this->db->query($query)->fetchAll();
    return $comments;
  }

  public function pagination($params)
  {
    if($params['status']=='false') $query = 'SELECT count(id) as count FROM `comments` WHERE `isPass`=1';
    else $query = 'SELECT count(id) as count FROM `comments`';

    $pages = $this->db->query($query)->fetchAll();
    return $pages;
  }

  public function save($params)
  {
    // code...
    try {
      $name = htmlspecialchars($params['name']);
      $email = htmlspecialchars($params['email']);
      $text = htmlspecialchars($params['text']);
      $safe = $this->db->prepare("INSERT INTO `comments` SET name= :name, email= :email,
        text= :text, date=CURRENT_TIMESTAMP , img= :img  ,isPass='0' ");
        $arr= ['name'=> $name, 'email'=> $email, 'text'=> $text,
        'img' =>$params['img']];
        $safe->execute($arr);
        return "true";
      }
      catch (PDOException   $e) {
        return $e;
      }
    }



  }
  ?>
