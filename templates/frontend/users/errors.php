<?php
	if( !empty( $errors ) ) :
?>
  <div class="error">
<?php
		foreach( $errors as $error ) :
  	  		echo '<p>' . $error . '</p>';
		endforeach;
?>
</div><!--/error-->
<?php 
	endif;
?>