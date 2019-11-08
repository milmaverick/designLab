<?php

require_once 'App/models/IndexModel.php';

class IndexController extends Controller {

	private $pageTpl = 'App/views/main.tpl.php';

	public function __construct() {
		$this->model = new IndexModel();
		$this->view = new View();
	}

	public function index() {
		$comments= $this->model->getTask();
		$this->pageData= $comments;
		$this->view->render(	$this->pageTpl);
	}

	public function pagination()
	{
		// code...
		$pages= $this->model->pagination($_POST['params']);
		$this->pageData= $pages;
		$this->view->renderPartial('App/views/pagination.php', $this->pageData);
	}

	public function showTask()
	{
		$this->pageData= $this->model->getTask($_POST['params']);
		$this->view->renderPartial('App/views/index.php', $this->pageData);
	}

	public function upload()
	{
		// code...
		$errors=array();
		if(trim($_POST['name'])==''){
			{
				$errors[]='Введите имя';
			}
		}
		if(trim($_POST['email'])==''){
			{
				$errors[]='Введите email';
			}
		}
		if($_POST['text']==''){
			{
				$errors[]='Введите текст';
			}
		}
		if(!preg_match('/^((([0-9A-Za-z]{1}[-0-9A-z\.]{1,}[0-9A-Za-z]{1})|([0-9А-Яа-я]{1}[-0-9А-я\.]{1,}
		[0-9А-Яа-я]{1}))@([-A-Za-z]{1,}\.){1,2}[-A-Za-z]{2,})$/u', trim($_POST['email'])))
		{
			$errors[]='Некорректный email';
		}

		if(empty($errors))
		{

			$params=[
				'name'=>$_POST['name'],
				'email'=>$_POST['email'],
				'text'=>$_POST['text'],
				'img' => $_FILES['uploadimage']['name'] ? uniqid().$_FILES['uploadimage']['name'] : "no-image.png"  ,
			];

			if ( isset($_FILES['uploadimage']) && $_FILES['uploadimage']['tmp_name']!=''){
				list($width, $height) = getimagesize($_FILES['uploadimage']['tmp_name'] );
				if($width> 320 || $height> 240)
				{
					$newwidth = 320;
					$newheight = 240;
					$ratio = $width/$newwidth;
					$w_dest = round($width/$ratio);
					$h_dest = round($height/$ratio);

					$thumb = imagecreatetruecolor($w_dest, $h_dest);

					switch($_FILES['uploadimage']['type']){
						case 'image/jpeg': $source = imagecreatefromjpeg($_FILES['uploadimage']['tmp_name']); break; //Создаём изображения по
						case 'image/png': $source = imagecreatefrompng($_FILES['uploadimage']['tmp_name']); break;  //образцу загруженного
						case 'image/gif': $source = imagecreatefromgif($_FILES['uploadimage']['tmp_name']); break; //исходя из его формата
						default: return false;
					}
					imagecopyresampled($thumb, $source, 0, 0, 0, 0, $w_dest, $h_dest, $width, $height);
					imagejpeg($thumb, "App/img/".$params['img'], 50);
				}
				else {
					move_uploaded_file($_FILES['uploadimage']['tmp_name'], 'App/img/' .$params['img']);
				}
			}

			echo $this->model->save($params);

		}
		else{
			echo array_shift($errors);
		}
	}

	public function getPage()
	{
		// code...
		echo $this->model->getPage();
	}

}
?>
