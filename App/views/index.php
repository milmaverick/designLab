<?php
if (isset($pageData)){
  if(isset($_SESSION['logged_user'])){

    foreach ($pageData as $comment) {
      ?>
      <div class='comment <?if ($comment['isPass']==1) echo "doneElement";?>'  id="comment<?=$comment['id']?>">
        <div class="media">
          <div class="media-body">
            <div class="task_inner">

              <div class="head__tasks">
                <div class="img">
                  <img src='/App/img/<?=$comment['img']?>'  alt='<?=$comment['name']?>'>
                </div>

                <div class="name" >ИМЯ: <span id="name<?=$comment['id']?>"><?=$comment['name']?></span></div>
                <div class="email" >EMAIL: <span id="email<?=$comment['id']?>"><?=$comment['email']?></span></div>
              </div>
              <div class="options">
                <span class='res isChanged <?if ($comment['isChanged']==0) echo "displayNone";?>'> Изменен Админом</span>
                <span class='res resDel <?if ($comment['isPass']==0) echo "displayNone";?>'  id='delete<?=$comment['id']?>'>
                  <a href='#' onclick='deleteElement(<?=$comment['id']?>)'> Отклонить</a>
                </span>

                <span class='res resReturn <?if($comment['isPass']==1) echo "displayNone";?>'  id='return<?=$comment['id']?>'>
                  <a href='#' onclick='accessElement(<?=$comment['id']?>)'> Пропустить</a>
                </span>
                <span class='res resChange'  data-toggle="modal" data-target="#exampleModal" id='change<?=$comment['id']?>'>
                  <a href='#' onclick='changeElement(<?=$comment['id']?>)'> Изменить</a>
                </span>
              </div>
            </div>

            <div class="text"  >TEXT: <span id="text<?=$comment['id']?>"><?=$comment['text']?></span> </div>

            <br>
          </div>
        </div>
      </div>
    <?	}
  }
  else{
    foreach ($pageData as $comment) {
      ?>
      <div class="comment">
        <div class="media">
          <div class="media-body">
            <div class="task_inner">
              <div class="head__tasks">
                <div class="name" id="name<?=$comment['id']?>">ИМЯ: <?=$comment['name']?></div>
                <div class="email" id="email<?=$comment['id']?>">EMAIL: <?=$comment['email']?></div>
              </div>
              <div class="options">
                <span class='res isChanged <?if ($comment['isChanged']==0) echo "displayNone";?>'> Изменен Админом</span>
              </div>
            </div>
            <div class="text"  id="text<?=$comment['id']?>">TEXT: <?=$comment['text']?></div>
            <br>
          </div>
        </div>
      </div>
    <?
    }
  }
}
?>
