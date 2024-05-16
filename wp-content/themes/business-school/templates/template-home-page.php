<?php
/**
 * The Template Name: Home Page
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site will use a
 * different template.
 *
 * @package Business School
 */

get_header(); ?>

<div id="content" >

    <?php
    $business_school_sliderhidepage = get_theme_mod('business_school_slider', false);
    $business_school_catData = get_theme_mod('business_school_slider_cat');

    if ($business_school_sliderhidepage && $business_school_catData) { ?>
        <section id="slider-cat">
            <div class="slideimg">
                <div class="container sliderbox">
                    <div class="owl-carousel m-0">
                        <?php
                        $business_school_page_query = new WP_Query(
                            array(
                                'category_name' => esc_attr($business_school_catData),
                                'posts_per_page' => -1, 
                            )
                        );
                        while ($business_school_page_query->have_posts()) : $business_school_page_query->the_post(); ?>
                            <div class="row">
                                <div class="col-lg-7 col-md-6 mb-md-5 mb-2 align-self-center">
                                    <div class="text-content">
                                        <?php if(get_theme_mod('business_school_slider_top_text') != ''){ ?>
                                            <p class="slider-text mb-lg-2 mb-0"><?php echo esc_html(get_theme_mod('business_school_slider_top_text')); ?></p>
                                        <?php }?>
                                        <h1 class="my-lg-2">
                                            <a href="href=<?php the_permalink(); ?>">
                                            <?php 
                                            $title = get_the_title();
                                            $words = explode(' ', $title);
                                            $last_word_index = count($words) - 1; 
                                            $last_word = $words[$last_word_index]; 
                                            unset($words[$last_word_index]); 
                                            $remaining_words = implode(' ', $words);
                                            echo esc_html($remaining_words); 
                                            echo ' <span style="color: #0D5EF4;">' . esc_html($last_word) . '</span>'; 
                                            ?>
                                            </a>
                                        </h1>
                                        <?php
                                        $business_school_trimexcerpt  = get_the_excerpt();
                                        $business_school_shortexcerpt = wp_trim_words($business_school_trimexcerpt, $num_words = 45);
                                        echo '<p class="slider-content mt-3">' . esc_html($business_school_shortexcerpt) . '</p>';
                                        ?>
                                        <div class="sliderbtn mt-lg-4">
                                            <?php 
                                            $business_school_button_text = get_theme_mod('business_school_button_text', 'Get Started');
                                            $business_school_button_link = get_theme_mod('business_school_button_link_slider', ''); 
                                            if (empty($business_school_button_link)) {
                                                $business_school_button_link = get_permalink();
                                            }
                                            if (!empty($business_school_button_text) || !empty($business_school_button_link)) { ?>
                                                <?php if (get_theme_mod('business_school_button_text', 'Get Started') != '') { ?>
                                                    <div class="slide-btn">
                                                        <a href="<?php echo esc_url($business_school_button_link); ?>">
                                                            <?php echo esc_html($business_school_button_text); ?>
                                                            <span class="screen-reader-text"><?php echo esc_html($business_school_button_text); ?></span>
                                                        </a>
                                                    </div>
                                                <?php } ?>
                                            <?php } ?>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-5 col-md-6 mb-5 slidercircle align-self-center">
                                    <div class="imagebox">
                                        <?php
                                        if (has_post_thumbnail()) {
                                            the_post_thumbnail();
                                        } else {
                                            echo '<div class="slider-img-color"></div>';
                                        }
                                        ?>
                                    </div>
                                </div>
                            </div>
                        <?php endwhile;
                        wp_reset_postdata();
                        ?>
                    </div>
                </div>
            </div>
        </section>
    <?php } ?>

    <?php
    $business_school_hidepageboxes = get_theme_mod('business_school_disabled_pgboxes', false);
    $business_school_about_pageboxes = get_theme_mod('business_school_about_pageboxes', false);
    if ($business_school_hidepageboxes && $business_school_about_pageboxes) { ?>
        <div id="about_section" class="pt-5">
            <div class="container">
                <?php
                if (get_theme_mod('business_school_about_pageboxes', false)) {
                    $business_school_querymed = new WP_Query('page_id=' . esc_attr(get_theme_mod('business_school_about_pageboxes', false)));
                    while ($business_school_querymed->have_posts()) : $business_school_querymed->the_post(); ?>
                        <div class="row">

                            <div class="col-lg-6 col-md-6 align-self-center about-featured mb-md-0 mb-5">
                                <div class="row">
                                    <div class="col-lg-2 col-md-2 col-2 abt-firstimg">
                                        <?php if (get_theme_mod('business_school_abt_image_first') != '') { ?>
                                            <img src="<?php echo esc_url(get_theme_mod('business_school_abt_image_first')); ?>" alt="" />
                                        <?php } ?>
                                    </div>
                                    <div class="col-lg-7 col-md-7 col-7 mb-7 align-self-center abt-col1">
                                        <?php if (has_post_thumbnail()) : ?>
                                            <div class="thumbbx">
                                                <?php the_post_thumbnail('full'); ?>
                                            </div>
                                        <?php else : ?>
                                            <div class="post-color"></div>
                                        <?php endif; ?>
                                    </div>
                                    <div class="col-lg-3 col-md-3 col-3 abt-secimg">
                                        <?php if (get_theme_mod('business_school_abt_image_second') != '') { ?>
                                            <img src="<?php echo esc_url(get_theme_mod('business_school_abt_image_second')); ?>" alt="" />
                                        <?php } ?>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6 align-self-center abt-image abt-col2 px-md-0 px-3 mt-md-0 mt-5">
                                <div class="text-inner-box">
                                    <?php if (get_theme_mod('business_school_about_title') != '') { ?>
                                        <p class="abt-title mb-2 text-capitalize">
                                            <i class="fas fa-building me-2"></i><?php echo esc_html(get_theme_mod('business_school_about_title')); ?>
                                        </p>
                                    <?php } ?>
                                    <h2 class="mb-lg-3 mb-2"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
                                    <p class="main-para mb-lg-5 mb-2"><?php echo esc_html(wp_trim_words(get_the_content(), 48, '')); ?></p>
                                    <?php 
                                    for($i=1; $i<=3; $i++ ) {?>
                                        <?php if (get_theme_mod('business_school_about_sentence'.$i) != '') { ?>
                                            <p class="abt-sentence my-3 text-capitalize"><i class="fas fa-check pe-4"></i><?php echo esc_html(get_theme_mod('business_school_about_sentence'.$i)); ?></p>
                                        <?php } ?>
                                    <?php } ?>
                                    <div class="abt-btn mt-md-5 mt-4">
                                        <a class="text-decoration-none" href="<?php the_permalink(); ?>"><?php esc_html_e('About More', 'business-school'); ?></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endwhile;
                    wp_reset_postdata();
                }
                ?>
            </div>
        </div>
    <?php } ?>

</div>
<?php get_footer(); ?>