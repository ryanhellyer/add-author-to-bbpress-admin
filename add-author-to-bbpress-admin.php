<?php
/*
Plugin Name: Add Author to bbPress Admin
Plugin URI: https://geek.hellyer.kiwi/plugins/add-author-to-bbpress-admin/
Description: Adds an author select box to the bbPress admin for changing the author of posts and replies.
Version: 1.0
Author: Ryan Hellyer
Author URI: https://geek.hellyer.kiwi/
Text Domain: add-author-to-bbpress-admin
License: GPL2

------------------------------------------------------------------------
Copyright Ryan Hellyer

This program is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation; either version 2 of the License, or
(at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA 02111-1307 USA

*/


/**
 * Do not continue processing since file was called directly
 * 
 * @since 1.0
 * @author Ryan Hellyer <ryanhellyer@gmail.com>
 */
if ( ! defined( 'ABSPATH' ) ) {
	die( 'Eh! What you doin in here?' );
}



add_action( 'bbp_author_metabox', 'add_author_to_bbpress_admin' );
/**
 * Adds an author select box to the bbPress admin.
 */
function add_author_to_bbpress_admin() {

	$max_number = apply_filters( 'add_author_to_bbpress_admin_max_number', 200 );

	$users = get_users(
		array(
			'orderby' => 'nicename',
			'number' => $max_number,
		)
	);
	if ( $max_number == count( $users ) ) {
		echo '<strong>' . esc_html__( sprintf( 'You have more than %s users. This is too many for the Add Author to bbPress admin plugin to handle, and so it is falling back to the default ID system sorry.', (string) $max_number ), 'add-author-to-bbpress-admin' ) . '</strong>';
		return;
	}

	?>
	<p>
		<strong><?php esc_html_e( 'Select author by name', 'add-author-to-bbpress-admin' ); ?></strong>
		<br />
		<select name="post_author_override" id="bbp_author_selector"><?php

		foreach ( $users as $user ) {
			echo '<option value="' . esc_attr( $user->ID ) . '">' . esc_html( $user->data->display_name ) . '</option>';
		}

		?>
		</select>
	</p>

	<script>
	document.getElementById("bbp_author_id").setAttribute("disabled", "disabled");
	</script>
	<?php
}
