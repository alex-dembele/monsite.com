<?php

  $business_school_color_scheme_css = '';

//---------------------------------Logo-Max-height--------- 
  $business_school_logo_width = get_theme_mod('business_school_logo_width');

  if($business_school_logo_width != false){

    $business_school_color_scheme_css .='.logo .custom-logo-link img{';

      $business_school_color_scheme_css .='width: '.esc_html($business_school_logo_width).'px;';

    $business_school_color_scheme_css .='}';
  }

   // slider hide css
  $business_school_slider = get_theme_mod( 'business_school_slider', false);
  $business_school_catData = get_theme_mod('business_school_slider_cat');
  if($business_school_slider != true || $business_school_catData != true){
    $business_school_color_scheme_css .='.page-template-template-home-page .mainhead{';
      $business_school_color_scheme_css .='position:static; background-color: #0D5EF4;';
    $business_school_color_scheme_css .='}';
    $business_school_color_scheme_css .='.page-template-template-home-page .logo:after{';
    $business_school_color_scheme_css .='content:none !important;';
    $business_school_color_scheme_css .='}';
    $business_school_color_scheme_css .='.page-template-template-home-page .menubox, .page-template-template-home-page .logo-col{';
      $business_school_color_scheme_css .='align-self:center;';
    $business_school_color_scheme_css .='}';
  }


