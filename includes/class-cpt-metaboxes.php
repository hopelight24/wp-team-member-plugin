<?php


class TeamMemberMetaboxes
{

	public function init()
	{
		add_action('add_meta_boxes', array($this, 'team_meta_boxes'));
		add_action('save_post', array($this, 'save_meta_boxes'),  10, 2);

		add_action('admin_enqueue_scripts', array($this, 'prfx_image_enqueue'));
	}

	public function team_meta_boxes()
	{
		$tmr = new TeamMemberRegister();
		add_meta_box(
			'team_fields',
			'Profile Fields',
			array($this, 'render_meta_boxes'),
			$tmr->post_type,
			'normal',
			'high'
		);
	}


	public function render_meta_boxes($post)
	{

		$meta = get_post_custom($post->ID);
		$team_name = !isset($meta['team_name'][0]) ? '' : $meta['team_name'][0];
		$team_bio = !isset($meta['team_bio'][0]) ? '' : $meta['team_bio'][0];
		$team_position = !isset($meta['team_position'][0]) ? '' : $meta['team_position'][0];		
		$team_picture = !isset($meta['team_picture'][0]) ? '' : $meta['team_picture'][0];

		wp_nonce_field(basename(__FILE__), 'team_fields'); ?>

		<table class="form-table">
			<tr>
				<td class="team_meta_box_td" colspan="2">
					<label for="team_name"><?php _e('Name', 'teammember'); ?>
					</label>
				</td>
				<td colspan="4">
					<input type="text" name="team_name" class="regular-text" value="<?php echo $team_name; ?>">					
				</td>
			</tr>
			<tr>
				<td class="team_meta_box_td" colspan="2">
					<label for="team_bio"><?php _e('Bio', 'teammember'); ?>
					</label>
				</td>
				<td colspan="4">
					<input type="text" name="team_bio" class="regular-text" value="<?php echo $team_bio; ?>">
				</td>
			</tr>
			<tr>
				<td class="team_meta_box_td" colspan="2">
					<label for="team_position"><?php _e('Position', 'teammember'); ?>
					</label>
				</td>
				<td colspan="4">
					<input type="text" name="team_position" class="regular-text" value="<?php echo $team_position; ?>">
				</td>
			</tr>			
			<tr>
				<td class="team_meta_box_td" colspan="2">
					<label for="profile_facebook"><?php _e('Picture', 'teammember'); ?>
					</label>
				</td>
				<td colspan="4">
				<div class="aw-uploader">
					<p>
						
						<input type="text" name="team_picture" id="meta-image" class="meta-image" value="<?php echo $team_picture ?>">
						<input type="button" class="" id="meta-image-button" value="Browse">
					</p>
					<?php if (!empty($team_picture)) : ?>
						<div class="image-preview">
							<img src="<?php echo $team_picture; ?>" style="width:200px"><br>
							<button type="button" style="background: #8f0707;border: none;color: #fff;padding: 5px 10px;border-radius: 5px;cursor: pointer;" id="project_img_1">Remove</button></div>
					<?php endif; ?>
				</div>
				</td>
			</tr>
		</table>

	<?php }


	public function save_meta_boxes($post_id)
	{
		global $post;
		if (!isset($_POST['team_fields']) || !wp_verify_nonce($_POST['team_fields'], basename(__FILE__))) {
			return $post_id;
		}

		if ((defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) || (defined('DOING_AJAX') && DOING_AJAX) || isset($_REQUEST['bulk_edit'])) {
			return $post_id;
		}

		if (isset($post->post_type) && $post->post_type == 'revision') {
			return $post_id;
		}
		if (!current_user_can('edit_post', $post->ID)) {
			return $post_id;
		}

		$meta['team_name'] = (isset($_POST['team_name']) ? sanitize_text_field($_POST['team_name']) : '');
		$meta['team_bio'] = (isset($_POST['team_bio']) ? sanitize_text_field($_POST['team_bio']) : '');
		$meta['team_position'] = (isset($_POST['team_position']) ? sanitize_text_field($_POST['team_position']) : '');		
		$meta['team_picture'] = (isset($_POST['team_picture']) ? sanitize_text_field($_POST['team_picture']) : '');

		foreach ($meta as $key => $value) {
			update_post_meta($post->ID, $key, $value);
		}
	}

	public function prfx_image_enqueue()
	{
		wp_enqueue_media();
		wp_register_script('meta-box-image', plugin_dir_url(__FILE__) . '../js/meta-box-image.js', array('jquery'));
		wp_localize_script(
			'meta-box-image',
			'meta_image',
			array(
				'title' => __('Choose or Upload an Image', 'prfx-textdomain'),
				'button' => __('Use this image', 'prfx-textdomain'),
			)
		);
		wp_enqueue_script('meta-box-image');
	}


	
}
