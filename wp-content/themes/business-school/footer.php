<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the #content div and all content after
 *
 * @package Business School
 */
?>
<div id="footer">
  <div class="container">
    <div class="row footer-content">
      <?php dynamic_sidebar('footer-nav'); ?>
    </div>
  </div>
  <div class="copywrap text-center">
    <div class="container">
      <p><?php echo esc_html(get_theme_mod('business_school_copyright_line',__('Business School WordPress Theme','business-school'))); ?> <?php echo esc_html('By Classic Templates','business-school'); ?></p>
    </div>
  </div>
</div>

<?php if(get_theme_mod('business_school_scroll_hide',false)){ ?>
 <a id="button"><?php esc_html_e('TOP', 'business-school'); ?></a>
<?php } ?>
  
<?php wp_footer(); ?>
</body>
</html>
