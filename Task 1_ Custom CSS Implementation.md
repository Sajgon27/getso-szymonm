Before editing anything in theme, I would firstly make sure if child theme is activated, if not I would create it.
The quickest and best way to do it would be to install a plugin, personally i use: "Child Theme Wizard" by Jay Versluis.
After quick setup and activation of the theme i would remove the plugin.

Then in my child theme directory I could put custom css to style.css file.

However the better way would be to enqueue custom styles file with code snippet provided below (code will be placed in functions.php):
```
function enqueue_custom_styles()
{
  wp_enqueue_style('custom-style', get_stylesheet_directory_uri() . '/assets/css/style.css', array(), '1.0', 'all');
}
add_action('wp_enqueue_scripts', 'enqueue_custom_styles');
```

This approach groups code better, if we create an /assets folder and put there all custom styles and scripts.

If there would be a lot, of custom styles to implement we could split the code to more than one file. 
Having them all in /assets/css folder would make our code way more organized and easier to manage.





