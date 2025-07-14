<?php
/**
 * The template for displaying tac_gia taxonomy archive
 */

get_header();
?>

<main id="primary" class="site-main">
    <div class="container py-4">
        <header class="page-header mb-4">
            <h1 class="page-title">
                <?php
                $term = get_queried_object();
                printf(
                    esc_html__('Tác giả: %s', 'commicpro'),
                    '<span>' . esc_html($term->name) . '</span>'
                );
                ?>
            </h1>
            <?php if ($term->description) : ?>
                <div class="archive-description">
                    <?php echo wp_kses_post($term->description); ?>
                </div>
            <?php endif; ?>
        </header>

        <div class="row">
            <div class="col-lg-9">
                <div class="row latest-chapter-container">
                    <?php if (have_posts()) : ?>
                        <?php while (have_posts()) : the_post(); ?>
                        <?php get_template_part( 'template-parts/home/item-card' ); ?>
                        <?php endwhile; ?>
        
                        <div class="col-12">
                            <?php custom_pagination(); ?>
                        </div>
        
                    <?php else : ?>
                        <div class="col-12">
                            <p><?php esc_html_e('Không tìm thấy truyện nào của tác giả này.', 'commicpro'); ?></p>
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
get_footer(); 