<?php

class TeamMemberFrontend
{
  
    
    public function init()
    {
        add_filter('single_template', array($this, 'override_single_template'));
        add_filter('archive_template', array($this, 'override_archive_template'));
        add_shortcode('team_members', array($this, 'team_members'));
        
    }



    public function override_single_template($single_template)
    {
        global $post;
       
   
            $file = TM_CPT_PLUGIN_DIR . 'templates/single-' .  $post->post_type . '.php';
            if (file_exists($file)) {
                $single_template = $file;
            }
      
        return $single_template;
    }

    public function override_archive_template($archive_template)
    {
        global $post;
      
        if ( is_post_type_archive ( $post->post_type ) ) {
            $file = TM_CPT_PLUGIN_DIR . 'templates/archive-' . $post->post_type . '.php';

            if (file_exists($file)) {
                $archive_template = $file;
            }
       }    
        return  $archive_template;
    }

    public function team_members($atts)
    {
        $atts = shortcode_atts(
            array(
                'limit' => 2,
                'see_more' => 'yes', // no
                'photo_position' => 'top', // bottom
            ),
            $atts,
            'teammember'
        );

        ob_start();
        include TM_CPT_PLUGIN_DIR . 'templates/team-members.php';
        return ob_get_clean();
    }
}
