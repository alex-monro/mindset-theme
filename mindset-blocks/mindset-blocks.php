<?php
/**
 * Registers the block(s) metadata from the `blocks-manifest.php` and registers the block type(s)
 * based on the registered block metadata. Behind the scenes, it registers also all assets so they can be enqueued
 * through the block editor in the corresponding context.
 *
 * @see https://make.wordpress.org/core/2025/03/13/more-efficient-block-type-registration-in-6-8/
 * @see https://make.wordpress.org/core/2024/10/17/new-block-type-registration-apis-to-improve-performance-in-wordpress-6-7/
 */
function mindset_blocks_mindset_blocks_block_init() {
	wp_register_block_types_from_metadata_collection( __DIR__ . '/build', __DIR__ . '/build/blocks-manifest.php' );
}
add_action( 'init', 'mindset_blocks_mindset_blocks_block_init' );

/**
 * Registers the custom fields for some blocks.
 *
 * @see https://developer.wordpress.org/reference/functions/register_post_meta/
 */
function mindset_register_custom_fields() {
	register_post_meta(
		'page',
		'company_email',
		array(
			'type'         => 'string',
			'show_in_rest' => true,
			'single'       => true
		)
	);
	register_post_meta(
		'page',
		'company_address',
		array(
			'type'         => 'string',
			'show_in_rest' => true,
			'single'       => true
		)
	);
}
add_action( 'init', 'mindset_register_custom_fields' );

function mindset_blocks_render_callbacks( $args, $name ) {
    if ( 'mindset-blocks/company-services' === $name ) {
        $args['render_callback'] = 'fwd_render_service_posts';
    }
    return $args;
}
add_filter( 'register_block_type_args', 'mindset_blocks_render_callbacks', 10, 2 );

function fwd_render_service_posts( $attributes ) {
    ob_start();
    ?>
    <div <?php echo get_block_wrapper_attributes(); ?>>
        <?php
        $args = array( 
            'post_type'      => 'fwd-service',
            'posts_per_page' => -1,
            'orderby'        => 'title',
            'order'          => 'ASC'
        );
        
        // FIRST WP_Query - Navigation links (UNCHANGED)
        $query = new WP_Query( $args );
        
        if ( $query->have_posts() ) {
            echo '<nav class="services-nav">';
            while( $query->have_posts() ) {
                $query->the_post();
                $postID = get_the_ID();
                
                echo '<a href="#post-' . $postID . '">' . get_the_title() . '</a>';
            }
            echo '</nav>';
            wp_reset_postdata(); 
        }
        
        // Organized by Service Type taxonomy
        $terms = get_terms( array(
            'taxonomy' => 'fwd-service-type',
        ) );
        
        if ( $terms && ! is_wp_error( $terms ) ) {
            foreach ( $terms as $term ) {
               
                
                $args = array(
                    'post_type'      => 'fwd-service',
                    'posts_per_page' => -1,
                    'orderby'        => 'title',
                    'order'          => 'ASC',
                    'tax_query'      => array(
                        array(
                            'taxonomy' => 'fwd-service-type',
                            'field'    => 'slug',
                            'terms'    => $term->slug,
                        ),
                    ),
                );
                
                $query = new WP_Query( $args );
                
                if ( $query->have_posts() ) {
                    while ( $query->have_posts() ) {
                        $query->the_post();
                        $postID = get_the_ID();
                        
                        echo '<article id="post-' . $postID . '">';
                            echo '<h2>' . get_the_title() . '</h2>';
                            the_post_thumbnail();
                            the_content();
                            if ( get_field( 'starting_price' ) ) {
                                echo '<p>Starting at $'. get_field( 'starting_price' ) .'</p>';
}
                        echo '</article>';
                    }
                    wp_reset_postdata();
                }
            }
        }
        ?>
    </div>
    <?php
    return ob_get_clean();
}