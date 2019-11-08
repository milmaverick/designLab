<?php

class View {

	public function render( $tpl)
	{

		// ob_start();
		// require $cnt;
		// $content = ob_get_clean();
		require $tpl;
	}

	public function renderPartial($cnt, $pageData){
		require $cnt;
	}

}
?>
