CPT registration: 
```
function register_books_cpt() {

  // List of labels based on: https://developer.wordpress.org/reference/functions/get_post_type_labels/
  // Adding __ before label makes it translatable, so fe. work with WPML would be smooth.
  $labels = array(
      'name'                  => __('Books', 'twentytwentyfive'), 
      'singular_name'         => __('Book', 'twentytwentyfive'),
      'add_new_item'          => __('Add New Book', 'twentytwentyfive'),
      'new_item'              => __('New Book', 'twentytwentyfive'),
      'edit_item'             => __('Edit Book', 'twentytwentyfive'),
      'view_item'             => __('View Book', 'twentytwentyfive'),
      'all_items'             => __('All Books', 'twentytwentyfive'),
      'search_items'          => __('Search Books', 'twentytwentyfive'),
  );

  $args = array(
      'labels'             => $labels,
      'public'             => true,
      'has_archive'        => true,
      'rewrite'            => array('slug' => 'library'), // Changing slug
      'show_in_rest'       => true, // Gutenberg
      'supports'           => array('title', 'editor', 'thumbnail', 'excerpt'),   
      'menu_position'      => 2, // Gonna show up higher in admin panel
      'menu_icon'          => 'dashicons-book', //Icon in admin panel
      'taxonomies'         => array('book-genre'), 
  );

  register_post_type('library', $args);
}
add_action('init', 'register_books_cpt');
```

Taxonomy registration:
```
function register_genre_taxonomy() {
  $labels = array(
      'name'              => __('Genres', 'twentytwentyfive'),
      'singular_name'     => __('Genre', 'twentytwentyfive'),
      'all_items'         => __('All Genres', 'twentytwentyfive'),
      'edit_item'         => __('Edit Genre', 'twentytwentyfive'),
      'update_item'       => __('Update Genre', 'twentytwentyfive'),
      'add_new_item'      => __('Add New Genre', 'twentytwentyfive'),
      'new_item_name'     => __('New Genre Name', 'twentytwentyfive'),
      'menu_name'         => __('Genres', 'twentytwentyfive'),
  );

  $args = array(
      'labels'            => $labels,
      'public'            => true,
      'hierarchical'      => true, // Gonna behave like a category
      'show_admin_column' => true, // Shows in admin panel
      'rewrite'           => array('slug' => 'book-genre'), // Changing slug
      'show_in_rest'      => true, // Gutenberg
  );

  register_taxonomy('book-genre', array('library'), $args);
}
add_action('init', 'register_genre_taxonomy');
```
