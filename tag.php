<?php
/**
 * The template for displaying tag archives
 */

get_header();

$tag = get_queried_object();

// Create custom query for truyen_chu posts with this tag
$args = array(
    'post_type' => 'truyen_chu',
    'posts_per_page' => 12,
    'paged' => get_query_var('paged') ? get_query_var('paged') : 1,
    'tax_query' => array(
        array(
            'taxonomy' => 'post_tag',
            'field' => 'term_id',
            'terms' => $tag->term_id,
        ),
    ),
);
$custom_query = new WP_Query($args);
?>

<main id="primary" class="site-main">
    <div class="container py-4">
        <header class="page-header mb-4">
            <h1 class="page-title">
                <?php
                printf(
                    esc_html__('Tag: %s', 'commicpro'),
                    '<span>' . esc_html($tag->name) . '</span>'
                );
                ?>
            </h1>
            <?php if ($tag->description) : ?>
                <div class="archive-description">
                    <?php echo wp_kses_post($tag->description); ?>
                </div>
            <?php endif; ?>
        </header>

        <div class="row">
            <div class="col-lg-9">
                <div class="row">
                    <?php if ($custom_query->have_posts()) : ?>
                        <?php while ($custom_query->have_posts()) : $custom_query->the_post(); ?>
                        <?php get_template_part( 'template-parts/home/item-card' ); ?>
                        <?php endwhile; ?>
        
                        <div class="col-12">
                            <?php
                            // Custom pagination
                            $big = 999999999;
                            echo '<div class="pagination justify-content-center">';
                            echo paginate_links(array(
                                'base' => str_replace($big, '%#%', esc_url(get_pagenum_link($big))),
                                'format' => '?paged=%#%',
                                'current' => max(1, get_query_var('paged')),
                                'total' => $custom_query->max_num_pages,
                                'prev_text' => __('Trước', 'commicpro'),
                                'next_text' => __('Sau', 'commicpro'),
                                'mid_size' => 2
                            ));
                            echo '</div>';
                            ?>
                        </div>
        
                    <?php else : ?>
                        <div class="col-12">
                            <p><?php esc_html_e('Không tìm thấy truyện nào với tag này.', 'commicpro'); ?></p>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
            <div class="col-lg-3">
					<?php get_template_part( 'sidebar' );  ?>
			</div>
        </div>

    </div>
</main>

<?php
wp_reset_postdata();
get_footer(); 