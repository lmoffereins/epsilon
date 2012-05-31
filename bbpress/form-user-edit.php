<?php

/**
 * bbPress User Profile Edit Part
 *
 * @package bbPress
 * @subpackage Theme
 */

?>

<form id="bbp-your-profile" action="<?php bbp_user_profile_edit_url( bbp_get_displayed_user_id() ); ?>" method="post">

	<?php do_action( 'bbp_user_edit_before' ); ?>

	<fieldset class="bbp-form">
		<legend class="pre_3 <?php epsilon_columnal_class_bbp( 9, true ); ?>"><h4><?php _e( 'Name', 'bbpress' ) ?></h4></legend>

		<?php do_action( 'bbp_user_edit_before_name' ); ?>

		<div class="clearfix">
			<p class="col_3">
				<label for="voorletters">Voorletters</label>
			</p>
			<p class="<?php epsilon_columnal_class_bbp( 9, true ); ?>">
				<input type="text" name="voorletters" id="voorletters" value="<?php echo esc_attr( bbp_get_displayed_user_field( 'voorletters' ) ); ?>" class="regular-text" tabindex="<?php bbp_tab_index(); ?>" />
			</p>
		</div>

		<div class="clearfix">
			<p class="col_3">
				<label for="first_name"><?php _e( 'First Name', 'bbpress' ) ?></label>
			</p>
			<p class="<?php epsilon_columnal_class_bbp( 9, true ); ?>">
				<input type="text" name="first_name" id="first_name" value="<?php echo esc_attr( bbp_get_displayed_user_field( 'first_name' ) ); ?>" class="regular-text" tabindex="<?php bbp_tab_index(); ?>" />
			</p>
		</div>
		
		<div class="clearfix">
			<p class="col_3">
				<label for="tussenvoegsel">Tussenvoegsel</label>
			</p>
			<p class="<?php epsilon_columnal_class_bbp( 9, true ); ?>">
				<input type="text" name="tussenvoegsel" id="tussenvoegsel" value="<?php echo esc_attr( bbp_get_displayed_user_field( 'tussenvoegsel' ) ); ?>" class="regular-text" tabindex="<?php bbp_tab_index(); ?>" />
			</p>
		</div>

		<div class="clearfix">
			<p class="col_3">
				<label for="last_name"><?php _e( 'Last Name', 'bbpress' ) ?></label>
			</p>
			<p class="<?php epsilon_columnal_class_bbp( 9, true ); ?>">
				<input type="text" name="last_name" id="last_name" value="<?php echo esc_attr( bbp_get_displayed_user_field( 'last_name' ) ); ?>" class="regular-text" tabindex="<?php bbp_tab_index(); ?>" />
			</p>
		</div>

		<div class="clearfix">
			<p class="col_3">
				<label for="nickname"><?php _e( 'Nickname', 'bbpress' ); ?></label>
			</p>
			<p class="<?php epsilon_columnal_class_bbp( 9, true ); ?>">
				<input type="text" name="nickname" id="nickname" value="<?php echo esc_attr( bbp_get_displayed_user_field( 'nickname' ) ); ?>" class="regular-text" tabindex="<?php bbp_tab_index(); ?>" />
			</p>
		</div>

		<div class="clearfix">
			<p class="col_3">
				<label for="display_name"><?php _e( 'Display name publicly as', 'bbpress' ) ?></label>
			</p>
			<p class="<?php epsilon_columnal_class_bbp( 9, true ); ?>">

				<?php bbp_edit_user_display_name(); ?>

			</p>
		</div>

		<?php do_action( 'bbp_user_edit_after_name' ); ?>

	</fieldset>

	<fieldset class="bbp-form">
		<legend class="pre_3 <?php epsilon_columnal_class_bbp( 9, true ); ?>"><h4>Persoonlijke gegevens</h4></legend>

		<?php do_action( 'bbp_user_edit_before_contact' ); ?>

		<legend class="pre_3 <?php epsilon_columnal_class_bbp( 9, true ); ?>"><h4>Contact</h4></legend>
		
		<div class="clearfix">
			<p class="col_3">
				<label for="url">Website</label>
			</p>
			<p class="<?php epsilon_columnal_class_bbp( 9, true ); ?>">
				<input type="text" name="url" id="url" value="<?php echo esc_attr( bbp_get_displayed_user_field( 'user_url' ) ); ?>" class="regular-text" tabindex="<?php bbp_tab_index(); ?>" />
			</p>
		</div>
			
		<?php foreach ( bbp_edit_user_contact_methods() as $name => $desc ) : ?>

			<div class="clearfix">
				<p class="col_3">
					<label for="<?php echo $name; ?>"><?php echo apply_filters( 'user_'.$name.'_label', $desc ); ?></label>
				</p>
				<p class="<?php epsilon_columnal_class_bbp( 9, true ); ?>">
					<input type="text" name="<?php echo $name; ?>" id="<?php echo $name; ?>" value="<?php echo esc_attr( bbp_get_displayed_user_field( $name ) ); ?>" class="regular-text" tabindex="<?php bbp_tab_index(); ?>" />
				</p>
			</div>

		<?php endforeach; ?>

		<?php do_action( 'bbp_user_edit_after_contact' ); ?>

	</fieldset>

	<fieldset class="bbp-form">
		<legend class="pre_3 <?php epsilon_columnal_class_bbp( 9, true ); ?>"><h4><?php bbp_is_user_home() ? _e( 'About Yourself', 'bbpress' ) : printf( __( 'About %s', 'bbpress' ), bbp_get_displayed_user_field( 'display_name' ) ); ?></h4></legend>

		<?php do_action( 'bbp_user_edit_before_about' ); ?>

		<div class="clearfix">
			<p class="col_3">
				<label for="description"><?php _e( 'Biographical Info', 'bbpress' ); ?></label>
			</p>
			<p class="<?php epsilon_columnal_class_bbp( 9, true ); ?>">
				<textarea name="description" id="description" rows="5" cols="30" tabindex="<?php bbp_tab_index(); ?>"><?php echo esc_attr( bbp_get_displayed_user_field( 'description' ) ); ?></textarea>
				<span class="description"><?php _e( 'Share a little biographical information to fill out your profile. This may be shown publicly.', 'bbpress' ); ?></span>
			</p>
		</div>

		<?php do_action( 'bbp_user_edit_after_about' ); ?>

	</fieldset>

	<fieldset class="bbp-form">
		<legend class="pre_3 <?php epsilon_columnal_class_bbp( 9, true ); ?>"><h4><?php _e( 'Account' ) ?></h4></legend>

		<?php do_action( 'bbp_user_edit_before_account' ); ?>

		<div class="clearfix">
			<p class="col_3">
				<label for="user_login"><?php _e( 'Username', 'bbpress' ); ?></label>
			</p>
			<p class="<?php epsilon_columnal_class_bbp( 9, true ); ?>">
				<input type="text" name="user_login" id="user_login" value="<?php echo esc_attr( bbp_get_displayed_user_field( 'user_login' ) ); ?>" disabled="disabled" class="regular-text" tabindex="<?php bbp_tab_index(); ?>" />
				<span class="description"><?php _e( 'Usernames cannot be changed.', 'bbpress' ); ?></span>
			</p>
		</div>

		<div class="clearfix">
			<p class="col_3">
				<label for="email"><?php _e( 'Email', 'bbpress' ); ?></label>
			</p>
			<p class="<?php epsilon_columnal_class_bbp( 9, true ); ?>">
				<input type="text" name="email" id="email" value="<?php echo esc_attr( bbp_get_displayed_user_field( 'user_email' ) ); ?>" class="regular-text" tabindex="<?php bbp_tab_index(); ?>" />

			<?php

			// Handle address change requests
			$new_email = get_option( bbp_get_displayed_user_id() . '_new_email' );
			if ( $new_email && $new_email != bbp_get_displayed_user_field( 'user_email' ) ) : ?>

				<span class="updated inline">

					<?php printf( __( 'There is a pending email address change to <code>%1$s</code>. <a href="%2$s">Cancel</a>', 'bbpress' ), $new_email['newemail'], esc_url( self_admin_url( 'user.php?dismiss=' . bbp_get_current_user_id()  . '_new_email' ) ) ); ?>

				</span>

			<?php endif; ?>
			
			</p>
		</div>

		<div id="password" class="clearfix">
			<p class="col_3">
				<label for="pass1"><?php _e( 'New Password', 'bbpress' ); ?></label>
			</p>
			<p class="<?php epsilon_columnal_class_bbp( 9, true ); ?>">
				<fieldset class="bbp-form">
					<input type="password" name="pass1" id="pass1" size="16" value="" autocomplete="off" tabindex="<?php bbp_tab_index(); ?>" />
					<span class="description"><?php _e( 'If you would like to change the password type a new one. Otherwise leave this blank.', 'bbpress' ); ?></span>

					<input type="password" name="pass2" id="pass2" size="16" value="" autocomplete="off" tabindex="<?php bbp_tab_index(); ?>" />
					<span class="description"><?php _e( 'Type your new password again.', 'bbpress' ); ?></span><br />

					<div id="pass-strength-result"></div>
					<span class="description indicator-hint"><?php _e( 'Hint: The password should be at least seven characters long. To make it stronger, use upper and lower case letters, numbers and symbols like ! " ? $ % ^ &amp; ).', 'bbpress' ); ?></span>
				</fieldset>
			</p>
		</div>

		<?php if ( !bbp_is_user_home() ) : ?>

			<div class="clearfix">
				<p class="col_3">
					<label for="role"><?php _e( 'Role:', 'bbpress' ) ?></label>
				</p>
				<p class="<?php epsilon_columnal_class_bbp( 9, true ); ?>">

					<?php bbp_edit_user_role(); ?>

				</p>
			</div>

		<?php endif; ?>

		<?php if ( is_multisite() && is_super_admin() && current_user_can( 'manage_network_options' ) ) : ?>

			<div class="clearfix">
				<p class="col_3">
					<label for="role"><?php _e( 'Super Admin', 'bbpress' ); ?></label>
				</p>
				<p class="<?php epsilon_columnal_class_bbp( 9, true ); ?>">
					<label>
						<input type="checkbox" id="super_admin" name="super_admin"<?php checked( is_super_admin( bbp_get_displayed_user_id() ) ); ?> tabindex="<?php bbp_tab_index(); ?>" />
						<?php _e( 'Grant this user super admin privileges for the Network.', 'bbpress' ); ?>
					</label>
				</p>
			</div>

		<?php endif; ?>

		<?php do_action( 'bbp_user_edit_after_account' ); ?>

	</fieldset>

	<?php do_action( 'bbp_user_edit_after' ); ?>

	<fieldset class="submit">
		<legend class="pre_3 <?php epsilon_columnal_class_bbp( 9, true ); ?>"><h4><?php _e( 'Save Changes', 'bbpress' ); ?></h4></legend>
		<div class="pre_3 <?php epsilon_columnal_class_bbp( 9, true ); ?>">

			<?php bbp_edit_user_form_fields(); ?>

			<button type="submit" tabindex="<?php bbp_tab_index(); ?>" id="bbp_user_edit_submit" name="bbp_user_edit_submit" class="button submit user-submit"><?php bbp_is_user_home() ? _e( 'Update Profile', 'bbpress' ) : _e( 'Update User', 'bbpress' ); ?></button>
		</div>
	</fieldset>

</form>