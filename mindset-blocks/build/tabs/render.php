<?php
/**
* In an ACF block...
* render.php runs on the front-end AND the back-end editor.
*/
?>
<div <?php echo get_block_wrapper_attributes(); ?>>

    <?php if ( have_rows('tabs') ) : ?>
        <nav role="tablist" id="tabs-block-nav" class="tabs-block-nav">
            <?php 
            $nav_counter = 0;
            while( have_rows('tabs') ) : the_row(); 
                $nav_counter++; 
                ?>
                <button 
                    aria-controls="content-<?php echo $nav_counter; ?>" 
                    id="tab-<?php echo $nav_counter; ?>" 
                    role="tab" aria-selected="true" 
                    class="tab <?php if ($nav_counter === 1) { echo 'current'; } ?>" 
                    <?php 
                    if ($nav_counter === 1) { 
                        echo 'aria-selected="true"';
                    } else { 
                        echo 'aria-selected="false"'; 
                    }
                    ?>
                    >
                    <?php the_sub_field('tab_title'); ?>
                </button>
            <?php endwhile; ?>
        </nav>
    <?php else : ?>
        <p><?php esc_html_e( 'To add tabs, click the pencil icon in the block toolbar or use the sidebar.', 'tabs-block' ); ?></p>
    <?php endif; ?>

    <?php if ( have_rows('tabs') ) : ?>
        <div id="tabs-block-content" aria-live="polite" role="region" class="tab-content-wrapper">
            <?php $content_counter = 0; ?>
            <?php while( have_rows('tabs') ) : the_row(); 
                $content_counter++; ?>
                <article 
                    class="tab-content-item <?php if ($content_counter === 1) { echo 'active'; } ?>" 
                    id="content-<?php echo $content_counter; ?>" 
                    role="tabpanel" 
                    aria-labelledby="tab-<?php echo $content_counter; ?>"
                    >
                    <?php the_sub_field('tab_content'); ?>
                </article>
            <?php endwhile; ?>
        </div>
    <?php endif; ?>

</div>