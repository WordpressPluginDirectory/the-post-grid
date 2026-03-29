<?php
/**
 * Settings Page
 *
 * @package RT_TPG
 */

use RT\ThePostGrid\Helpers\Fns;
use RT\ThePostGrid\Helpers\Options;
use RT\ThePostGrid\Helpers\Svg;

// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'This script cannot be accessed directly.' );
}
?>

<div class=" rttpg-wrapper">
    <div id="upf-icon-edit-pages" class="icon32 icon32-posts-page"><br/></div>

	<?php require_once trailingslashit( RT_THE_POST_GRID_PLUGIN_PATH ) . 'resources/parts/settings-header.php'; ?>

    <div class="rt-setting-wrapper">
        <div class="rt-response"></div>
        <div class="settings-container">
            <form id="rt-tpg-settings-form">
				<?php
				$settings = get_option( rtTPG()->options['settings'] );
				$last_tab = isset( $settings['_tpg_last_active_tab'] ) ? trim( $settings['_tpg_last_active_tab'] ) : 'common-settings';
				$last_tab = ! empty( $_GET['section'] ) ? sanitize_text_field( $_GET['section'] ) : $last_tab;
				?>
                <div id="settings-tabs" class="rt-tabs rt-tab-container">
                    <div class="rt-settings-sidebar">
                        <ul class="tab-nav rt-tab-nav">
							<?php
							$tabs = [
								'common-settings'         => [
									'label' => __( 'Common Settings', 'the-post-grid' ),
									'icon'  => 'settings',
									'size'  => 16,
								],
								'popup-fields'            => [
									'label' => __( 'PopUp field selection', 'the-post-grid' ),
									'icon'  => 'popup',
								],
                                'post-ordering'            => [
                                        'label' => __( 'Post Ordering', 'the-post-grid' ),
                                        'icon'  => 'ordering',
                                ],
								'social-share'            => [
									'label' => __( 'Social Share', 'the-post-grid' ),
									'icon'  => 'share',
								],
								'custom-script'           => [
									'label' => __( 'Custom Script', 'the-post-grid' ),
									'icon'  => 'code',
								],
								'ai-integration-settings' => [
									'label' => __( 'AI Integration', 'the-post-grid' ),
									'icon'  => 'ai',
									'size'  => 18
								],
								'myaccount-settings'      => [
									'label' => __( 'My Account', 'the-post-grid' ),
									'icon'  => 'user',
								],
								'event-settings'          => [
									'label' => __( 'Event Settings', 'the-post-grid' ),
									'icon'  => 'calender',
								],
								'other-settings'          => [
									'label' => __( 'Other Settings', 'the-post-grid' ),
									'icon'  => 'tools',
								],
							];
							?>

							<?php foreach ( $tabs as $tab_id => $tab ) : ?>
                                <li class="<?php echo $last_tab === $tab_id ? 'active' : ''; ?>">
                                    <a href="#<?php echo esc_attr( $tab_id ); ?>">
										<?php Svg::get_svg( $tab['icon'], $tab['size'] ?? '15' ); ?>

										<?php echo esc_html( $tab['label'] ); ?>
                                    </a>
                                </li>
							<?php endforeach; ?>
							<?php do_action( 'tpg_settings_tab_title', $last_tab ); ?>
                        </ul>
                    </div>
                    <div class="rt-settings-content">
                        <!-- Common Settings -->
                        <div id="common-settings" class="rt-tab-content" <?php echo $last_tab === 'common-settings' ? 'style="display:block"' : ''; ?>>
							<?php echo Fns::rtFieldGenerator( Options::rtTPGSettingsCommonSettingsFields() ); ?>
                        </div>

                        <!-- Popup Fields -->
                        <div id="popup-fields" class="rt-tab-content" <?php echo $last_tab === 'popup-fields' ? 'style="display:block"' : ''; ?>>
							<?php echo Fns::rtFieldGenerator( Options::rtTpgSettingsDetailFieldSelection() ); ?>
                        </div>

                        <!-- Post Ordering -->
                        <div id="post-ordering" class="rt-tab-content" <?php echo $last_tab === 'post-ordering' ? 'style="display:block"' : ''; ?>>
                            <?php echo Fns::rtFieldGenerator( Options::rtTpgSettingsPostOrderSelection() ); ?>
                        </div>

                        <!-- Social Share -->
                        <div id="social-share" class="rt-tab-content" <?php echo $last_tab === 'social-share' ? 'style="display:block"' : ''; ?>>
							<?php echo Fns::rtFieldGenerator( Options::rtTPGSettingsSocialShareFields() ); ?>
                        </div>

                        <!-- Custom Script -->
                        <div id="custom-script" class="rt-tab-content" <?php echo $last_tab === 'custom-script' ? 'style="display:block"' : ''; ?>>
							<?php echo Fns::rtFieldGenerator( Options::rtTPGSettingsCustomScriptFields() ); ?>
                        </div>

                        <!-- Other Settings -->
                        <div id="other-settings" class="rt-tab-content" <?php echo $last_tab === 'other-settings' ? 'style="display:block"' : ''; ?>>
							<?php echo Fns::rtFieldGenerator( Options::rtTPGSettingsOtherSettingsFields() ); ?>
                        </div>

                        <!-- AI Integration -->
                        <div id="ai-integration-settings" class="rt-tab-content" <?php echo $last_tab === 'ai-integration-settings' ? 'style="display:block"' : ''; ?>>
							<?php echo Fns::rtFieldGenerator( Options::rtTPGAiIntegrationSettings() ); ?>

                            <div class="rt-ai-integration-settings-chatgpt" style="display:none;">
								<?php echo Fns::rtFieldGenerator( Options::rtTPGChatGPGSettings() ); ?>
                            </div>

                            <div class="rt-ai-integration-settings-gemini" style="display:none;">
								<?php echo Fns::rtFieldGenerator( Options::rtTPGGeminiSettings() ); ?>
                            </div>
                        </div>

                        <!-- My Account -->
                        <div id="myaccount-settings" class="rt-tab-content" <?php echo $last_tab === 'myaccount-settings' ? 'style="display:block"' : ''; ?>>
							<?php echo Fns::rtFieldGenerator( Options::rtTPGMyAccountSettings() ); ?>
                        </div>

                        <!-- Event Settings -->
                        <div id="event-settings" class="rt-tab-content" <?php echo $last_tab === 'event-settings' ? 'style="display:block"' : ''; ?>>
							<?php echo Fns::rtFieldGenerator( Options::rtTPGEventSettings() ); ?>
                        </div>

						<?php do_action( 'tpg_settings_tab_content', $last_tab ); ?>

                        <input type="hidden" id="_tpg_last_active_tab" name="_tpg_last_active_tab" value="<?php echo esc_attr( $last_tab ); ?>"/>

                        <div class="content-footer">
                            <p class="submit-wrap">
                                <input type="submit" name="submit" class="button button-primary rtSaveButton" value="Save Changes">
                            </p>

							<?php wp_nonce_field( rtTPG()->nonceText(), rtTPG()->nonceId() ); ?>
                        </div>
                    </div>

	                <?php require_once trailingslashit( RT_THE_POST_GRID_PLUGIN_PATH ) . 'resources/parts/settings-promo.php'; ?>
                </div>
            </form>

        </div>
    </div>
</div>
