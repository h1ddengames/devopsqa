<?php

	if ( ! defined( 'ABSPATH' ) ) exit;
	global $wp_roles;
?>
<div class="wrap">
	<h2><?php _e( 'Settings', 'client-documentation' ); ?></h2>
	<?php
	
		if(!empty($success)) $this->success($success);
	
	?>
	<p><?php _e( "As all fields are required, any empty field will keep its former value", 'client-documentation' ); ?></p>
	<form action="#" method="post"> 
	<table class="form-table smpldoc_settings">
		<tbody>
			<tr>
				<th colspan="2" class="smpldoc_title">
					<h3><?php _e( 'General', 'client-documentation' ); ?></h3>
				</th>
			</tr>
			<tr>
				<th><?php _e( 'Number of items displayed per page', 'client-documentation' ); ?></th>
				<td><input type="text" name="item_per_page" value="<?php echo $this->settings['item_per_page']; ?>"></td>
			</tr>
			<tr>
				<th><?php _e( 'Default client user role', 'client-documentation' ); ?></th>
				<td class="smplodc_user_items clearfix">
				<?php	
					$roles = $wp_roles->roles;
	                foreach($roles as $srole => $vrole){
	                	
	                	if(in_array($srole, $this->settings['user_role'])) $checked = ' checked';
	                	else $checked = '';
	                	
	                	echo '
	                <p><input type="checkbox" name="user_role[]" value="'.$srole.'"'.$checked.'>'.__( $vrole['name'] ).'</p>';
	                
	                }
				?>
				</td>
			</tr>
			<tr>
				<th colspan="2" class="smpldoc_title">
					<h3><?php _e( 'Custom titles & content', 'client-documentation' ); ?></h3>
				</th>
			</tr>
			<?php
			
			$custom = array(
				'widget_title' => __( 'Widget Title', 'client-documentation' ),
				'welcome_title' => __( 'Welcome Title', 'client-documentation' ),
				'welcome_message' => __( 'Welcome Message', 'client-documentation' )
				//'pinned' => __( 'Pinned Title', 'client-documentation' ),
				//'all_items' => __( 'All Items Title', 'client-documentation' )
			);
			
			foreach( $custom as $cstm => $cstv ){
				
				$label = __( $cstv, $this->slug );
				$value = stripslashes( htmlspecialchars_decode( $this->settings[ 'label_' . $cstm ] )) ;
				
				if($cstm == 'welcome_message'){
					echo "
					<tr>
						<th><label for='label_$cstm'>$label</label></th>
						<td><textarea name='label_$cstm' class='large-text' rows='5'>$value</textarea></td>
					</tr>";
				}else{
					echo "
					<tr>
						<th><label for='label_$cstm'>$label</label></th>
						<td><input type='text' name='label_$cstm' value=\"$value\" class='regular-text'></td>
					</tr>";
				}
				
			}
			
			?>
			<tr>
				<td colspan="2" class="smpldoc_submit">
					<input type="hidden" name="smpldoc_settings_edit" value="yep">
					<input type="submit" class="button button-primary" value="<?php _e( 'Save', 'client-documentation' ); ?>">
				</td>
			</tr>
		</tbody>
	</table>
	</form>
</div>