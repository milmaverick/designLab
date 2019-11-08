<?php

require_once 'App/models/AdminModel.php';

class AdminController extends Controller
{

  public function __construct() {
    $this->model = new AdminModel();
    $this->view = new View();
  }

  public function logIn()
  {
    // code...
    $user =$this->model->getAdmin($_POST['params']['admin']);

    if($user)
    {
      if($_POST['params']['passwd']==$user[0]['psw'])
      {
        $_SESSION['logged_user']=$user[0]['login'];
        echo "true";
      }
      else{
        $errors[]='неверный пароль';
      }
    }
    else
    {
      $errors[]='Пользователь не найден';
    }

    if(!empty($errors)){
      echo array_shift($errors);
    }
  }

  public function isLog()
  {
     $status = $this->model->isLog() ?  "true" : "false";
     echo $status;
  }

  public function logOut(){
    if($this->model->isLog())
    {
      unset($_SESSION['logged_user']);
      echo "Вышел из Аккаунт Php";
    }
    else {
      echo "Нету акка1";
    }
  }

  public function isPass()
	{
		if (isset($_POST['params'])) {
			echo $this->model->isPass($_POST['params']);
		}
	}

	public function update()
	{
		// code...
		if (isset($_POST['params'])) {
			echo $this->model->update($_POST['params']);
		}
	}





}
