<?php

$numb= ceil($pageData[0]['count']/3);
for ($i=1; $i <= $numb; $i++)
{
   if($_POST['params']['page']==$i) $cls="page-item active";
   else $cls ="page-item";
   echo '<li class="'.$cls.'"><a class="page-link"
        href="#"  onclick="pagination('.$i.')">'.$i.'</a></li>';
} ?>
