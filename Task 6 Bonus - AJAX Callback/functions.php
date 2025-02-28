function enqueue_ajax_scripts() {
  wp_enqueue_script('custom-ajax-script', get_stylesheet_directory_uri() . '/assets/js/scripts.js', array('jquery'), null, true);
  
  // If we want to use AJAX, we need to extend our function from step 2 to include AJAX URL and nonce.
  wp_localize_script('custom-ajax-script', 'ajax_object', array(
      'ajax_url' => admin_url('admin-ajax.php'),
      'nonce'    => wp_create_nonce('fetch_books_nonce'),
  ));
}
add_action('wp_enqueue_scripts', 'enqueue_ajax_scripts');


function fetch_books_ajax() {
  // Verify nonce for security
  check_ajax_referer('fetch_books_nonce', 'nonce');


  $args = array(
      'post_type'      => 'library', 
      'posts_per_page' => 20,
      'orderby'        => 'date',
      'order'          => 'DESC',
  );

  $query = new WP_Query($args);
  $books = array();

  if ($query->have_posts()) {
      while ($query->have_posts()) {
          $query->the_post();
          
          // Get genre name
          $genres = get_the_terms(get_the_ID(), 'book-genre');
          $genre_names = !empty($genres) ? wp_list_pluck($genres, 'name') : array();

          // Get book information
          $books[] = array(
              'name'    => get_the_title(),
              'date'    => get_the_date('Y-m-d'),
              'genre'   => implode(', ', $genre_names), 
              'excerpt' => get_the_excerpt(),
          );
      }
      wp_reset_postdata();
  }

  // Return JSON response
  wp_send_json_success($books);
}

// Register AJAX actions for both logged-in and guest users
add_action('wp_ajax_fetch_books', 'fetch_books_ajax');
add_action('wp_ajax_nopriv_fetch_books', 'fetch_books_ajax');
