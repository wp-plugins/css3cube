<?php
/**
 * Template Name: Home Cube Template
 *
 * default te,plate for cube sides
 *
 *
 * @package PTE
 * @since 	1.0.0
 * @version	1.0.0
 */

//$pte = Page_Template_Plugin::get_instance();
//$locale = $pte->get_locale();


 get_header(); ?>
 <main role="main" class="wrap">
     <section class="cube">

         <?php   CubeTemplater::getcube_sides()    ?>

   </section>

<!-- arrow controllers-->
            <section id="options">
                <div class="show-buttons">
                    <button class="show-up"></button>
                    <button class="show-down"></button>
                    <button class="show-right"></button>
                    <button class="show-left"></button>
                </div>
            </section>
 </main>


<?php get_footer(); ?>