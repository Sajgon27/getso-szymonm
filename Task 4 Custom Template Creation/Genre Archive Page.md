```
<?php
global $wp_query;

// Usually get_header(); should be here, but because of this theme I choose code below
wp_head();
block_template_part('header');

$taxonomy = get_queried_object();
$paged = get_query_var('paged') ? get_query_var('paged') : 1;

$args = array(
    'post_type'      => 'library',
    'tax_query'      => array(
        array(
            'taxonomy' => 'book-genre',
            'field'    => 'slug',
            'terms'    => $taxonomy->slug,
        ),
    ),
    'paged'          => $paged,
    'posts_per_page' => 5,
);

$query = new WP_Query($args);
?>

<main id="site-content" role="main">

    <header class="archive-header">
        <h1 class="archive-title"><?php echo esc_html($taxonomy->name); ?></h1>
    </header>

    <div class="container">
        <div class="books-list">
            <?php if ($query->have_posts()) : ?>
                <?php while ($query->have_posts()) : $query->the_post(); ?>
                    <article class="book-card">
                        <?php if (has_post_thumbnail()) : ?>
                            <a href="<?php the_permalink(); ?>">
                                <?php the_post_thumbnail('medium');
                                ?>
                            </a>
                        <?php endif; ?>

                        <div class="book-card-content">
                            <h3 class="entry-title">
                                <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                            </h3>
                            <!-- EXCERPT STATIC PLACEHOLDER -->
                            <p>Short book excerpt. Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it</p>
                            <a class="btn-primary" href="<?php the_permalink(); ?>">Learn more</a>
                        </div>

                    </article>
                <?php endwhile; ?>
            <?php else : ?>
                <p><?php esc_html_e('No posts found.', 'twentytwentyfivechild'); ?></p>
            <?php endif; ?>
        </div>

        <?php
        // PAGINATION
        echo paginate_links(array(
            'total'   => $query->max_num_pages,
            'current' => max(1, get_query_var('paged')),
            'format'  => 'page/%#%/',
            'type'    => 'list',
        ));
        ?>
    </div>
</main>

<?php
// Footer would be here
?>
```
