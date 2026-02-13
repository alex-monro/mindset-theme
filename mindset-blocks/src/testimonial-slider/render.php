<?php
/**
 * PHP file to use when rendering the block type on the server to show on the front end.
 *
 * The following variables are exposed to the file:
 *     $attributes (array): The block attributes.
 *     $content (string): The block default content.
 *     $block (WP_Block): The block instance.
 *
 * @see https://github.com/WordPress/gutenberg/blob/trunk/docs/reference-guides/block-api/block-metadata.md#render
 */
?>
<?php
$swiper_settings = array(
    'pagination' => $attributes['pagination'],
    'navigation' => $attributes['navigation'],
);
 $styles = "--arrow-color: " . $attributes['arrowColor'];
?>
<div <?php echo get_block_wrapper_attributes( array( 'style' => $styles ) ); ?>>
    <script>
        const swiper_settings = <?php echo json_encode( $swiper_settings ); ?>;
    </script>
    <?php
    $args = array(
        'post_type'      => 'fwd-testimonial',
        'posts_per_page' => -1
    );
    $query = new WP_Query( $args );
    if ( $query->have_posts() ) : ?>
        <div class="swiper">
            <div class="swiper-wrapper">
                <?php while ( $query->have_posts() ) : $query->the_post(); ?>
                    <div class="swiper-slide">
                        <?php the_content(); ?>
                    </div>
                <?php endwhile; ?>
            </div>
        </div>
        <?php if ( $attributes['pagination'] ) : ?>
            <div class="swiper-pagination"></div>
        <?php endif; ?>
        <?php if ( $attributes['navigation'] ) : ?>
            <button class="swiper-button-prev"></button>
            <button class="swiper-button-next"></button>
        <?php endif; ?>
        <?php
        wp_reset_postdata();
    endif;
    ?>
</div>