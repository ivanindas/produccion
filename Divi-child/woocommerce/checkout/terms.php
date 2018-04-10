<?php
/**
 * Checkout terms and conditions checkbox
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     3.1.1
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$terms_page_id = wc_get_page_id( 'terms' );

if ( $terms_page_id > 0 && apply_filters( 'woocommerce_checkout_show_terms', true ) ) :
	$terms         = get_post( $terms_page_id );
	$terms_content = has_shortcode( $terms->post_content, 'woocommerce_checkout' ) ? '' : wc_format_content( $terms->post_content );

	/*
	if ( $terms_content ) {
		do_action( 'woocommerce_checkout_before_terms_and_conditions' );
		echo '<div class="woocommerce-terms-and-conditions" style="display: none; max-height: 200px; overflow: auto;">' . $terms_content . '</div>';
	}
	
	*/
	?>
	<p class="form-row terms wc-terms-and-conditions">
		<label class="woocommerce-form__label woocommerce-form__label-for-checkbox checkbox">
			<input type="checkbox" class="woocommerce-form__input woocommerce-form__input-checkbox input-checkbox" name="terms" <?php checked( apply_filters( 'woocommerce_terms_is_checked_default', isset( $_POST['terms'] ) ), true ); ?> id="terms" /> <span><?php printf( __( 'Estoy de acuerdo con los términos mostrados aquí abajo', 'woocommerce' ), esc_url( wc_get_page_permalink( 'terms' ) ) ); ?></span> <span class="required">*</span>
		</label>
		<input type="hidden" name="terms-field" value="1" />
		<?php do_action( 'woocommerce_checkout_before_terms_and_conditions' );
		echo '<div style="display: block;">';?> 
			<table class="tabla_politica_layer_1" cellpadding=0 cellspacing= 0 width="200" style="">
			  <tbody>
				<tr>
				  <td colspan="2" style="background-color: darkblue; color:#fff; text-align: center; font-weight: bold;" >Información Básica sobre Protección de Datos</td>
				</tr>
				<tr>
				  <td>Responsable</td>
				  <td>Laboratorios Indas S.A.U.</td>
				</tr>
				<tr>
				  <td>Finalidad</td>
				  <td>Enviarle las muestras de producto que está solicitando.<br/>
					Enviarle comunicaciones comerciales sobre nuestros productos.
					</td>
				</tr>
				<tr>
				  <td>Legitimación</td>
				  <td>Consentimiento </td>
				</tr>
				<tr>
				  <td>Destinatarios</td>
				  <td>Entidades del Grupo Domtar<br/>
					Autoridades públicas en cumplimiento de sus obligaciones legales
				</td>
				</tr>
				<tr>
				  <td>Derechos</td>
				  <td>Acceder, rectificar y suprimir los datos, así como otros derechos, como se explica en la información adicional</td>
				</tr>
				<tr>
				  <td>Información adicional</td>
				  <td>Puede consultar la información adicional y detallada sobre Protección de Datos en nuestra página web: <?php echo "<a href='".esc_url( wc_get_page_permalink( 'terms' ) )."' target='_blank'>política de privacidad</a>";
					  ?></td>
				</tr>
				  <tr>
				  <td>Comunicaciones por medios electrónicos</td>
				  <td>Acepta recibir comunicaciones publicitarias o promocionales por medios electrónicos.</td>
				</tr>
			  </tbody>
			</table>
	<?php echo '</div>';?>
	</p>
<?php /*
<p class="form-row terms wc-terms-and-conditions">
		<label class="woocommerce-form__label woocommerce-form__label-for-checkbox checkbox">
			<input type="checkbox" class="woocommerce-form__input woocommerce-form__input-checkbox input-checkbox" name="terms" <?php checked( apply_filters( 'woocommerce_terms_is_checked_default', isset( $_POST['terms'] ) ), true ); ?> id="terms" /> <span><?php printf( __( 'He leído y acepto <a href="%s" class="woocommerce-terms-and-conditions-link">la política de privacidad</a>', 'woocommerce' ), esc_url( wc_get_page_permalink( 'terms' ) ) ); ?></span> <span class="required">*</span>
		</label>
		<input type="hidden" name="terms-field" value="1" />
	</p>
*/?>
	<?php do_action( 'woocommerce_checkout_after_terms_and_conditions' ); ?>
<?php endif; ?>
