<?

global  $fb_comments_current_comments_template;

$fb_comments_settings = get_option("fb_comments_settings");

ob_start();

$fb_like_url = get_post_meta($post->ID, "fb_comments_like_url", true);

if(strlen($fb_like_url) == 0)
{
    if(is_page())
    {
        switch($fb_comments_settings["like_url_page"])
        {
            case("permalink"):
            {
                $fb_like_url = get_permalink();
                break;
            }
            case("site"):
            {
                $fb_like_url = get_option("site_url");
                break;
            }
            case("custom"):
            {
                $fb_like_url = $fb_comments_settings["like_url_page_custom"];
                break;
            }
        }   
    }
    
    if(is_single())
    {
        switch($fb_comments_settings["like_url_post"])
        {
            case("permalink"):
            {
                $fb_like_url = get_permalink();
                break;
            }
            case("site"):
            {
                $fb_like_url = get_option("site_url");
                break;
            }
            case("custom"):
            {
                $fb_like_url = $fb_comments_settings["like_url_post_custom"];
                break;
            }
        }   
    }
}



?>


<?
if  (
        $fb_comments_settings["show_fb_like"] == "both" ||
        (is_page() && $fb_comments_settings["show_fb_like"] == "pages") ||
        (is_single() && $fb_comments_settings["show_fb_like"] == "posts")
    ):
?>
<fb:like
        href="<? echo $fb_like_url ?>"
        send="<?php echo ($fb_comments_settings['show_fb_send'] == 'both' || (is_page() && $fb_comments_settings['show_fb_send'] == 'pages') || (is_single() && $fb_comments_settings['show_fb_send'] == 'posts')) ? 'true' : 'false' ?>"
        width="<?php echo $fb_comments_settings['like_width'] ?>"
        show_faces="<?php echo $fb_comments_settings['show_faces'] ?>"
        font="<?php echo $fb_comments_settings['like_font'] ?>"
        action="<?php echo $fb_comments_settings['like_verb'] ?>"
        colorscheme="<?php echo $fb_comments_settings['like_color_scheme'] ?>"
></fb:like>
<? endif; ?>
<?

$fb_comments_url = get_post_meta($post->ID, "fb_comments_comments_url", true);

if(strlen($fb_comments_url) == 0)
{
    if(is_page())
    {
        switch($fb_comments_settings["comments_url_page"])
        {
            case("permalink"):
            {
                $fb_comments_url = get_permalink();
                break;
            }
            case("site"):
            {
                $fb_comments_url = get_option("site_url");
                break;
            }
            case("custom"):
            {
                $fb_comments_url = $fb_comments_settings["comments_url_page_custom"];
                break;
            }
        }   
    }
    
    if(is_single())
    {
        switch($fb_comments_settings["comments_url_post"])
        {
            case("permalink"):
            {
                $fb_comments_url = get_permalink();
                break;
            }
            case("site"):
            {
                $fb_comments_url = get_option("site_url");
                break;
            }
            case("custom"):
            {
                $fb_comments_url = $fb_comments_settings["comments_url_post_custom"];
                break;
            }
        }   
    }
}



if  (
        (
            get_post_meta($post->ID, "fb_comments_switch", true) != 'hide'
        )
        and
        (
            get_post_meta($post->ID, "fb_comments_switch", true) == 'show' ||
            $fb_comments_settings["show_fb_comments"] == "both" ||
            (is_page() && $fb_comments_settings["show_fb_comments"] == "pages") ||
            (is_single() && $fb_comments_settings["show_fb_comments"] == "posts")
        )
    ):
?>
<div id="respond">
<fb:comments
            href="<? echo $fb_comments_url ?>"
            num_posts="<?php echo $fb_comments_settings["num_comments"] ?>"
            width="<?php echo $fb_comments_settings["comments_width"] ?>"
            colorscheme="<?php echo $fb_comments_settings["comments_color_scheme"] ?>"
            notify="true"
></fb:comments>
<!--Crawlable Facebook Comments plugin tag-->
<? if(function_exists('load_comments')):
load_comments();
?>
</div>
<? endif; ?>

<? if($fb_comments_settings["include_sdk"] == "true"): ?>
<div id="fb-root"></div>
<script>
window.fbInitQueue = new Array();
window.fbAsyncInit = function() {
for (var i = 0; i < window.fbInitQueue.length; i++){ 
	window.fbInitQueue[i]();
} 
};
//asynchronous loading of SDK
(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) {return;}
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/en_US/all.js#xfbml=1";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));
</script>
<? endif; ?>
<script>
window.fbInitQueue.push(function(){
FB.Event.subscribe('comment.create', function(response) {
    jQuery.post('<? echo get_permalink(); ?>',
                {
                    id : <? the_ID(); ?>,
                    fb_comments_posted : 'true'
                },
                function(data){
                  alert("Comment posted successfully!");
                }
                );  
});
});
</script>
<? endif; ?>
<?

$fb_comments = ob_get_clean();

ob_start();

include($fb_comments_current_comments_template);
        
$wp_comments = ob_get_clean();

if  ('open' == $post->comment_status)
{
    
    switch($fb_comments_settings["wp_comments_position"])
    {
        case("before"):
        {
            if(
                $fb_comments_settings["show_wp_comments"] == "both" ||
                (is_page() && $fb_comments_settings["show_wp_comments"] == "pages") ||
                (is_single() && $fb_comments_settings["show_wp_comments"] == "posts")
            )echo $wp_comments;
            echo $fb_comments;
            break;
        }
        case("after"):
        {
            echo $fb_comments;
            if(
                $fb_comments_settings["show_wp_comments"] == "both" ||
                (is_page() && $fb_comments_settings["show_wp_comments"] == "pages") ||
                (is_single() && $fb_comments_settings["show_wp_comments"] == "posts")
            )echo $wp_comments;
            break;
        }
        case("none"):
        default:
        {
            echo $fb_comments;
            break;
        }        
    }    
}

?>