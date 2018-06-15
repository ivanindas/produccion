<?php
/**
 * Checkout terms and conditions area.
 *
 * @package WooCommerce/Templates
 * @version 3.4.0
 */

defined( 'ABSPATH' ) || exit;

if ( apply_filters( 'woocommerce_checkout_show_terms', true ) && function_exists( 'wc_terms_and_conditions_checkbox_enabled' ) ) {
	do_action( 'woocommerce_checkout_before_terms_and_conditions' );

	?>
	<div class="woocommerce-terms-and-conditions-wrapper">
		<?php
		/**
		 * Terms and conditions hook used to inject content.
		 *
		 * @since 3.4.0.
		 * @hooked wc_privacy_policy_text() Shows custom privacy policy text. Priority 20.
		 * @hooked wc_terms_and_conditions_page_content() Shows t&c page content. Priority 30.
		 */
		do_action( 'woocommerce_checkout_terms_and_conditions' );
		?>

		<?php if ( wc_terms_and_conditions_checkbox_enabled() ) : ?>
			<p class="form-row validate-required">
				<label class="woocommerce-form__label woocommerce-form__label-for-checkbox checkbox">
				<input type="checkbox" class="woocommerce-form__input woocommerce-form__input-checkbox input-checkbox" name="terms" <?php checked( apply_filters( 'woocommerce_terms_is_checked_default', isset( $_POST['terms'] ) ), true ); // WPCS: input var ok, csrf ok. ?> id="terms" />
					<span><?php printf( __( 'Estoy de acuerdo con los términos mostrados aquí abajo', 'woocommerce' ), esc_url( wc_get_page_permalink( 'terms' ) ) ); ?></span><span class="required">*</span>
					<!--<span class="woocommerce-terms-and-conditions-checkbox-text"><?php wc_terms_and_conditions_checkbox_text(); ?></span>&nbsp;<span class="required">*</span>-->
				</label>
				<input type="hidden" name="terms-field" value="1" />
				
				<?php echo '<div style="display: block;">';?> 
				
	<p class="form-row form-row-thirds" style="visibility: hidden;">
		<input type="checkbox" id="notificaciones"  name="notificaciones"> Acepto recibir notificaciones via email.
    </p>

	
<script>
		(function($) {
			$('#terms').click(function() {
				// Si esta seleccionado (si la propiedad checked es igual a true)
            if ($(this).prop('checked')) {
                // Selecciona cada input que tenga la clase .checar
                $('#notificaciones').prop('checked', true);
            } else {
                // Deselecciona cada input que tenga la clase .checar
                $('#notificaciones').prop('checked', false);
            }
			});
		
		
		
		
		})(jQuery);
					  </script>


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
		<?php endif; ?>
	</div>
	<?php

	do_action( 'woocommerce_checkout_after_terms_and_conditions' );
}
