<?php 
/*
    ===============================
    Custom Post Type
    ===============================
*/    
function wpbook1_register_post_type(){

    $labels = array(
		'name'               => 'book',
		'singular_name'      => 'book',
		'menu_name'          => 'book',
		'add_new'            => 'Add New',
		'add_new_item'       => 'Add New Book',
		'new_item'           => 'New Book',
		'edit_item'          => 'Edit Book',
		'view_item'          => 'View Books',
		'all_items'          => 'All Books',
		'search_items'       => 'Search Books',
		'parent_item_colon'  => '',
		'not_found'          => 'No books found',
		'not_found_in_trash' => 'No books found in Trash'
	);

	$args = array(
		'labels'             => $labels,
		'description'        => 'This is Book post type',
		'public'             => true,
		'publicly_queryable' => true,
		'show_ui'            => true,
		'show_in_menu'       => true,
		'query_var'          => true,
		'rewrite'            => array( 'slug' => 'book' ),
		'capability_type'    => 'post',
		'has_archive'        => true,
		'hierarchical'       => false,
		'menu_position'      => null,
		'supports'           => array( 'title', 'editor', 'author', 'thumbnail', 'excerpt', 'comments' )
	);

    register_post_type( 'book', $args );
}
add_action( 'init', 'wpbook1_register_post_type' );



/*
    ===============================
    Custom Hierarchical Taxonomy Book Category
    ===============================
*/
// create two taxonomies, genres and writers for the post type "book"
function wpbook1_custom_taxonomies() {
	// Add new taxonomy, make it hierarchical (like categories)
	$labels = array(
		'name'              => _x( 'Genres', 'taxonomy general name', 'textdomain' ),
		'singular_name'     => _x( 'Genre', 'taxonomy singular name', 'textdomain' ),
		'search_items'      => __( 'Search Genres', 'textdomain' ),
		'all_items'         => __( 'All Genres', 'textdomain' ),
		'parent_item'       => __( 'Parent Genre', 'textdomain' ),
		'parent_item_colon' => __( 'Parent Genre:', 'textdomain' ),
		'edit_item'         => __( 'Edit Genre', 'textdomain' ),
		'update_item'       => __( 'Update Genre', 'textdomain' ),
		'add_new_item'      => __( 'Add New Genre', 'textdomain' ),
		'new_item_name'     => __( 'New Genre Name', 'textdomain' ),
		'menu_name'         => __( 'Genre', 'textdomain' ),
	);

	$args = array(
		'hierarchical'      => true,
		'labels'            => $labels,
		'show_ui'           => true,
		'show_admin_column' => true,
		'query_var'         => true,
		'rewrite'           => array( 'slug' => 'genre' ),
	);

	register_taxonomy( 'genre', array( 'book' ), $args );


/*
    ===============================
    Custom Non Hierarchical Taxonomy Book Category
    ===============================
*/


	// Add new taxonomy, NOT hierarchical (like tags)
	$labels = array(
		'name'                       => _x( 'Writers', 'taxonomy general name', 'textdomain' ),
		'singular_name'              => _x( 'Writer', 'taxonomy singular name', 'textdomain' ),
		'search_items'               => __( 'Search Writers', 'textdomain' ),
		'popular_items'              => __( 'Popular Writers', 'textdomain' ),
		'all_items'                  => __( 'All Writers', 'textdomain' ),
		'parent_item'                => null,
		'parent_item_colon'          => null,
		'edit_item'                  => __( 'Edit Writer', 'textdomain' ),
		'update_item'                => __( 'Update Writer', 'textdomain' ),
		'add_new_item'               => __( 'Add New Writer', 'textdomain' ),
		'new_item_name'              => __( 'New Writer Name', 'textdomain' ),
		'separate_items_with_commas' => __( 'Separate writers with commas', 'textdomain' ),
		'add_or_remove_items'        => __( 'Add or remove writers', 'textdomain' ),
		'choose_from_most_used'      => __( 'Choose from the most used writers', 'textdomain' ),
		'not_found'                  => __( 'No writers found.', 'textdomain' ),
		'menu_name'                  => __( 'Writers', 'textdomain' ),
	);

	$args = array(
		'hierarchical'          => false,
		'labels'                => $labels,
		'show_ui'               => true,
		'show_admin_column'     => true,
		'update_count_callback' => '_update_post_term_count',
		'query_var'             => true,
		'rewrite'               => array( 'slug' => 'writer' ),
	);

	register_taxonomy( 'writer', 'book', $args );
}
add_action( 'init', 'wpbook1_custom_taxonomies' );



/*
    ===============================
    Custom Meta Boxes
    ===============================
*/

// function wpbook1_register_meta_boxes() {
//     add_meta_box( 'wpbook1-page-id', 'Meta Post', 'wpbook1_pages_function', 'post', 'Normal', 'high');
// }
// add_action('add_meta_boxes', 'wpbook1_register_meta_boxes');

function wpbook1_add_custom_box()
{
	$screens = array('book');
	foreach ($screens as $screen) {
        add_meta_box(
            'wpbook1_box_id',           // Unique ID
            __( 'Custom Meta Box', 'sitepoint' ),  	// Box title
			'wpbook1_custom_box_html1', // Content callback, must be of type callable
			$screen	     // Post type
		);
	}
}
add_action('add_meta_boxes_book', 'wpbook1_add_custom_box');


//callback function (metabox) for custom-post-type 'book'
function wpbook1_custom_box_html1($post)
{
	wp_nonce_field(basename(__FILE__), "wpbook1_cpt_nonce");
    //$value = get_post_meta($post->ID, '_wpbook1_meta_key', true);
    ?>
  	<form>
    	<label for = "textAuthorName">Author Name :</label>
		<?php $author_name = get_post_meta( $post->ID, 'book_publisher_name', true ) ?>
		<input type = "text" name = "textAuthorName" value = <?php echo $author_name ?> placeholder = "write author name">
		</br></br>
		
		<label for = "textPublisherName">Publisher Name :</label>
		<?php $publisher_name = get_post_meta( $post->ID, 'book_publisher_name', true ) ?>
		<input type = "text" name = "textPublisherName" value = " <?php echo $publisher_name ?>" placeholder = "write publisher name">
		</br></br>
		
		<label for = "textEdition">Edition :</label>
		<?php $edition_name = get_post_meta( $post->ID, 'book_publisher_name', true ) ?>
		<input type = "text" name = "textEdition" value = " <?php echo $edition_name ?> placeholder = "Edition">
		</br></br>
		
		<label for = "date">Date :</label>
		<?php $date = get_post_meta( $post->ID, 'book_publisher_name', true ) ?>
		<input type = "date" name = "date" value = "<?php echo $date ?>" placeholder = "Date">
		</br></br>
		
		<label for = "URL">URL :</label>
		<?php $url = get_post_meta( $post->ID, 'book_publisher_name', true ) ?>
		<input type = "url" name = "URL" value = "<?php echo $url ?>" placeholder = "URL">
		</br></br>
		
		<label for = "price">Price :</label>
		<?php $price = get_post_meta( $post->ID, 'book_publisher_name', true ) ?>
		<input type = "text" name = "price" value= "<?php echo $price ?>" placeholder = "Price">

		<!-- <select name="wpbook1_field" id="wpbook1_field" class="postbox">
			<option value="something" <?php //selected($value, 'something'); ?>>Something</option>
			<option value="else" <?php //selected($value, 'else'); ?>>Else</option>
		</select> -->
	</form>
	<?php
}


function wpbook1_save_bookdata($post_id, $post)
{
	//veified nonce
	if( !isset($_POST['wpbook1_cpt_nonce']) || !wp_verify_nonce($_POST['wpbook1_cpt_nonce'], basename(__FILE__)) ){
		return $post_id;
	}

	//verifying slug value
	$post_slug = 'book';
	if( $post_slug != $post->post_type ) {
		return;
	}

	//save publisher value to database field
	$pub_name = '';
	if ( isset( $_POST['textPublisherName'] )){
		$pub_name = sanitize_text_field( $_POST['textPublisherName'] );
	} else{
		$pub_name = '';
	}

	//save author value to database field
	$auth_name = '';
	if ( isset( $_POST['textAuthorName'] )){
		$auth_name = sanitize_text_field( $_POST['textAuthorName'] );
	} else{
		$auth_name = '';
	}

	//save edition value to database field
	$editi = '';
	if ( isset( $_POST['textEdition'] )){
		$editi = sanitize_text_field( $_POST['textEdition'] );
	} else{
		$editi = '';
	}

	//save date & time value to database field
	$date_time = '';
	if ( isset( $_POST['date'] )){
		$date_time = sanitize_text_field( $_POST['date'] );
	} else{
		$date_time = '';
	}
	
	//save url value to database field
	$URL = '';
	if ( isset( $_POST['URL'] )){
		$URL = sanitize_text_field( $_POST['URL'] );
	} else{
		$URL = '';
	}

	//save price value to database field
	$price_1 = '';
	if ( isset( $_POST['price'] )){
		$price_1 = sanitize_text_field( $_POST['price'] );
	} else{
		$price_1 = '';
	}


    //if (array_key_exists('wpbook1_field', $_POST)) {
        update_post_meta(
            $post_id,
            'book_publisher_name',
            $pub_name
        );
    //}
}
add_action('save_post', 'wpbook1_save_bookdata', 10, 2);



//author metabox
function wpbook1_author_custom_box()
{
	$screens = array('book');
	foreach ($screens as $screen) {
        add_meta_box(
            'wpbook1_author_id',           // Unique ID
            __( 'author Meta Box', 'sitepoint' ),  	// Box title
			'wpbook1_author_box_html', // Content callback, must be of type callable
			$screen	     // Post type
		);
	}
}
add_action('add_meta_boxes_book', 'wpbook1_author_custom_box');


function wpbook1_author_box_html($post)
{
	wp_nonce_field(basename(__FILE__), "wpbook1_author_nonce");
    ?>
    <label for="dropDownAuthor">Author Name</label>
    <select name="dropDownAuthor" id="dropDownAuthor">

		<?php
			$post_id = $post->ID;
			$author_id = get_post_meta($post_id, 'book_author_name', true);

			$all_authors = get_users(array('role' => 'author'));
			foreach($all_authors as $index => $author){
				$selected = "";
				if ( $author_id == $author->data->ID ){
					$selected = 'selected="selected"';
				}
				?>
					<option value = "<?php echo $author->data->ID; ?>" <?php echo $selected ?>;  ><?php echo $author->data->display_name ?></option>
				<?php
			}
		?>

    </select>
    <?php
}

function wpbook1_save_author($post_id, $post)
{
	//veified nonce
	if( !isset($_POST['wpbook1_author_nonce']) || !wp_verify_nonce($_POST['wpbook1_author_nonce'], basename(__FILE__)) ){
		return $post_id;
	}

	//verifying slug value
	$post_slug = 'book';
	if( $post_slug != $post->post_type ) {
		return;
	}

	//save value to database field
	$author_name = '';
	if ( isset( $_POST['dropDownAuthor'] )){
		$author_name = sanitize_text_field( $_POST['dropDownAuthor'] );
	} else{
		$author_name = '';
	}

    //if (array_key_exists('wpbook1_field', $_POST)) {
        update_post_meta(
            $post_id,
            'book_author_name',
            $author_name
        );
    //}
}
add_action('save_post', 'wpbook1_save_author', 10, 2);





/**
 * custom option and settings
 */
function wpbook1_settings_init() {
	// register a new setting for "wporg" page
	register_setting( 'wpbook1', 'wpbook1_options' );
	
	// register a new section in the "wporg" page
	add_settings_section(
	'wpbook1_section_developers',
	__( 'The Matrix has you.', 'wpbook1' ),
	'wpbook1_section_developers_cb',
	'wpbook1'
	);
	
	// register a new field in the "wporg_section_developers" section, inside the "wporg" page
	add_settings_field(
	'wpbook1_field_pill', // as of WP 4.6 this value is used only internally
	// use $args' label_for to populate the id inside the callback
	__( 'Pill', 'wpbook1' ),
	'wpbook1_field_pill_cb',
	'wpbook1',
	'wpbook1_section_developers',
	['label_for' => 'wpbook1_field_pill',
	'class' => 'wpbook1_row',
	'wpbook1_custom_data' => 'custom',]
	);
   }
	
   /**
	* register our wporg_settings_init to the admin_init action hook
	*/
   add_action( 'admin_init', 'wpbook1_settings_init' );
	
   /**
	* custom option and settings:
	* callback functions
	*/
	
   // developers section cb
	
   // section callbacks can accept an $args parameter, which is an array.
   // $args have the following keys defined: title, id, callback.
   // the values are defined at the add_settings_section() function.
   function wpbook1_section_developers_cb( $args ) {
	?>
		<p id="<?php echo esc_attr( $args['id'] ); ?>"><?php esc_html_e( 'Follow the white rabbit.', 'wporg' ); ?></p>
	<?php
   }
	
   // pill field cb
	
   // field callbacks can accept an $args parameter, which is an array.
   // $args is defined at the add_settings_field() function.
   // wordpress has magic interaction with the following keys: label_for, class.
   // the "label_for" key value is used for the "for" attribute of the <label>.
   // the "class" key value is used for the "class" attribute of the <tr> containing the field.
   // you can add custom key value pairs to be used inside your callbacks.
   function wpbook1_field_pill_cb( $args ) {
	// get the value of the setting we've registered with register_setting()
		$options = get_option( 'wpbook1_options' );
	// output the field
	?>



	<select id="<?php echo esc_attr( $args['label_for'] ); ?>"
		data-custom="<?php echo esc_attr( $args['wpbook1_custom_data'] ); ?>"
		name="wpbook1_options[<?php echo esc_attr( $args['label_for'] ); ?>]">
		
		

		<option value="red" <?php echo isset( $options[ $args['label_for'] ] ) ? ( selected( $options[ $args['label_for'] ], 'red', false ) ) : ( '' ); ?>>
		<?php esc_html_e( 'red pill', 'wpbook1' ); ?>
		</option>
		
		<option value="blue" <?php echo isset( $options[ $args['label_for'] ] ) ? ( selected( $options[ $args['label_for'] ], 'blue', false ) ) : ( '' ); ?>>
		<?php esc_html_e( 'blue pill', 'wpbook1' ); ?>
		</option>
		
	</select>
	</br>
		
	<p class="description">
	<?php esc_html_e( 'You take the blue pill and the story ends. You wake in your bed and you believe whatever you want to believe.', 'wporg' ); ?>
	</p>	
	
	<p class="description">
	<?php esc_html_e( 'You take the red pill and you stay in Wonderland and I show you how deep the rabbit-hole goes.', 'wporg' ); ?>
	</p>
	</br>
	<div>
		<label for="currency">Currency to pay :</label>
		<input type="text" name="currency" placeholder="currency">
		</br>
		<label for="books">Number of book display per page :</label>
		<input type="text" name="books" placeholder="books">
	</div>

	<?php
   }
	
   /**
	* top level menu
	*/
   function wpbook1_options_page() {
	// add top level menu page
	add_menu_page(
		'wpbook1',
		'wpbook1 Options',
		'manage_options',
		'wpbook1',
		'wpbook1_options_page_html'
		);
   }
	
   /**
	* register our wporg_options_page to the admin_menu action hook
	*/
   add_action( 'admin_menu', 'wpbook1_options_page' );
	
   /**
	* top level menu:
	* callback functions
	*/
   function wpbook1_options_page_html() {
	// check user capabilities
		if ( ! current_user_can( 'manage_options' ) ) {
		return;
	}
	
	// add error/update messages
	
	// check if the user have submitted the settings
	// wordpress will add the "settings-updated" $_GET parameter to the url
	if ( isset( $_GET['settings-updated'] ) ) {
		// add settings saved message with the class of "updated"
		add_settings_error( 'wpbook1_messages', 'wpbook1_message', __( 'Settings Saved', 'wpbook1' ), 'updated' );
	}
	
	// show error/update messages
	settings_errors( 'wpbook1_messages' );
	?>
		<div class="wrap">
		<h1><?php echo esc_html( get_admin_page_title() ); ?></h1>
		<form action="options.php" method="post">
	<?php
	// output security fields for the registered setting "wporg"
	settings_fields( 'wpbook1' );
	// output setting sections and their fields
	// (sections are registered for "wporg", each field is registered to a specific section)
	do_settings_sections( 'wpbook1' );
	// output save settings button
	submit_button( 'Save Settings' );
	?>
	</form>
	</div>
	<?php
   }



/**
 * Adds deshbord wpbook1_Widget widget.
 */

function wpbook1_dashboard_widget(){
	$title = get_option('wpbook1_dashboard_title') ? get_option('wpbook1_dashboard_title') : 'dashboard-widget'; 
	wp_add_dashboard_widget('css-id', $title, 'wpbook1_dashboard_show_widget');
}

function wpbook1_dashboard_show_widget(){

}
add_action('wp_dashboard_setup', 'wpbook1_dashboard_widget');


/**
 * Adds wpbook1_Widget widget.
 */

require_once(plugin_dir_path(__FILE__).'/wp-widget.php');

function register_wpbook1_widget(){
	register_widget('wpbook1_Widget');
}
add_action('widgets_init', 'register_wpbook1_widget');