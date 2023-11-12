<?php  
error_reporting(0);
if ( ! defined( 'ABSPATH' ) ) {
	die;
}

get_header(); 

?>
<style>
    ul.team-member-list {
        width: 100%;
        max-width: 800px;
        clear: both;
        padding: 0;
        display: table;
        margin: 30px auto;
    }

    .team-member-list a {
        text-decoration: none;
    }

    .team-member-list li {
        list-style: none;
        text-align: center;
        width: 33.33%;
        float: left;margin-bottom: 50px;
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
    .pagination span, .pagination a {
    padding: 5px 12px;
    text-decoration: none;
    text-align: center;
    border: 1px solid #a2a2a2;
    margin: 0 3px;
    display: inline-block;
}
.pagination span.page-numbers.current {
    background: #000;
    color: #fff;
}
    .pagination {
    display: table;
    margin: 20px auto;
    clear: both;
    width: 100%;
    max-width: 1200px;
    text-align: center;
}

</style>

<?php


$paged = (get_query_var('paged')) ? get_query_var('paged') : 1; // changed all page to paged


$post_type_name =  !empty(get_option('new_cpt_name')) ? strtolower(preg_replace("![^a-z0-9]+!i", "-", get_option('new_cpt_name'))) : 'team-member';
$args = array(
    'post_type' => $post_type_name,
    'posts_per_page' => get_option( 'posts_per_page' ),
    'paged' => $paged,
);
$the_query = new WP_Query($args); ?>




<?php if ($the_query->have_posts()) : ?>
    <ul class="team-member-list">
        <?php while ($the_query->have_posts()) : $the_query->the_post(); ?>
            <?php $photo =   get_post_meta(get_the_ID(),   'team_picture', true); ?>
            <li>
                
                    <a href="<?php the_permalink(); ?>">
                        <img src="<?php echo $photo; ?>" class="team-photo" />
                    </a>
        

                <h3><a href="<?php the_permalink(); ?>"><?php echo  get_post_meta(get_the_ID(),   'team_name', true); ?></a></h3>
              
                <p><?php echo  get_post_meta(get_the_ID(),   'team_position', true); ?></p>

              
            </li>

        <?php endwhile; ?>
    </ul>

    <div class="pagination">
    <?php 
        echo paginate_links( array(
            'base'         => str_replace( 999999999, '%#%', esc_url( get_pagenum_link( 999999999 ) ) ),
            'total'        => $the_query->max_num_pages,
            'current'      => max( 1, get_query_var( 'paged' ) ),
            'format'       => '?paged=%#%',
            'show_all'     => false,
            'type'         => 'plain',
            'end_size'     => 2,
            'mid_size'     => 1,
            'prev_next'    => true,
            'prev_text'    => sprintf( '<i></i> %1$s', __( 'Newer Posts', 'text-domain' ) ),
            'next_text'    => sprintf( '%1$s <i></i>', __( 'Older Posts', 'text-domain' ) ),
            'add_args'     => false,
            'add_fragment' => '',
        ) );
    ?>
</div>


    <?php wp_reset_postdata(); ?>

   
    

<?php endif; ?>




