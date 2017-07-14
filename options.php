<?php
	if(!is_admin()){
		die(__('access deny!'));
	}
	
	$optionsArray = get_option($domainChange->currentOptionsArray);
	$isOptionsChanged = false;

	if(isset($_POST['newDomain'])){
		$newDomain = strtolower(trim($_POST['newDomain']));
		if( $newDomain != $optionsArray['newDomain']){
			$optionsArray['newDomain'] = $newDomain;
			$isOptionsChanged = true;
		}
	}

	// if isset $_POST['isRedirect'], it means that the isredirect is checked,
	// so it 
	if(isset($_POST['isRedirect'])){
		if(!$optionsArray['isRedirect']){
			$optionsArray['isRedirect'] = true;
			$isOptionsChanged = true;
		}
	}elseif($optionsArray['isRedirect']){
		$optionsArray['isRedirect'] = false;
		$isOptionsChanged = true;
	}

	if($isOptionsChanged){
		update_option($domainChange->currentOptionsArray, $optionsArray);
	}

	$enable = '';
	if($optionsArray['isRedirect'] === true){
		$enable = 'checked="checked"';
	}

	
?>
<div class="wrap">
<h2>Domain Change Setting</h2>

<form method="post" action="<?php //echo $_SERVER["REQUEST_URI"]; ?>">
	<table class="form-table">
		
		<tr valign="top">
			<th scope="row"><label for="newDomain">New Domian Name</label></th>
			<td><input type="text" name="newDomain" id="newDomain" value="<?php echo $optionsArray['newDomain'];?>" />
			<label for="newDomain"><?php echo __('NOTE:if your blog url is: http://www.blog.com, just fill "<strong>www.blog.com</strong>" ');?></label></td>
		</tr>

		<tr valign="top">
			<th scope="row"><label for="isRedirect">Open feature</label></th>
			<td><input type="checkbox" id="isRedirect" name="isRedirect" <?php echo $enable;?> type="checkbox" />
			<label for="isRedirect"><?php echo __('if this option is unchecked,this feature will be unable.');?></label></td>
		</tr>

	</table>
<p class="submit">
<input type="submit" class="button-primary" value="<?php _e('Save Changes') ?>" ></input>
</p>

</form>
</div>