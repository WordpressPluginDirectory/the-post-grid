<?php
/**
 * @author  RadiusTheme
 * @since   1.0
 * @version 1.0
 */

?>
<div id="tpg-MyAccount-wrap">
	<?php do_action( 'tpg_account_navigation' ); ?>

	<div class="tpg-MyAccount-content <?php echo esc_attr( rtTPG()->hasPro() ? 'has-pro' : 'has-no-pro')?>">
		<?php // Functions::print_notices(); ?>
		<?php do_action( 'tpg_account_content' ); ?>
	</div>
</div>