<?php
error_reporting(0);
if (!defined('ABSPATH')) {
    die;
}

get_header();

?>
<style>
    .term-member-single {
        margin: 0 auto;
        display: table;
        max-width: 800px;
        margin-bottom: 30px;
        margin-top: 10px;
    }

    .term-member-single h3 {
        margin: 0 0 10px;
    }

    .page-title {
        padding-top: 40px;
        padding-bottom: 100px;
        font-size: 40px;
        text-align: center;
        font-weight: bold;
    }
</style>



<div class="term-member-single">

    <div class="page-title">
        <?php the_title(); ?>
    </div>

    <?php
    if (have_posts()) :
        while (have_posts()) : the_post(); ?>

            <?php $photo =   get_post_meta(get_the_ID(),   'team_picture', true); ?>
            <?php if ($photo) { ?>
                <img src="<?php echo $photo; ?>" class="team-photo" />
            <?php } ?>




            <h3><?php echo  get_post_meta(get_the_ID(),   'team_name', true); ?></h3>

            <em><?php echo  get_post_meta(get_the_ID(),   'team_position', true); ?></em>
            <p><?php echo  get_post_meta(get_the_ID(),   'team_bio', true); ?></p>

        <?php endwhile;

        wp_reset_postdata();
    else : ?>
        <p><?php esc_html_e('Sorry, no posts matched your criteria.'); ?></p>
    <?php endif; ?>

</div>



<?php

get_footer();
