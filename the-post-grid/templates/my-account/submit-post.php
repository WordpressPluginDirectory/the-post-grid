<?php
/*
 * phpcs:disable WordPress.Security.NonceVerification.Recommended
 * phpcs:disable WordPress.Security.NonceVerification.Missing
 * phpcs:disable WordPress.Security.ValidatedSanitizedInput.InputNotSanitized:
 */
use RT\ThePostGrid\Helpers\Fns;

?>
<div id="tpg-postbox" class="tpg-postbox">
	<form action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>" id="new_post" name="new_post"
		  class="new-post needs-validation" method="post" enctype="multipart/form-data">
		<input type="hidden" name="action" value="tpg_post_save"/>
		<input type="hidden" name="uid" value="<?php echo esc_attr( get_current_user_id() ); ?>"/>
		<div class="tpg-form-container">

			<div class="form-item">
				<label for="title"><?php esc_attr_e( 'Title', 'the-post-grid' ); ?><span>*</span></label>
				<input type="text" id="title" value="" tabindex="1" size="20" name="title" class="is-valid"/>
				<div class="invalid-feedback">
					<?php esc_html_e( 'Please enter the title' ); ?>
				</div>
			</div>
			<div class="form-item form-content-area">
				<label for="content"><?php esc_attr_e( 'Content', 'the-post-grid' ); ?></label>
				<?php
				$content = '';
				if ( isset( $_POST['submit'] ) && ! empty( $_POST['content'] ) ) {
					$content = wp_kses_post( wp_unslash( $_POST['content'] ) );
				}
				$editor_settings = [
					'textarea_name' => 'content',
					'textarea_rows' => 150,
					'media_buttons' => true,
					'teeny'         => true,
				];
				wp_editor( $content, 'user-editor', $editor_settings );
				?>
			</div>

			<div class="form-item">
				<label for="excerpt"><?php esc_attr_e( 'Excerpt', 'the-post-grid' ); ?></label>
				<textarea type="textarea" id="excerpt" value="" name="excerpt" rows="2"></textarea>
			</div>

			<div class="form-item">
				<label for="tpg-category"><?php esc_attr_e( 'Category', 'the-post-grid' ); ?></label>
				<div class="cat-list">
					<?php
					$post_cats = get_terms(
						[
							'taxonomy'   => 'category',
							'hide_empty' => false,
						]
					);
					?>
					<select id="tpg-category" class="postform" name="post_category[]" multiple="multiple">
						<option value="" selected disabled></option>
						<?php
						foreach ( $post_cats as $p_cat ) {
							echo '<option value="' . esc_attr( $p_cat->term_id ) . '">' . esc_html( $p_cat->name ) . '</option>';
						}
						?>
					</select>
				</div>
			</div>
			<div class="form-item">
				<label for="new_tpg_tags"><?php esc_attr_e( 'Tags', 'the-post-grid' ); ?></label>
				<div class="new_tpg_tags">
					<div class="tpg-tags-input">
						<input type="text" value="" name="post_tags" id="new_tpg_tags" autocomplete="off"/>
					</div>
					<input type="hidden" id="rtpg_post_tag" name="rtpg_post_tag">
				</div>
			</div>

			<div class="form-item" id="tpg-featured-image">

				<?php if ( current_user_can( 'upload_files' ) ) { ?>
					<label class="custom-file-upload">
						<input id="tpg-feature-image" type="file"/>
						<input name="tpg_feature_image" type="hidden" id="tpg-feature-image-id" value=""/>

						<svg width="18" height="14" viewBox="0 0 18 14" fill="none" xmlns="http://www.w3.org/2000/svg">
							<path d="M15.909 11.7727H16.2272C16.7541 11.7727 17.1818 11.3454 17.1818 10.8182V0.954545C17.1818 0.427318 16.7541 0 16.2272 0H3.49996C2.97273 0 2.54541 0.427318 2.54541 0.954545V1.27273H15.909V11.7727Z" fill="#6DA4E7"/>
							<path d="M14 2.22726H0.954545C0.427636 2.22726 0 2.65458 0 3.18181V13.0454C0 13.5727 0.427636 14 0.954545 14H14C14.5269 14 14.9545 13.5727 14.9545 13.0454V3.18181C14.9545 2.65458 14.5269 2.22726 14 2.22726ZM13.6818 12.0909H1.27273V10.8182L5.72727 6.36363L8.75 9.38636L10.5 7.63636L13.6818 10.8182V12.0909Z" fill="#006FFF"/>
						</svg>

						<?php esc_html_e( 'Set Featured Image', 'the-post-grid' ); ?>
					</label>

					<div class="featured-image-container tpg-image-preview"></div>
				<?php } else { ?>
					<label class="thumb-file-upload">
						<input id="tpg-feature-image2" type="file" name="tpg-feature-image2" accept="image/png, image/gif, image/jpeg"/>
					</label>
				<?php } ?>
			</div>

			<?php wp_nonce_field( 'tpg-frontend-post' ); ?>
			<div class="form-item">
				<input type="submit" value="<?php echo esc_attr__( 'Submit Post', 'the-post-grid' ); ?>" tabindex="6" id="submit" name="submit"/>
			</div>
		</div>
	</form>

	<?php if ( ! empty( $_GET['status'] ) ) : ?>
		<?php Fns::status_message( sanitize_text_field( wp_unslash( $_GET['status'] ) ) ); ?>
	<?php endif; ?>
</div>