<?php

class TeamMemberRegister
{

	public $post_type = 'team-member';

	public $taxonomies = ['member-type'];

	public  function __construct()
	{
		if (!empty(get_option('new_cpt_name'))) {
			$this->post_type = strtolower(preg_replace("![^a-z0-9]+!i", "-", get_option('new_cpt_name')));
			
		}
		if (empty(get_option('new_cpt_name')) && !file_exists(TM_CPT_PLUGIN_DIR . 'templates/archive-team-member.php')) {
			$file_archive = preg_grep('~^archive-.*\.php$~', scandir(TM_CPT_PLUGIN_DIR . "templates/"));
			$file_single = preg_grep('~^single-.*\.php$~', scandir(TM_CPT_PLUGIN_DIR . "templates/"));
			foreach($file_archive as $old){
				$old_file = TM_CPT_PLUGIN_DIR . 'templates/' . $old;
				$new_file = TM_CPT_PLUGIN_DIR . 'templates/archive-team-member.php';
				rename($old_file, $new_file);
			}	
			foreach($file_single as $old_single){
				$old_single_file = TM_CPT_PLUGIN_DIR . 'templates/' . $old_single;
				$new__single_file = TM_CPT_PLUGIN_DIR . 'templates/single-team-member.php';
				rename($old_single_file, $new__single_file);
			}	
		
		}
		
	}

	public function init()
	{
		add_action('init', array($this, 'register'));
		add_action('admin_menu', array($this, 'my_cool_plugin_create_menu'));
		add_action('admin_init', array($this, 'register_team_member_plugin_settings'));
		if (!empty(get_option('new_cpt_name'))) {
			// $this->post_type = strtolower(preg_replace("![^a-z0-9]+!i", "-", get_option('new_cpt_name')));

			$file_archive = preg_grep('~^archive-.*\.php$~', scandir(TM_CPT_PLUGIN_DIR . "templates/"));
			$file_single = preg_grep('~^single-.*\.php$~', scandir(TM_CPT_PLUGIN_DIR . "templates/"));
			if(!TM_CPT_PLUGIN_DIR . 'templates/archive-' . strtolower(preg_replace("![^a-z0-9]+!i", "-", get_option('new_cpt_name'))) . '.php'){
				foreach($file_archive as $old){
					$old_file = TM_CPT_PLUGIN_DIR . 'templates/' . $old;
					$new_file = TM_CPT_PLUGIN_DIR . 'templates/archive-' . strtolower(preg_replace("![^a-z0-9]+!i", "-", get_option('new_cpt_name'))) . '.php';
					rename($old_file, $new_file);
				}			
			}
			if(!TM_CPT_PLUGIN_DIR . 'templates/single-' . strtolower(preg_replace("![^a-z0-9]+!i", "-", get_option('new_cpt_name'))) . '.php'){
				foreach($file_single as $old_single){
					$old_single_file = TM_CPT_PLUGIN_DIR . 'templates/' . $old_single;
					$new__single_file = TM_CPT_PLUGIN_DIR . 'templates/single-' . strtolower(preg_replace("![^a-z0-9]+!i", "-", get_option('new_cpt_name'))) . '.php';
					rename($old_single_file, $new__single_file);
				}			
			}
			
			
			
		}
	}

	public function register()
	{
		$this->register_post_type();
		$this->register_taxonomy_category();
	}


	protected function register_post_type()
	{
		$cpt_name = !empty(get_option('new_cpt_name')) ?get_option('new_cpt_name') : 'Team Member';
		$labels = array(
			'name'               => __($cpt_name, 'teammember'),
			'singular_name'      => __($cpt_name, 'teammember'),
			'add_new'            => __('Add ' . $cpt_name, 'teammember'),
			'add_new_item'       => __('Add '. $cpt_name , 'teammember'),
			'edit_item'          => __('Edit ' . $cpt_name, 'teammember'),
			'new_item'           => __('New ' . $cpt_name, 'teammember'),
			'view_item'          => __('View ' . $cpt_name, 'teammember'),
			'search_items'       => __('Search ' . $cpt_name, 'teammember'),
			'not_found'          => __('No '. $cpt_name .'s found', 'teammember'),
			'not_found_in_trash' => __('No '. $cpt_name .'s in the trash', 'teammember'),
		);

		$supports = array(
			'title',
			'editor',
			'thumbnail',
		);

		$args = array(
			'labels'          => $labels,
			'supports'        => $supports,
			'public'          => true,
			'capability_type' => 'post',
			'rewrite'         => array('slug' => $this->post_type,), // Permalinks format
			'menu_position'   => 30,
			'menu_icon'       => 'dashicons-id',
			'has_archive'     => $this->post_type,
		);

		register_post_type($this->post_type, $args);
	}


	protected function register_taxonomy_category()
	{
		$labels = array(
			'name'                       => __('Member type', 'teammember'),
			'singular_name'              => __('Member type', 'teammember'),
			'menu_name'                  => __('Member types', 'teammember'),
			'edit_item'                  => __('Edit Member type', 'teammember'),
			'update_item'                => __('Update Member type', 'teammember'),
			'add_new_item'               => __('Add New Member type', 'teammember'),
			'new_item_name'              => __('New Member type Name', 'teammember'),
			'parent_item'                => __('Parent Member type', 'teammember'),
			'parent_item_colon'          => __('Parent Member type:', 'teammember'),
			'all_items'                  => __('All Member type', 'teammember'),
			'search_items'               => __('Search Member type', 'teammember'),
			'popular_items'              => __('Popular Member type', 'teammember'),
			'separate_items_with_commas' => __('Separate Member type with commas', 'teammember'),
			'add_or_remove_items'        => __('Add or remove Member type', 'teammember'),
			'choose_from_most_used'      => __('Choose from the most used team categories', 'teammember'),
			'not_found'                  => __('No Member type found.', 'teammember'),
		);

		$args = array(
			'labels'            => $labels,
			'public'            => true,
			'show_in_nav_menus' => true,
			'show_ui'           => true,
			'show_tagcloud'     => true,
			'hierarchical'      => true,
			'rewrite'           => array('slug' => $this->taxonomies[0]),
			'show_admin_column' => true,
			'query_var'         => true,
		);

		register_taxonomy($this->taxonomies[0], $this->post_type, $args);
	}


	function my_cool_plugin_create_menu()
	{
		add_menu_page('Team Member Settings', 'Team Member Settings', 'administrator', __FILE__, array($this, 'team_member_plugin_settings_page'), 'dashicons-admin-site-alt3');
	}


	function register_team_member_plugin_settings()
	{
		register_setting('team-member-plugin-settings', 'new_cpt_name');
	}

	function team_member_plugin_settings_page()
	{ ?>
		
		<div class="wrap">

			<div class="get-short-code" style="margin-bottom: 60px;">
				<h3>Display team members</h3>
				<p>
					
				[team_members limit="6" photo_position="top" see_more="yes"]
				
			</p>
			</div>

			<h3>Custom Post Type Settings</h3>

			<form method="post" action="options.php">
				<?php settings_fields('team-member-plugin-settings'); ?>
				<?php do_settings_sections('team-member-plugin-settings'); ?>
				<table class="form-table">
					<tr valign="top">
						<th scope="row">Custom Post Type Name</th>
						<td><input type="text" name="new_cpt_name" value="<?php echo esc_attr(get_option('new_cpt_name')); ?>" /></td>
					</tr>
				</table>

				<?php submit_button(); ?>

			</form>
		</div>
<?php }

}
