<?php
/*
  * Template name: Info
  */

get_header();

?>

<div class="content">

    <?php


    if (have_posts()) :

        while (have_posts()) : the_post();

    ?>

            <div id="post-<?php the_ID(); ?>" <?php post_class('single post'); ?>>

                <?php

                $post_format = get_post_format();

                if ($post_format == 'gallery') : ?>

                    <div class="featured-media">

                        <?php rams_flexslider('post-image'); ?>

                    </div><!-- .featured-media -->

                <?php elseif (has_post_thumbnail()) : ?>

                    <div class="featured-media">

                        <?php the_post_thumbnail('post-image'); ?>

                    </div><!-- .featured-media -->

                <?php endif; ?>

                <div class="post-inner">
                    <div class="row">
                        <div class="col-sm-4">

                        </div>
                        <div class="col-sm-4">

                        </div>
                        <div class="col-sm-4 text">
                            <a href="<?php echo get_page_link(15); ?>">
                                <div class="headLink text-right"> Aanbod</div>
                            </a>
                            <div class="headLink text-right"> |</div>
                            <a class="blog-logo" href='<?php echo site_url('/wat-zijn-keuzedelen/'); ?>' title='<?php echo esc_attr(get_bloginfo('title')); ?> &mdash; <?php echo esc_attr(get_bloginfo('description')); ?>' rel='home'>
                                <div class="headLink text-right">Info</div>
                            </a>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-8" style="padding-left:7%;padding-right:7%;">
                            <?php if (is_single()) : ?>

                                <p class="post-date"><a href="<?php the_permalink(); ?>" title="<?php the_time('h:i'); ?>"><?php the_time(get_option('date_format')); ?></a>
                                </p>

                            <?php endif; ?>

                            <?php the_title('<h1 class="post-title">', '</h1>'); ?>

                            <div class="post-content">

                                <?php the_content(); ?>

                            </div><!-- .post-content -->

                            <div class="clear"></div>
                        </div>
                        <div class="col-sm-4">
                            <row class="row">
                                <a href="<?php echo get_page_link(45); ?>">
                                    <div class="text-center rightSidebar col-sm-12">
                                        <div style="position: relative; float: left; top: 50%; left: 50%; transform: translate(-50%, -50%);">
                                            Wat zijn keuzedelen?
                                        </div>
                                    </div>
                                </a>
                                <a href="<?php echo get_page_link(47); ?>">
                                    <div class="text-center rightSidebar col-sm-12">
                                        <div style="position: relative; float: left; top: 50%; left: 50%; transform: translate(-50%, -50%);">
                                            Uit welk aanbod kan ik kiezen?
                                        </div>
                                    </div>
                                </a>
                                <a href="<?php echo get_page_link(55); ?>">
                                    <div class="text-center rightSidebar col-sm-12">
                                        <div style="position: relative; float: left; top: 50%; left: 50%; transform: translate(-50%, -50%);">
                                            Hoeveel keuzedelen moet ik volgen?
                                        </div>
                                    </div>
                                </a>
                                <a href="<?php echo get_page_link(59); ?>">
                                    <div class="text-center rightSidebar col-sm-12">
                                        <div style="position: relative; float: left; top: 50%; left: 50%; transform: translate(-50%, -50%);">
                                            Keuzedelen en vrijstellingen
                                        </div>
                                    </div>
                                </a>
                                <a href="<?php echo get_page_link(57); ?>">
                                    <div class="text-center rightSidebar col-sm-12">
                                        <div style="position: relative; float: left; top: 50%; left: 50%; transform: translate(-50%, -50%);">
                                            Keuzedelen en examinering
                                        </div>
                                    </div>
                                </a>
                                
                            </row>
                        </div>
                    </div>
                </div><!-- .post-inner -->

                <?php
                $args = array(
                    'before' => '<div class="clear"></div><p class="page-links"><span class="title">' . __('Pages:', 'rams') . '</span>',
                    'after' => '</p>',
                    'link_before' => '<span>',
                    'link_after' => '</span>',
                    'separator' => '',
                    'pagelink' => '%',
                    'echo' => 1
                );

                wp_link_pages($args);
                ?>

                <?php if (is_single()) : ?>

                    <div class="post-meta">

                        <a class="post-meta-toggle" href="#" title="<?php _e('Show information about the post', 'rams'); ?>">

                            <div class="post-meta-toggle-inner">

                                <div class="bars">
                                    <div class="bar"></div>
                                    <div class="bar"></div>
                                    <div class="bar"></div>
                                </div>

                                <p><?php _e('Post meta', 'rams'); ?></p>

                                <div class="clear"></div>

                            </div>

                        </a><!-- .post-meta-toggle -->

                        <div class="post-meta-inner">

                            <p><strong><?php _e('Author', 'rams'); ?></strong><?php the_author_posts_link(); ?></p>

                            <p class="post-meta-date"><strong><?php _e('Posted', 'rams'); ?></strong><a href="<?php the_permalink(); ?>"><?php the_date(get_option('date_format')); ?>
                                    <span> &mdash; <?php the_time(get_option('time_format')); ?></span></a></p>

                            <?php if (has_category()) : ?>

                                <p><strong><?php _e('Categories', 'rams'); ?></strong><?php the_category(', '); ?>
                                </p>

                            <?php endif; ?>

                            <?php if (has_tag()) : ?>

                                <p><strong><?php _e('Tags', 'rams'); ?></strong><?php the_tags('', ', '); ?></p>

                            <?php endif;

                            $prev_post = get_previous_post();
                            $next_post = get_next_post();

                            if (!empty($next_post) || !empty($prev_post)) : ?>

                                <div class="post-nav">

                                    <?php
                                    if (!empty($next_post)) : ?>

                                        <p>
                                            <strong><?php _e('Next', 'rams'); ?></strong>
                                            <a class="post-nav-newer" title="<?php _e('Next post', 'rams');
                                                                                echo ': ' . get_the_title($next_post); ?>" href="<?php echo get_permalink($next_post->ID); ?>">
                                                <?php echo get_the_title($next_post); ?>
                                            </a>
                                        </p>

                                    <?php endif;

                                    if (!empty($prev_post)) : ?>

                                        <p>
                                            <strong><?php _e('Previous', 'rams'); ?></strong>
                                            <a class="post-nav-older" title="<?php _e('Previous post', 'rams');
                                                                                echo ': ' . get_the_title($prev_post); ?>" href="<?php echo get_permalink($prev_post->ID); ?>">
                                                <?php echo get_the_title($prev_post); ?>
                                            </a>
                                        </p>

                                    <?php endif; ?>

                                    <div class="clear"></div>

                                </div><!-- .post-nav -->

                            <?php endif; ?>

                        </div><!-- .post-meta-inner -->

                    </div><!-- .post-meta -->

                <?php endif; ?>

            </div><!-- .post -->

            <?php if (is_single() || !is_single() && comments_open()) : ?>

                <div class="comments-container">

                    <?php comments_template('', true); ?>

                </div><!-- .comments-container -->

    <?php
            endif;

        endwhile;

    endif; ?>

</div><!-- .content -->

<?php get_footer(); ?>
