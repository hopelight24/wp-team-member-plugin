<style>
    ul.team-member-list {
        width: 100%;
        max-width: 800px;
        clear: both;
        padding: 0;
        display: table;
    }
    ul.team-member-list li {margin-bottom: 50px;}
    

    .team-member-list a {
        text-decoration: none;
    }

    .team-member-list li {
        list-style: none;
        text-align: center;
        width: 33.33%;
        float: left;
    }

    .team-member-list h3 {
        margin-top: 0;
        margin-bottom: 10px;
    }

    .team-member-list p {
        margin-top: 0;
        margin-bottom: 10px;
    }

    .team-member-list li img.team-photo {
        height: 200px;
        width: 200px;
        border-radius: 50%;
        margin-bottom: 30px;
    }

    .see-more-btn a {
    border-radius: 5px;
    background: #a2a2a2;
    padding: 10px 28px;
    text-decoration: none;
    font-size: 20px;
}
.see-more-btn {
    margin: 20px auto;
    text-align: center;
    display: table;
}


</style>


<?php
$post_type_name =  !empty(get_option('new_cpt_name')) ? strtolower(preg_replace("![^a-z0-9]+!i", "-", get_option('new_cpt_name'))) : 'team-member';
$args = array(
    'post_type' => $post_type_name,
    'posts_per_page' => $atts['limit']
);
$the_query = new WP_Query($args); ?>




<?php if ($the_query->have_posts()) : ?>
    <ul class="team-member-list">
        <?php while ($the_query->have_posts()) : $the_query->the_post(); ?>
            <?php $photo =   get_post_meta(get_the_ID(),   'team_picture', true); ?>
            <li>
                <?php if (($atts['photo_position'] == 'top') && !empty($photo)) : ?>
                    <a href="<?php the_permalink(); ?>">
                        <img src="<?php echo $photo; ?>" class="team-photo" />
                    </a>
                <?php endif; ?>

                <h3><a href="<?php the_permalink(); ?>"><?php echo  get_post_meta(get_the_ID(),   'team_name', true); ?></a></h3>
                <p><?php echo  get_post_meta(get_the_ID(),   'team_position', true); ?></p>

                <?php if (($atts['photo_position'] == 'bottom') && !empty($photo)) : ?>
                    <a href="<?php the_permalink(); ?>">
                        <img src="<?php echo $photo; ?>" class="team-photo" />
                    </a>
                <?php endif; ?>
            </li>

        <?php endwhile; ?>
    </ul>
    <?php wp_reset_postdata(); ?>

    <?php if ($atts['see_more'] == 'yes') { 
        $archiveUrl = (get_option('new_cpt_name')) ? strtolower(preg_replace("![^a-z0-9]+!i", "-", get_option('new_cpt_name'))) : 'team-member';
        ?>
        <div class="see-more-btn">            
            <a href="<?php echo get_post_type_archive_link($archiveUrl); ?>">See All</a>
        </div>
    <?php } ?>

<?php endif; ?>