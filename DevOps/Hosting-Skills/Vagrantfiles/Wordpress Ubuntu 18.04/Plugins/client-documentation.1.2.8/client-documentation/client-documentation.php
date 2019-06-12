<?php
/*

	Plugin Name: Simple Documentation
	Plugin URI: https://mathieuhays.co.uk/simple-documentation/
	Description: This plugin helps webmasters/developers to provide documentation through the wordpress dashboard.
	Version: 1.2.8
	Author: Mathieu Hays
	Author URI: https://mathieuhays.co.uk
	License: GPL2
	Text Domain: client-documentation
	Domain Path: /languages

	#-----------------------------------------------------------------------
	#-- Copyright ----------------------------------------------------------
	#-----------------------------------------------------------------------

	Copyright 2015  Mathieu Hays  (email : mathieu@mathieuhays.co.uk)

	This program is free software; you can redistribute it and/or modify
	it under the terms of the GNU General Public License, version 2, as
	published by the Free Software Foundation.

	This program is distributed in the hope that it will be useful,
	but WITHOUT ANY WARRANTY; without even the implied warranty of
	MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
	GNU General Public License for more details.

	You should have received a copy of the GNU General Public License
	along with this program; if not, write to the Free Software
	Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA


	#--------------------------------------------------------------------------
	#-- Contribution ----------------------------------------------------------
	#--------------------------------------------------------------------------

	If you feel like contributing to this plugin there is always translation to
	be made. I'm always happy to hear your ideas to extend the plugin
	functionnalities and make it better to use for everyone.

	Current Translations:
	* French ----------- based on current version
	* English ---------- based on current version
	* Spanish ---------- based on v.1.1.1
	* German ----------- based on v.1.1.6
	* Serbo-Croatian --- based on v.1.1.8
	* Dutch ------------ based on v.1.2.3

	Compatibility from 2.8.0
*/

/* Security */
if ( ! defined( 'ABSPATH' ) ) exit;

class simpleDocumentation {

	const VERSION = "1.2.8";

	/* Used as text domain and slug */
	public $slug = 'simpledocumentation';

	public $settings = array();

	public function __construct(){

		$this->load_textdomain();
		$this->settings();

		//Activation
		register_activation_hook( __FILE__, array( $this, 'setup_tables' ) );

		//Uninstall
		register_uninstall_hook( __FILE__, array( 'simpleDocumentation', 'uninstall' ) );

		add_action( 'plugins_loaded' , array( $this, 'load_textdomain' ) );
		add_action( 'wp_dashboard_setup', array( $this, 'add_dashboard' ) );
		add_action( 'admin_init' , array( $this , 'add_admin_styles' ) );
		add_action( 'admin_init' , array( $this , 'add_admin_scripts' ) );
		add_action( 'wp_ajax_simpleDocumentation_ajax' , array( $this , 'ajax' ) );
		//add_action( 'admin_enqueue_scripts', array( $this, 'scripts') );

		// MU support
	    if(is_multisite()){
	      add_action( 'network_admin_menu', array( $this, 'register_page' ));
	      add_action( 'wp_network_dashboard_setup', array($this, 'add_dashboard') );
	    }else{
	      add_action( 'admin_menu' , array( $this , 'register_page' ) );
	    }

	}

	/**
	 * 	Localisation
	 *	Help to translate this plugin using the simpledocumentation.po file
	 */
	public function load_textdomain() {
		load_plugin_textdomain( 'client-documentation' , false, basename( dirname( __FILE__ ) ) . '/languages' );
	}

	/*
	 *	Initialize settings
	 */
	public function settings(){
		global $wpdb;

		$table = get_site_option( 'clientDocumentation_table' );

		$settings_defaults = array(
			'table' => $wpdb->prefix . $this->slug,
			'user_role' => array( 'administrator', 'editor' ),
			'first_activation' => true,
			'db_version' => '2.0',
			'item_per_page' => 10,
			'label_widget_title' => __( 'Resources' , 'client-documentation' ),
			'label_welcome_title' => __( 'Welcome', 'client-documentation' ),
			'label_welcome_message' => __( 'Need Help ? All you need is here !', 'client-documentation' ),
			//'label_pinned' => __( 'Pinned', 'client-documentation' ),
			//'label_all_items' => __( 'All items', 'client-documentation' )
		);

		$rename = array(
			'table' => 'table',
			'user_role' => 'clientRole',
			'first_activation' => '',
			'db_version' => 'dbVersion',
			'item_per_page' => 'itemNumber',
			'label_widget_title' => 'widgetTitle',
			'label_welcome_title' => 'welcomeTitle',
			'label_welcome_message' => 'welcomeMessage'
			//'label_pinned' => 'pinned',
			//'label_all_items' => 'allitems'
		);

		/* Settings already defined */
		if( $settings = get_site_option( $this->slug . '_main_settings' ) ){

			$this->settings = $settings;

		}/* Upgrade from previous version */
		elseif( !empty( $table ) ){

			foreach( $settings_defaults as $setting => $default ){

				if( $setting == 'table')
					$this->settings['table'] = $table;
				else
					$this->settings[$setting] = ( get_option( 'clientDocumentation_'.$rename[$setting] ) ? get_option( 'clientDocumentation_'.$rename[$setting] ) : $default );

			}

			if( !is_array( $this->settings['user_role'] ) )
				$this->settings['user_role'] = array( $this->settings['user_role'] );

			// 1.1.X editor as default. Need to add administrator as well.
			if( !in_array( 'administrator', $this->settings['user_role']) ) $this->settings['user_role'][] = 'administrator';

			/* Save settings */
			if( add_site_option( $this->slug . '_main_settings', $this->settings ) ){

				/* Clean previous version settings */
				delete_option( 'clientDocumentation_clientRole' );
				delete_option( 'clientDocumentation_dbVersion' );
				delete_option( 'clientDocumentation_widgetTitle' );
				delete_option( 'clientDocumentation_itemNumber' );
				delete_option( 'clientDocumentation_welcomeMessage' );
				delete_option( 'clientDocumentation_welcomeTitle' );
				delete_option( 'clientDocumentation_allitems' );
				delete_option( 'clientDocumentation_pinned' );
				delete_site_option( 'clientDocumentation_table' );

			}

		}/* New Installation */
		else{

			$this->settings = $settings_defaults;

		}

		$wpdb->simpleDocumentation = $this->settings['table'];

		// Activation hook fix on upgrade
		if( $this->settings['db_version'] != '2.0' ) $this->setup_tables();

	}

	/*
	 *	Update Settings
	 */
	public function update_settings(){
		update_site_option( $this->slug . '_main_settings', $this->settings );
	}

	/**
	 *	Setup table with default values
	 *
	 *	type: 			note | file | link | video | image
	 *	title:			Title appearing on the tabs
	 *	content:		text | url | embed code
	 *	etoile_b:		true | false - Force pin item
	 *	etoile_t:		Timestamp - to order
	 *	restricted:		user_role restriction
	 *	attachment_id	file attachment_id
	 *	ordered:			Order Elements
	 *
	 */
	public function setup_tables(){
		global $wpdb;

		//$wpdb->hide_errors();
		$table = $wpdb->simpleDocumentation;

	    require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );

		if($this->settings['db_version'] == '1.0'){

			$cdoc_tables = "ALTER TABLE ".$table." ADD COLUMN restricted varchar(500), ADD COLUMN attachment_id int(5), ADD COLUMN ordered int(5)";

			if( $wpdb->query( $cdoc_tables ) )
				$this->settings['db_version'] = '2.0';

			$this->settings['first_activation'] = false;

		}else{

			$cdoc_tables = "
	    	CREATE TABLE $table (
				ID bigint(20) NOT NULL auto_increment,
				type varchar(200) NOT NULL default 'note',
				title varchar(255) NOT NULL default 'New document',
				content text NOT NULL,
				etoile_b tinyint(1) NOT NULL default 0,
				etoile_t datetime,
				restricted varchar(500),
				attachment_id bigint(20),
				ordered bigint(20),
				UNIQUE KEY ID (ID)
			);";

			$wpdb->query( $cdoc_tables );

		}

		$data = array(
			'type' => 'note',
			'title' => __( 'How to create your first post', 'client-documentation' ),
			'content' => __( 'Example of content' , 'client-documentation' ),
		);

		if($this->settings['first_activation']){

			$initial_entries = $wpdb->insert($wpdb->simpleDocumentation, $data);
			$this->settings['first_activation'] = false;
		}

		$this->update_settings();
	}

	/*
	 *	Remove Plugin Data
	 */
	public function uninstall(){
		global $wpdb;

	    $wpdb->query( "DROP TABLE " . $wpdb->simpleDocumentation );
		delete_site_option( 'simpledocumentation_main_settings' );

	}

	public function scripts($hook){

		if($hook == 'admin.php' && isset($_GET['page']) && $_GET['page'] == 'simpledocumentation')
			wp_enqueue_script( 'jquery-ui-sortable' );

	}

	/**
     * Thanks to App themes.
     * @edit Mathieu: check within an array
     * http://docs.appthemes.com/tutorials/wordpress-check-user-role-function/
     *
     * @param string $role Role name
     * @param int $user_id (optionnal) The ID of a user. Defaults to the current user.
     * @return bool
     */
    public function check_user_role($roles, $user_id = null){

	    if( is_numeric($user_id) )
	    	$user = get_userdata( $user_id );
	    else
	    	$user = wp_get_current_user();

	    if( empty($user) )
	    	return false;

		if( is_array($roles) ){
			foreach( $roles as $role ){
				if( in_array( $role, (array) $user->roles ) ) return true;
			}
			return false;
		}

	    return in_array( $roles, (array) $user->roles );

    }

    /**
	 * Add admin stylesheet.
	 *
	 * Icon webfont : Font Awesome
	 * http://fortawesome.github.io/Font-Awesome/
	 */
	public function add_admin_styles() {
		global $wp_styles;

		wp_enqueue_style( $this->slug . '_stylesheet' , plugins_url('css/simpledocumentation.css', __FILE__), false, self::VERSION );
		wp_enqueue_style('font-awesome', plugins_url('css/font-awesome.min.css', __FILE__) );
	}

	/**
	 * Add admin scripts.
	 */
	public function add_admin_scripts() {
		global $pagenow;

		// Localization
		$local = array(
			'ajax_url' => admin_url( 'admin-ajax.php' ),
			'fields_missing' => __( 'Following fields are missing :', 'client-documentation' ),
			'is_missing' => __( 'is missing !', 'client-documentation' ),
			'item_number' => $this->settings['item_per_page'],
			'view_list' => __( 'View List', 'client-documentation' ),
			'order_saved' => __( 'Order saved', 'client-documentation' ),
			'loading' => __( 'Loading', 'client-documentation' ),
			'processing' => __( 'Processing', 'client-documentation' ),
			'label_done' => __( 'Done', 'client-documentation' ),
			'error' => __( 'Error!', 'client-documentation' ),
			'add_item' => __( 'Add item', 'client-documentation' ),
			'save_changes' => __( 'Save changes', 'client-documentation' ),
			'add_new' => __( 'Add new', 'client-documentation' ),
		);

        if($pagenow == 'index.php' || ($pagenow == 'admin.php' && ( $_GET['page'] == $this->slug || $_GET['page'] == $this->slug . '_import_export') )){
			wp_enqueue_script( 'jquery-ui-sortable' );
	        wp_enqueue_script( $this->slug . '_js', plugins_url( '/js/simpledocumentation.js' , __FILE__ ), array( 'jquery' ), self::VERSION );
	        wp_localize_script( $this->slug . '_js', 'simple_documentation_vars', $local );
	        wp_enqueue_media();
        }
    }

	/**
     * 	Add Widget on dashboard.
     */
    public function add_dashboard(){
		global $wpdb, $wp_roles;

		$entries = $wpdb->get_results("SELECT restricted FROM {$wpdb->simpleDocumentation} ORDER BY ordered ASC");
		$user = wp_get_current_user();
	    $user_roles = $user->roles[0];
	    $display = false;

	    foreach($entries as $data){

		    $restricted = json_decode($data->restricted);

		    if( ($data->restricted == null && in_array( $user_roles, $this->settings['user_role'])) || ( is_array($restricted) && in_array( $user_roles, $restricted) ) )
		    	$display = true;

	    }

		// Filter by role and apply custom title
		if($display)
	    	wp_add_dashboard_widget( $this->slug , stripslashes($this->settings['label_widget_title']) , array( $this, 'dashboard_widget') );

    }

    /*
     *	Register page & subpages
     */
    public function register_page(){
	    global $submenu;

	    add_menu_page(
	    	'Simple Documentation',
			'Simple Documentation',
	    	'manage_options',
	    	$this->slug,
	    	array( $this, 'page_content' ) ,
			'dashicons-editor-help'
	    );
		add_submenu_page(
			$this->slug,
			__( 'Import / Export', 'client-documentation' ),
			__( 'Import / Export', 'client-documentation' ),
			'manage_options',
			$this->slug . '_import_export',
			array( $this, 'import_export_page' )
		);
		add_submenu_page(
			$this->slug,
			__( 'Settings', 'client-documentation' ),
			__( 'Settings', 'client-documentation' ),
			'manage_options',
			$this->slug . '_settings',
			array( $this, 'settings_page' )
		);

		if ( isset( $submenu[$this->slug] ) )
			$submenu[$this->slug][0][0] = __( 'Documentation', 'client-documentation' );

    }

    /*
     *	Retrieve icon by type
     */
    public function icon($icn){
	    switch($icn){
		    case 'video':
		    	return 'youtube-play';
		    break;
		    case 'link':
		    	return 'link';
		    break;
		    case 'file':
		    	return 'files-o';
		    break;
		    case 'note':
		    default:
		    	return 'comments';
		    break;
	    }
    }

    /*
     *	Display Success message
     */
    function success($message){

	   echo "
		   <div class='updated below-h2'>
		   	<p>$message</p>
		   </div>";
    }

    /**
     *	Dashboard widget content
     */
    public function dashboard_widget(){
	   include('views/widget.inc.php');
    }

    /**
     *	List documentation items. Add / Edit items
     */
    public function page_content(){
    	include('views/list-add-edit.inc.php');
    }

    /**
     *	Settings page
     */
    public function settings_page(){

    	if(isset($_POST['smpldoc_settings_edit']) && $_POST['smpldoc_settings_edit'] === 'yep'){

	    	$options = array(
	    		'user_role','item_per_page','label_widget_title','label_welcome_title','label_welcome_message','label_pinned','label_all_items' );
	    	$ok_to_save = array();

	    	foreach( $options as $option ){

		    	if( !empty( $_POST[$option] ) ){

		    		switch($option){

		    			case 'user_role':
		    				$val = (is_array( $_POST[$option] )) ? $_POST[$option] : null;
		    			break;
		    			case 'item_per_page':
		    				$val = intval( $_POST[$option] );
		    			break;
		    			default:
		    				$val = htmlspecialchars( $_POST[$option] );
		    			break;

		    		}

		    		$ok_to_save[$option] = $val;
		    		foreach( $ok_to_save as $save => $value ){
			    		$this->settings[ $save ] = $value;
		    		}
		    		if( count($ok_to_save) > 0 ){
		    			$this->update_settings();
		    			$success = __( 'Settings saved', 'client-documentation' );
		    		}
		    	}

	    	}

    	}

    	/* Display form */
		include('views/settings.inc.php');
	}

    /**
     *	Import / Export page
     */
    public function import_export_page(){
		include('views/import-export.inc.php');
	}

	/**
	 *	Send. echo//die
	 */
	private function s($response){
		echo json_encode($response);
		die;
	}


	/**
	 *	Get attachment url
	 *
	 *	@param  Int		$attachment_id
	 *	@return String
	 */
	private function get_attachment_url( $attachment_id ) {
		$attachment = get_post( $attachment_id );
		return $attachment->guid;
	}


	/**
	 *	Get attachment filename
	 *
	 *	@param  Int		$attachment_id
	 *	@return String
	 */
	private function get_attachment_filename( $attachment_id ) {
		$attachment_url = $this->get_attachment_url( $attachment_id );
		return basename( $attachment_url );
	}


	private function filterData($data, $export = false){

		if($export){
			$final = array();
			foreach($data as $d){
				$attachment_url = null;
				$attachment_filename = null;

				if ( !empty( $d->attachment_id ) ) {
					$attachment_url = $this->get_attachment_url( $d->attachment_id );
					$attachment_filename = $this->get_attachment_filename( $d->attachment_id );
				}

				if($d->type == 'file') $content = json_decode($d->content);
				else $content = stripslashes(htmlspecialchars_decode($d->content));

				$final[] = array(
					'ID' => $d->ID,
					'title' => stripslashes(htmlspecialchars_decode($d->title)),
					'attachment_id' => $d->attachment_id,
					'content' => $content,
					'etoile_b' => $d->etoile_b,
					'etoile_t' => $d->etoile_t,
					'ordered' => $d->ordered,
					'restricted' => json_decode($d->restricted),
					'type' => $d->type,
					'attachment_filename' => $attachment_filename,
					'attachment_url' => $attachment_url
				);
			}
			return $final;
		}

		$attachment_url = null;
		$attachment_filename = null;

		if ( !empty( $data->attachment_id ) ) {
			$attachment_url = $this->get_attachment_url( $data->attachment_id );
			$attachment_filename = $this->get_attachment_filename( $data->attachment_id );
		}

		return array(
			'ID' => $data->ID,
			'title' => stripslashes(htmlspecialchars_decode($data->title)),
			'attachment_id' => $data->attachment_id,
			'content' => stripslashes(htmlspecialchars_decode($data->content)),
			'etoile_b' => $data->etoile_b,
			'etoile_t' => $data->etoile_t,
			'ordered' => $data->ordered,
			'restricted' => json_decode($data->restricted),
			'type' => $data->type,
			'attachment_filename' => $attachment_filename,
			'attachment_url' => $attachment_url
		);

	}

	/**
	 *	Ajax Handler
	 */
	public function ajax(){
		global $wpdb, $wp_roles;

		if(!isset($_POST['a']))
			$this->s(array( 'status' => 'error', 'type' => 'no-action' ));

		if($_POST['a'] == 'add' || $_POST['a'] == 'edit'){

			if(!empty($_POST['item']) && is_array($_POST['item'])){

				$item = $_POST['item'];
				if(!empty($item['type'])){

					$empty_fields = array();
					if(empty($item['title'])) $empty_fields[] = __( 'title', 'client-documentation' );

					$title = htmlspecialchars( $item['title'] );
					$roles = isset($item['user_roles']) ? json_encode( $item['user_roles'] ) : null;


					if( $item['type'] == 'note' || $item['type'] == 'video' ){

						if(empty($item['editor'])) $empty_fields[] = __( 'content', 'client-documentation' );

						$content = htmlspecialchars( $item['editor'] );

					}elseif( $item['type'] == 'link' ){

						if(empty($item['input'])) $empty_fields[] = __( 'link', 'client-documentation' );

						if(!preg_match('/^https?:\/\/(.)*/', $item['input']))
							$content = 'http://' . htmlspecialchars( $item['input'] );
						else
							$content = htmlspecialchars( $item['input'] );

					}elseif( $item['type'] == 'file' ){

						if(empty($item['file'])) $empty_fields[] = __( 'file', 'client-documentation' );

						$attachment = intval( $item['file'] );
						$attachment_filename = $this->get_attachment_filename($attachment);
						$attachment_url = $this->get_attachment_url($attachment);

					}
					if(empty($empty_fields)){

						$query = ($_POST['a'] == 'edit') ? "UPDATE " :"INSERT INTO ";
						$query .= $wpdb->simpleDocumentation;

						if($item['type'] != 'file' && $_POST['a'] == 'add')
							$query .= " (type,title,content,restricted,ordered) VALUES(%s,%s,%s,%s,%d)";
						elseif($item['type'] == 'file' && $_POST['a'] == 'add')
							$query .= " (type,title,attachment_id,restricted,ordered) VALUES(%s,%s,%d,%s,%d)";
						elseif($item['type'] != 'file')
							$query .= " SET type='%s',title='%s',content='%s',restricted='%s' ";
						elseif($item['type'] == 'file')
							$query .= " SET type='%s',title='%s',attachment_id='%d',restricted='%s'";

						$query .= ($_POST['a'] == 'edit') ? " WHERE ID='%d'" : "";

						if( $item['type'] != 'file' && $_POST['a'] == 'add' )
							$query_p = $wpdb->prepare( $query, $item['type'], $title, $content, $roles, 99999 );
						elseif( $item['type'] != 'file' && $_POST['a'] == 'edit' )
							$query_p = $wpdb->prepare( $query, $item['type'], $title, $content, $roles, $item['id'] );
						elseif( $item['type'] == 'file' && $_POST['a'] == 'add' )
							$query_p = $wpdb->prepare( $query, $item['type'], $title, $attachment, $roles, 99999 );
						elseif( $item['type'] == 'file' && $_POST['a'] == 'edit' )
							$query_p = $wpdb->prepare( $query, $item['type'], $title, $attachment, $roles, $item['id'] );


						if($roles !== null) $users_nt = json_decode($roles);
						else $users_nt = $this->settings['user_role'];

						$users = array();
						$registered_usr = $wp_roles->roles;
						foreach( $users_nt as $usr ){

							//if( in_array( $usr, $registered_usr) ) $users[] = __( $registered_usr[$usr]['name'], $this->slug );
							$users[] = __( $registered_usr[$usr]['name'] ); // use WordPress translation for user role
						}

						$data = array(
							'type' => $item['type'],
							'title' => stripslashes($title),
							'content' => ( isset($content) ? stripslashes(htmlspecialchars_decode($content)) : null ),
							'attachment' => ( isset($attachment) ? $attachment : null ),
							'attachment_url' => ( isset($attachment_url) ? $attachment_url : null ),
							'attachment_filename' => ( isset($attachment_filename) ? $attachment_filename : null),
							'users' => $users
						);

						if( $wpdb->query( $query_p ) ){
							$data['id'] = ($_POST['a'] == 'add') ? $wpdb->insert_id : $item['id'];
							$this->s(array( 'status' => 'ok', 'type' => $_POST['a'], 'data' => $data ));
						}else{
							$this->s(array( 'status' => 'error', 'type' => 'query-fail' ));
						}

					}else{

						$this->s(array( 'status' => 'user-error', 'type' => 'empty_fields', 'data' => $empty_fields ));

					}

				}// item[type] not empty
				$this->s(array( 'status'=>'error', 'type' => 'item-no-type' ));

			}// test $_POST item
			$this->s(array( 'status' => 'error', 'type' => 'no-item' ));

		}else if($_POST['a'] == 'delete'){

			// must return url to print in the list
			if(empty($_POST['id'])) $this->s(array('status'=>'error', 'type'=>'no-id' ));
			$id = intval($_POST['id']);

			$query = $wpdb->prepare( "DELETE FROM {$wpdb->simpleDocumentation} WHERE ID = '%d' ", $id );

			if($wpdb->query($query))
				$this->s(array( 'status' => 'ok', 'type' => 'delete', 'id' => $id ));
			else
				$this->s(array( 'status' => 'error', 'type' => 'query-fail' ));

		}elseif($_POST['a'] == 'reorder'){

			if(isset($_POST['data']) && is_array($_POST['data'])){
				$error = 0;

				foreach($_POST['data'] as $index => $item_id){
					$reorder_query = $wpdb->prepare(
						"UPDATE {$wpdb->simpleDocumentation} SET ordered = %d WHERE ID = %d;",
						$index,
						$item_id
					);

					if ( ! $wpdb->query( $reorder_query ) ) {
						$error++;
					}
				}

				if($error < 1)
					$this->s(array( 'status' => 'ok', 'type' => 'reordered' ));
				else
					$this->s(array( 'status' => 'error', 'type' => 'save-reorder-fail' ));

			}

		} elseif ( $_POST['a'] == 'get-data' ) {
			$item_id = intval($_POST['id']);

			$get_query = $wpdb->prepare(
				"SELECT * FROM {$wpdb->simpleDocumentation} WHERE ID = %d;",
				$item_id
			);

			if ( $data = $wpdb->get_results( $get_query ) ) {
				$this->s([
					'status' => 'ok',
					'type' => 'get-data',
					'data' => $this->filterData($data[0]),
				]);
			} else {
				$this->s( [
					'status' => 'error',
					'type' => 'get-data',
					'id' => $item_id,
				]);
			}

		}elseif($_POST['a'] == 'export'){

			$options = array( 'included' => false, 'data' => null );
			if($_POST['options'] == 'include'){
				$options['included'] = true;
				$options['data'] = array(
					'user_role' => $this->settings['user_role'],
					'item_per_page' => $this->settings['item_per_page'],
					'label_widget_title' => $this->settings['label_widget_title'],
					'label_welcome_title' => $this->settings['label_welcome_title'],
					'label_welcome_message' => $this->settings['label_welcome_message']
				);
			}

			$query = "SELECT * FROM $wpdb->simpleDocumentation";
			if($data = $wpdb->get_results( $query ))
				$this->s( array( $this->filterData($data, true), $options ) );

			else
				$this->s( __('error', 'client-documentation' ));

		}elseif($_POST['a'] == 'import'){

			//var_dump( $_POST['data'] );
			$data = $_POST['data'];

			$cols = "(type,title,content,restricted,attachment_id,ordered)";
			$values = array();
			$actualval = array();
			$nmb = 0;
			foreach($data[0] as $item){
				$type = $item['type'];
				$title = stripslashes(htmlspecialchars_decode($item['title']));
				$content = stripslashes(htmlspecialchars_decode($item['content']));
				$restricted = json_encode( $item['restricted'] );
				$attachment_id = false;
				$ordered = $item['ordered'];
				$values[] = "( %s, %s, %s, %s, %d, %d )";

				if($type == 'file') $content = json_encode(array( 'filename' => $item['attachment_filename'], 'url' => $item['attachment_url']) );

				array_push( $actualval, $type, $title, $content, $restricted, $attachment_id, $ordered );
				$nmb++;
			}

			$options = false;
			if( isset($data[1]['included']) && $data[1]['included'] ){

				$options = true;
				$opt = $data[1]['data'];

				$set = array('user_role', 'item_per_page', 'label_widget_title', 'label_welcome_title', 'label_welcome_message');

				foreach( $set as $st ){
					if( !empty($opt[$st]) && $st == 'user_role' ) $this->settings[$st] = json_decode($opt[$st]);
					elseif( !empty($opt[$st]) ) $this->settings[$st] = $opt[$st];
				}
				$this->update_settings();
			}


			$query = $wpdb->prepare( "INSERT INTO $wpdb->simpleDocumentation $cols VALUES " . implode( ',', $values ), $actualval );

			if($data = $wpdb->query( $query ))
				$this->s( array( 'status' => 'ok', 'type' => 'get-data', 'data' => array( 'item' => $nmb, 'options' => $options )));
			else
				$this->s( array( 'status' => 'error' ) );

		}

		$this->s(array( 'status' => 'error', 'type' => 'action-not-recognized' ));

	}
}
new simpleDocumentation;
