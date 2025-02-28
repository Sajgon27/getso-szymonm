Similiarry to CSS script we could add custom js to our theme using such snippet:

```
function enqueue_custom_scripts() {
    wp_enqueue_script(
        'custom-script', 
        get_stylesheet_directory_uri() . '/assets/js/scripts.js',
        array('jquery'),
        '1.0', 
        true
    );
}
add_action('wp_enqueue_scripts', 'enqueue_custom_scripts');
```

Code should be put in /assets/js for better organization, "true" argument at the end ensures the script would be loaded in footer.
