Template can be visible at: 

```
<?php
/* Template Name: Single Book */

// Usually get_header(); should be here, but because of this theme I choose code below
wp_head();
block_template_part('header');
?>

<main>
    <div class="container">
        <?php while (have_posts()) : the_post(); ?>
            <article class="single-book" <?php post_class(); ?>>
                <div class="single-book-cover">
                    <?php if (has_post_thumbnail()) : ?>
                        <?php the_post_thumbnail('large'); ?>
                    <?php endif; ?>
                </div>
                <div class="single-book-info">
                    <h1><?php the_title(); ?></h1>
                    <div class="book-meta">
                        <p><strong><?php _e('Published on:', 'twentytwentyfive'); ?></strong> <?php echo get_the_date(); ?></p>
                        <p><strong><?php _e('Genre:', 'twentytwentyfive'); ?></strong>
                            <?php
                            $terms = get_the_terms(get_the_ID(), 'book-genre');
                            if ($terms && !is_wp_error($terms)) {
                                $genres = array();
                                foreach ($terms as $term) {
                                    $genres[] = '<a href="' . get_term_link($term) . '">' . esc_html($term->name) . '</a>';
                                }
                                echo implode(', ', $genres);
                            } else {
                                _e('No Genre Assigned', 'twentytwentyfive');
                            }
                            ?>
                        </p>
                    </div>
                </div>
            </article>
        <?php endwhile; ?>
    </div>
</main>

<?php
// Footer would be here
?>
```
