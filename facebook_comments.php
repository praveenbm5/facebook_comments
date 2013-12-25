<?php
/*
Plugin Name: Facebook Comments with Notification
Plugin URI: http://www.doctle.com/developers/facebook-comments-with-notifications
Description: Plugin for using facebook comments social plugin with custom notifications
Author: Doctle
Version: 1.0
Author URI: http://www.doctle.com/topic/developers
*/
?>
<?

/**
 * Settings Start
 */
	
// create custom plugin settings menu
add_action('admin_menu', 'fb_comments_menu');

function fb_comments_menu() {

	//create new top-level menu
	add_menu_page('FB Comments Settings', 'FB Comments', 'manage_options', __FILE__, 'fb_comments_settings_page',plugins_url('/facebook-logo.png', __FILE__));	
}

//hook to call register settings function
add_action( 'admin_init', 'register_fb_comments_settings' );


function register_fb_comments_settings() {
    
	//register our settings
    register_setting( 'fb_comments_settings_group', 'fb_comments_settings', 'fb_comments_settings_validate' );
}

function fb_comments_settings_page() {
?>
<div class="wrap">
<h2>FB Comments Settings</h2>
<form method="post" action="options.php">
    <?php
    
        settings_fields( 'fb_comments_settings_group' );
        
        $fb_comments_settings = get_option("fb_comments_settings");
        
    ?>
	<p>Include Facebook Sdk:
		<select name="fb_comments_settings[include_sdk]" >
			<option value="true" <?php if($fb_comments_settings['include_sdk'] == 'true')echo "selected" ?> >Yes</option>
			<option value="false" <?php if($fb_comments_settings['include_sdk'] == 'false')echo "selected" ?> >No</option>
		</select>
	</p>
	<p>
		If you are not including the SDK here then you have to make sure that you define
		<code type="javascript">window.fbInitQueue = new Array()</code>
		before including the SDK and in the 'window.fbAsyncInit' function include the following code -
		<code type="javascript">for (var i = 0; i < window.fbInitQueue.length; i++){ window.fbInitQueue[i](); } </code>
	</p>
	<h4>Facebook Like</h4>
	<p>Displays Facebook like after the post/page content before comments are displayed.</p>
    <table class="form-table">
        <tr valign="top">
        <th scope="row">Show Like</th>
        <td>
			<select name="fb_comments_settings[show_fb_like]" >
				<option value="posts" <?php if($fb_comments_settings['show_fb_like'] == 'posts')echo "selected" ?> >On Posts</option>
				<option value="pages" <?php if($fb_comments_settings['show_fb_like'] == 'pages')echo "selected" ?> >On Pages</option>
				<option value="both" <?php if($fb_comments_settings['show_fb_like'] == 'both')echo "selected" ?> >On Posts & Pages</option>
				<option value="none" <?php if($fb_comments_settings['show_fb_like'] == 'none')echo "selected" ?>>Dont Show</option>
			</select>
		</td>
        </tr>
		
		<tr valign="top">
		<th scope="row">Show Send</th>
        <td>
			<select name="fb_comments_settings[show_fb_send]" >
				<option value="posts" <?php if($fb_comments_settings['show_fb_send'] == 'posts')echo "selected" ?> >On Posts</option>
				<option value="pages" <?php if($fb_comments_settings['show_fb_send'] == 'pages')echo "selected" ?> >On Pages</option>
				<option value="both" <?php if($fb_comments_settings['show_fb_send'] == 'both')echo "selected" ?> >On Posts & Pages</option>
				<option value="none" <?php if($fb_comments_settings['show_fb_send'] == 'none')echo "selected" ?>>Dont Show</option>
			</select>
		</td>
        </tr>
		
		<tr valign="top">
		<th scope="row">Post Like URL</th>
        <td>
			<select name="fb_comments_settings[like_url_post]" >
				<option value="permalink" <?php if($fb_comments_settings['like_url_post'] == 'permalink')echo "selected" ?> >Permalink</option>
				<option value="site" <?php if($fb_comments_settings['like_url_post'] == 'site')echo "selected" ?> >Site</option>
				<option value="custom" <?php if($fb_comments_settings['like_url_post'] == 'custom')echo "selected" ?> >Custom</option>
			</select>
			<p>Custom:<input type="text" name="fb_comments_settings[like_url_post_custom]" value="<?php echo $fb_comments_settings['like_url_post_custom']; ?>" /></p>
		</td>
        </tr>
		
		<tr valign="top">
		<th scope="row">Page Like URL</th>
        <td>
			<select name="fb_comments_settings[like_url_page]" >
				<option value="permalink" <?php if($fb_comments_settings['like_url_page'] == 'permalink')echo "selected" ?> >Permalink</option>
				<option value="site" <?php if($fb_comments_settings['like_url_page'] == 'site')echo "selected" ?> >Site</option>
				<option value="custom" <?php if($fb_comments_settings['like_url_page'] == 'custom')echo "selected" ?> >Custom</option>
			</select>
			<p>Custom:<input type="text" name="fb_comments_settings[like_url_page_custom]" value="<?php echo $fb_comments_settings['like_url_page_custom']; ?>" /></p>
		</td>
        </tr>
		
		<tr valign="top">
		<th scope="row">Like Layout</th>
        <td>
			<select name="fb_comments_settings[like_layout]" >
				<option value="standard" <?php if($fb_comments_settings['like_layout'] == 'standard')echo "selected" ?> >Standard</option>
				<option value="button_count" <?php if($fb_comments_settings['like_layout'] == 'button_count')echo "selected" ?> >Button Count</option>
				<option value="box_count" <?php if($fb_comments_settings['like_layout'] == 'box_count')echo "selected" ?> >Box Count</option>
			</select>
		</td>
        </tr>
		
		<tr valign="top">
		<th scope="row">Show Faces</th>
        <td>
			<select name="fb_comments_settings[show_faces]" >
				<option value="true" <?php if($fb_comments_settings['show_faces'] == 'true')echo "selected" ?> >Yes</option>
				<option value="false" <?php if($fb_comments_settings['show_faces'] == 'false')echo "selected" ?> >No</option>
			</select>
		</td>
        </tr>
		
		<tr valign="top">
        <th scope="row">Width (px)</th>
        <td><input type="text" name="fb_comments_settings[like_width]" value="<?php echo $fb_comments_settings['like_width']; ?>" /></td>
        </tr>
		
		<tr valign="top">
		<th scope="row">Verb</th>
        <td>
			<select name="fb_comments_settings[like_verb]" >
				<option value="like" <?php if($fb_comments_settings['like_verb'] == 'like')echo "selected" ?> >Like</option>
				<option value="recommend" <?php if($fb_comments_settings['like_verb'] == 'recommend')echo "selected" ?> >Recommend</option>
			</select>
		</td>
        </tr>
		
		<tr valign="top">
		<th scope="row">Font</th>
        <td>
			<select name="fb_comments_settings[like_font]" >
				<option value="arial" <?php if($fb_comments_settings['like_font'] == 'arial')echo "selected" ?> >arial</option>
				<option value="lucida grande" <?php if($fb_comments_settings['like_font'] == 'lucida grande')echo "selected" ?> >lucida grande</option>
				<option value="segoe ui" <?php if($fb_comments_settings['like_font'] == 'segoe ui')echo "selected" ?> >segoe ui</option>
				<option value="tahoma" <?php if($fb_comments_settings['like_font'] == 'tahoma')echo "selected" ?> >tahoma</option>
				<option value="trebuchet ms" <?php if($fb_comments_settings['like_font'] == 'trebuchet ms')echo "selected" ?> >trebuchet ms</option>
				<option value="verdana" <?php if($fb_comments_settings['like_font'] == 'verdana')echo "selected" ?> >verdana</option>
			</select>
		</td>
        </tr>
		
		<tr valign="top">
		<th scope="row">Color Scheme</th>
        <td>
			<select name="fb_comments_settings[like_color_scheme]" >
				<option value="light" <?php if($fb_comments_settings['like_color_scheme'] == 'light')echo "selected" ?> >Light</option>
				<option value="dark" <?php if($fb_comments_settings['like_color_scheme'] == 'dark')echo "selected" ?> >Dark</option>
			</select>
		</td>
        </tr>
		
		<tr>
			<td colspan="2"><p>For a detailed explanation visit <a href"http://developers.facebook.com/docs/reference/plugins/like/">http://developers.facebook.com/docs/reference/plugins/like/</a></p></td>
		</tr>
		
	</table>
	<hr/>
	<h4>Facebook Comments</h4>
	<p>Displays Facebook Comments after the post/page content and Like if selected above.</p>
    <table class="form-table">
         
		<tr valign="top">
        <th scope="row">Show Comments</th>
        <td>
			<select name="fb_comments_settings[show_fb_comments]" >
				<option value="posts" <?php if($fb_comments_settings['show_fb_comments'] == 'posts')echo "selected" ?> >On Posts</option>
				<option value="pages" <?php if($fb_comments_settings['show_fb_comments'] == 'pages')echo "selected" ?> >On Pages</option>
				<option value="both" <?php if($fb_comments_settings['show_fb_comments'] == 'both')echo "selected" ?> >On Posts & Pages</option>
				<option value="none" <?php if($fb_comments_settings['show_fb_comments'] == 'none')echo "selected" ?>>Dont Show</option>
			</select>
		</td>
        </tr>
		
		<tr valign="top">
		<th scope="row">Post Comments URL</th>
        <td>
			<select name="fb_comments_settings[comments_url_post]" >
				<option value="permalink" <?php if($fb_comments_settings['comments_url_post'] == 'permalink')echo "selected" ?> >Permalink</option>
				<option value="site" <?php if($fb_comments_settings['comments_url_post'] == 'site')echo "selected" ?> >Site</option>
				<option value="custom" <?php if($fb_comments_settings['comments_url_post'] == 'custom')echo "selected" ?> >Custom</option>
			</select>
			<p>Custom:<input type="text" name="fb_comments_settings[comments_url_post_custom]" value="<?php echo $fb_comments_settings['comments_url_post_custom']; ?>" /></p>
		</td>
        </tr>
		
		<tr valign="top">
		<th scope="row">Post Comment Notification Email</th>
        <td>
			<select name="fb_comments_settings[comments_notification_post]" >
				<option value="author" <?php if($fb_comments_settings['comments_notification_post'] == 'author')echo "selected" ?> >Author</option>
				<option value="admin" <?php if($fb_comments_settings['comments_notification_post'] == 'admin')echo "selected" ?> >Admin</option>
				<option value="custom" <?php if($fb_comments_settings['comments_notification_post'] == 'custom')echo "selected" ?> >Custom</option>
			</select>
			<p>Custom:<input type="text" name="fb_comments_settings[comments_notification_post_custom]" value="<?php echo $fb_comments_settings['comments_notification_post_custom']; ?>" /></p>
		</td>
        </tr>
		
		<tr valign="top">
		<th scope="row">Page Comments URL</th>
        <td>
			<select name="fb_comments_settings[comments_url_page]" >
				<option value="permalink" <?php if($fb_comments_settings['comments_url_page'] == 'permalink')echo "selected" ?> >Permalink</option>
				<option value="site" <?php if($fb_comments_settings['comments_url_page'] == 'site')echo "selected" ?> >Site</option>
				<option value="custom" <?php if($fb_comments_settings['comments_url_page'] == 'custom')echo "selected" ?> >Custom</option>
			</select>
			<p>Custom:<input type="text" name="fb_comments_settings[comments_url_page_custom]" value="<?php echo $fb_comments_settings['comments_url_page_custom']; ?>" /></p>
		</td>
        </tr>
		
		<tr valign="top">
		<th scope="row">Page Comment Notification Email</th>
        <td>
			<select name="fb_comments_settings[comments_notification_page]" >
				<option value="author" <?php if($fb_comments_settings['comments_notification_page'] == 'author')echo "selected" ?> >Author</option>
				<option value="admin" <?php if($fb_comments_settings['comments_notification_page'] == 'admin')echo "selected" ?> >admin</option>
				<option value="custom" <?php if($fb_comments_settings['comments_notification_page'] == 'custom')echo "selected" ?> >Custom</option>
			</select>
			<p>Custom:<input type="text" name="fb_comments_settings[comments_notification_page_custom]" value="<?php echo $fb_comments_settings['comments_notification_page_custom']; ?>" /></p>
		</td>
        </tr>
		
		<tr valign="top">
        <th scope="row">Comment Count</th>
        <td><input type="text" name="fb_comments_settings[num_comments]" value="<?php echo $fb_comments_settings['num_comments']; ?>" /></td>
        </tr>
		
        <tr valign="top">
        <th scope="row">Width (px)</th>
        <td><input type="text" name="fb_comments_settings[comments_width]" value="<?php echo $fb_comments_settings['comments_width']; ?>" /></td>
        </tr>
		
		<tr valign="top">
		<th scope="row">Color Scheme</th>
        <td>
			<select name="fb_comments_settings[comments_color_scheme]" >
				<option value="light" <?php if($fb_comments_settings['comments_color_scheme'] == 'light')echo "selected" ?> >Light</option>
				<option value="dark" <?php if($fb_comments_settings['comments_color_scheme'] == 'dark')echo "selected" ?> >Dark</option>
			</select>
		</td>
        </tr>
		
		<tr>
			<td colspan="2"><p>For a detailed explanation visit <a href"http://developers.facebook.com/docs/reference/plugins/comments/">http://developers.facebook.com/docs/reference/plugins/comments/</a></p></td>
		</tr>
		
		</table>
	<hr/>
	<h4>Wordpress Comments</h4>
	<p>Displays Wordpress Comments after the post/page content.</p>
    <table class="form-table">
        
        <tr valign="top">
        <th scope="row">Show Comments</th>
        <td>
			<select name="fb_comments_settings[show_wp_comments]" >
				<option value="posts" <?php if($fb_comments_settings['show_wp_comments'] == 'posts')echo "selected" ?> >On Posts</option>
				<option value="pages" <?php if($fb_comments_settings['show_wp_comments'] == 'pages')echo "selected" ?> >On Pages</option>
				<option value="both" <?php if($fb_comments_settings['show_wp_comments'] == 'both')echo "selected" ?> >On Posts & Pages</option>
				<option value="none" <?php if($fb_comments_settings['show_wp_comments'] == 'none')echo "selected" ?>>Dont Show</option>
			</select>
		</td>
        </tr>
		
		<tr valign="top">
        <th scope="row">Position</th>
        <td>
			<select name="fb_comments_settings[wp_comments_position]" >
				<option value="before" <?php if($fb_comments_settings['wp_comments_position'] == 'before')echo "selected" ?> >Before FB Comments</option>
				<option value="after" <?php if($fb_comments_settings['wp_comments_position'] == 'after')echo "selected" ?> >After FB Comments</option>
			</select>
		</td>
        </tr>
		
    </table>
    
    <p class="submit">
    <input type="submit" class="button-primary" value="<?php _e('Save Changes') ?>" />
    </p>

</form>
</div>
<?php
}

function fb_comments_settings_validate($input)
{
    //TODO: validate inut data
    return $input;
}

// Post / Page Meta Boxes

add_action( 'add_meta_boxes', 'fb_comments_add_meta_box' );

function fb_comments_add_meta_box(){
	add_meta_box( 
        'fb_comments',
        __( 'Facebook Comments Settings', 'fb_comments' ),
        'fb_comments_print_meta_box',
        'post' 
    );
    add_meta_box(
        'fb_comments',
        __( 'Facebook Comments Settings', 'fb_comments' ), 
        'fb_comments_print_meta_box',
        'page'
    );
}


/* Prints the box content */
function fb_comments_print_meta_box( $post ) {

	// Use nonce for verification
	wp_nonce_field( plugin_basename( __FILE__ ), 'myplugin_noncename' );
  
	// The actual fields for data entry
	?>
	<p>These values take precedence over any values specified in the <b>Settings</b> Page</p>
	<table cellpadding="10">
		<caption></caption>
		<tbody>
		<tr>
			<td>
				<label for="fb_comments_switch"><? _e("Show FB Comments", 'fb_comments' ); ?>:</label>
			</td>
			<td>
				<? $fb_comments_switch = get_post_meta($post->ID, "fb_comments_switch", true); ?>
				<select name="fb_comments_switch" id="fb_comments_switch">
				    <option value="" <?php selected( $fb_comments_switch, '' ); ?>><?php _e( 'Default', 'fb_comments' )?></option>
				    <option value="show" <?php selected( $fb_comments_switch, 'show' ); ?>><?php _e( 'Show', 'fb_comments' )?></option>
				    <option value="hide" <?php selected( $fb_comments_switch, 'hide' ); ?>><?php _e( 'Hide', 'fb_comments' )?></option>
				</select><br>
			</td>
		</tr>
		<tr>
			<td>
				<label for="fb_comments_like_url"><? _e("FB Like URL", 'fb_comments' ); ?>:</label>
			</td>
			<td>
				<input type="text" id="fb_comments_like_url" name="fb_comments_like_url" value="<? echo get_post_meta($post->ID, "fb_comments_like_url", true) ?>" size="75" /><br>
			</td>
		</tr>
		<tr>
			<td>
				<label for="fb_comments_comments_url"><? _e("FB Comments URL", 'fb_comments' ); ?>:</label>
			</td>
			<td>
				<input type="text" id="fb_comments_comments_url" name="fb_comments_comments_url" value="<? echo get_post_meta($post->ID, "fb_comments_comments_url", true) ?>" size="75" /><br>
			</td>
		</tr>
		<tr>
			<td>
				<label for="fb_comments_notification_email"><? _e("FB Notification Email", 'fb_comments' ); ?>:</label>
			</td>
			<td>
				<input type="text" id="fb_comments_notification_email" name="fb_comments_notification_email" value="<? echo get_post_meta($post->ID, "fb_comments_notification_email", true) ?>" size="75" /><br>
			</td>
		</tr>
		</tbody>
	</table>
	<?
}

/**
 * Settings End
 */

/**
 * Plugin Core Begin
 */

//for ajax callback when a new comment is posted
wp_enqueue_script("jquery");

add_filter('comments_template', 'plugin_hook_theme_comments');

function plugin_hook_theme_comments($file) {
    
    global $fb_comments_current_comments_template;

	$fb_comments_current_comments_template =  $file;
    
    $file = dirname(__FILE__)."/facebook_comments_template.php";

	return $file;
}

// Ajax callback for comments

add_action('init', 'fb_comments_callback');

function fb_comments_callback()
{
	if($_REQUEST["fb_comments_posted"] == "true")
	{
		global $post;
		$post = get_post($_REQUEST["id"]);
		
		if($post)
		{
			$fb_comments_settings = get_option("fb_comments_settings");
		
			$mail = "";
			$mail .= "Post/Page: ".$post->post_title."\r\n";
			$mail .= "URL: ".get_permalink($post->ID)."\r\n";
			
			$to = get_post_meta($post->ID, "fb_comments_notification_email", true);
			
			if(strlen($to) == 0)
			{
				if($post->post_type == "post")
				{
					switch($fb_comments_settings["comments_notification_post"])
					{
						case("custom"):
						{
							$to = $fb_comments_settings["comments_notification_post_custom"];
							break;
						}
						
						case("author"):
						{
							$to = get_the_author_meta("user_email", $post->post_author);
							break;
						}
						
						default:
						case("admin"):
						{
							$to = get_option("admin_email");
							break;
						}
					}
				}
				
				if($post->post_type == "page")
				{
					switch($fb_comments_settings["comments_notification_page"])
					{
						case("custom"):
						{
							$to = $fb_comments_settings["comments_notification_page_custom"];
							break;
						}
						
						case("author"):
						{
							$to = get_the_author_meta("user_email", $post->post_author);
							break;
						}
						
						default:
						case("admin"):
						{
							$to = get_option("admin_email");
							break;
						}
					}
				}
			}
			
			wp_mail($to, get_bloginfo()." : New Comment : ".$post->post_title, $mail);
		}	
		
		die(); // this is required to return a proper result
	}	
}

/* Save Post Meta Box Data */
add_action( 'save_post', 'fb_comments_save_postdata' );

/* When the post is saved, saves our custom data */
function fb_comments_save_postdata( $post_id ) {
  // verify if this is an auto save routine. 
  // If it is our form has not been submitted, so we dont want to do anything
  if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) 
      return;

  // verify this came from the our screen and with proper authorization,
  // because save_post can be triggered at other times

  if ( !wp_verify_nonce( $_POST['myplugin_noncename'], plugin_basename( __FILE__ ) ) )
      return;

  
  // Check permissions
  if ( 'page' == $_POST['post_type'] ) 
  {
    if ( !current_user_can( 'edit_page', $post_id ) )
        return;
  }
  else
  {
    if ( !current_user_can( 'edit_post', $post_id ) )
        return;
  }

  // OK, we're authenticated: we need to find and save the data

  update_post_meta($post_id, "fb_comments_switch" , trim($_REQUEST["fb_comments_switch"]));
  update_post_meta($post_id, "fb_comments_like_url" , trim($_REQUEST["fb_comments_like_url"]));
  update_post_meta($post_id, "fb_comments_comments_url" , trim($_REQUEST["fb_comments_comments_url"]));
  update_post_meta($post_id, "fb_comments_notification_email" , trim($_REQUEST["fb_comments_notification_email"]));

}

?>
