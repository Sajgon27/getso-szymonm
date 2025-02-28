Most Recent Book Title shortcode <br>
In this shortocde we need to do simple query, to retive first title of 'library' post_type.
After that need to ensure we got a result, if all good we can return the title of a book,
if no return a message, that no books were found.

URL: https://getso.smdweb.pl/recent-book-title/ <br>
Full code:
```
function recent_book_title_shortcode () {
    $args = array(
        'post_type' => 'library',
        'orderby' => 'date',
        'order' => 'DESC',
        'posts_per_page' => 1,
    );
    $query = new WP_Query($args);
    
    
    if($query->have_posts()) {
    
        $query->the_post();
        $title = get_the_title(); 
        wp_reset_postdata(); 
        return esc_html($title); // Its good to escape inputs in WordPress
    } 
    return __('No books', 'twentytwentyfive');

}
add_shortcode( 'recent_book_title', 'recent_book_title_shortcode');
```

Genre-Specific Book List <br>
In this shortocde there is little more complicated query to execute. 
Main difference is that we are passing attribute, based on which books from certain
genre would be returned.

URL: https://getso.smdweb.pl/genre-specific-book-list/ <br>
Full code:
```
function genre_specific_list_shortcode ($atts) {

     // Extract the 'genre' attribute from the shortcode
     $atts = shortcode_atts(array(
        'genre' => '', 
    ), $atts);
    
    // If no genre ID is provided, return an error message
    if (empty($atts['genre'])) {
        return __('Bad ID', 'twentytwentyfivechild');
    }

    // Query arguments
    $args = array(
        'post_type'      => 'library',  
        'posts_per_page' => 5,
        'orderby'        => 'title',
        'order'          => 'ASC',
        'tax_query'      => array(
            array(
                'taxonomy' => 'book-genre',
                'field'    => 'term_id',
                'terms'    => intval($atts['genre']),
            ),
        ),
    );
    $query = new WP_Query($args);

    // Display content
    if ($query->have_posts()) {
        $output = '<ul>';
        while ($query->have_posts()) {
            $query->the_post();
            $output .= '<li><a href="' . get_permalink() . '">' . esc_html(get_the_title()) . '</a></li>';
        }
        $output .= '</ul>';
        wp_reset_postdata();
    } else {
        $output = __('No books .', 'twentytwentyfivechild');
    }
    return $output;
}
add_shortcode( 'genre_specific_list', 'genre_specific_list_shortcode');
```
