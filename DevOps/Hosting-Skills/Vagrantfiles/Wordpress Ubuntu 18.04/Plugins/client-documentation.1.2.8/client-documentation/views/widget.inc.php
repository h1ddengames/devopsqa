<?php

	if ( ! defined( 'ABSPATH' ) ) exit;
	
	global $wp_roles, $wpdb;
	
	$item_number = $this->settings['item_per_page'];
	$user = wp_get_current_user();
    	
    $entries = $wpdb->get_results("SELECT * FROM $wpdb->simpleDocumentation ORDER BY ordered ASC");
    
    $final_entries = array();	
    $user_roles = $user->roles[0];
    
    foreach($entries as $data){
	    
	    $restricted = json_decode($data->restricted);
	    
	    if( ($data->restricted == null && in_array( $user_roles, $this->settings['user_role'])) || ( is_array($restricted) && in_array( $user_roles, $restricted) ) )
	    	$final_entries[] = $data;
	    
    }
    
    $pages_count = floor(count( $final_entries ) / $item_number);
    if( (count($final_entries) % $item_number) > 0 ) $pages_count++;
    $current_page = isset($_GET['sd']) ? intval($_GET['sd']) : 1;

?>
<div id="simpledocumentation_inside">
	<?php if(count($final_entries)>0){ ?>
	<div class="widget_header">
		<h4><?php echo htmlspecialchars(stripslashes($this->settings['label_welcome_title'])); ?></h4>
		<div class="welcome_message">
			<?php echo htmlspecialchars(stripslashes($this->settings['label_welcome_message'])); ?>
		</div>
	</div>
	<ul class="list_doc" id="simpledoc_list">
		<?php
			$page_i = $current_page - 1;
			for($i = ($page_i * $item_number); ($i < $page_i * $item_number + $item_number) && $i >= ($page_i * $item_number) && $i < count($final_entries); $i++){
				$item = $final_entries[$i];
				$id = $item->ID;
				$icon = $this->icon($item->type);
				$title = stripslashes($item->title);
				$content = htmlspecialchars_decode(stripslashes($item->content));
				if($item->type == 'file'){
					
					if( !$item->attachment_id && is_array($item->content)){
						$file = json_decode(stripslashes(htmlspecialchars_decode($item->content)));
						$url = $file['url'];
					}else{
						$url = htmlspecialchars(wp_get_attachment_url($item->attachment_id));	
					}
					
					$title = "<a href='$url'>$title</a>";
				}
				if($item->type == 'link') $title = "<a href='$content'>".stripslashes($item->title)."</a>";
				
				if($item->restricted) $users = json_decode( $item->restricted );
				else $users = $this->settings['user_role'];
				
				$usersAllowed = '';
				$registered_usr = $wp_roles->roles;
				$ua = 0;
				foreach($users as $user){
					if($ua>0) $usersAllowed .= ', ';
					/*if(in_array($user, $registered_usr) > -1)*/ $usersAllowed .= __( $registered_usr[$user]['name'] );
					$ua++;
				}
				
				$expand = "
					<div class='el_expand'>
						{$content}
					</div>";
				
				if( in_array($item->type, array('link', 'file'))) $expand = '';
				
				
				echo "
				<li id='simpledoc_{$id}' class='smpldoc_li'>
					<div class='el_front' data-id='{$id}' data-order='{$i}'>
						<span class='el_front_bf'>
							<i class='fa fa-{$icon}'></i>
						</span>
						<span class='el_title'>
							{$title}
						</span>
					</div>
					{$expand}
				</li>";
				
			}
		?>	
	</ul>
	<div class="widget_footer">
	<?php if($pages_count > 0): ?>
		<nav>
			<?php _e('Pages', 'client-documentation' ); ?>:
		<?php
			for($i=1;$i <= $pages_count;$i++){ 
				$class = ($i==$current_page)?" class='active'":'';
				echo "<a href='?sd=$i'$class>$i</a>"; 
			}
		?>
		</nav>
	<?php endif; ?>
	</div>
	<?php 
	
		}else{
			
			echo "<p>" . __('No Documentation available yet.', 'client-documentation' ) . "</p>";
			
		}
	
	?>
</div>