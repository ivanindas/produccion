<?php
function indasec_enqueue_tema_hijo_css() {
	wp_enqueue_style( 'indasec-temaPadre-css', get_template_directory_uri() . '/style.css' );
}
add_action( 'wp_enqueue_scripts', 'indasec_enqueue_tema_hijo_css' );


/**
* Auto Complete all WooCommerce orders.
* Add to theme functions.php file
*/

add_action( 'woocommerce_thankyou', 'custom_woocommerce_auto_complete_order' );
function custom_woocommerce_auto_complete_order( $order_id ) {
    global $woocommerce;

    if ( !$order_id )
        return;
    $order = new WC_Order( $order_id );
    $order->update_status( 'completed' );
}



/*
Hide sample and order button if the user has ordered a sample in the last 30 days
*/
function get_customer_last_order() {
    $customer_orders = get_posts( array(
        'numberposts' => 1,
        'meta_key'    => '_customer_user',
        'meta_value'  => get_current_user_id(),
        'post_type'   => array( 'shop_order' ),
        'post_status' => array( 'wc-completed' )
    ) );
	
	if(sizeof($customer_orders)>0){
	$order_date = new DateTime($customer_orders[0]->post_date);
	$now = new DateTime("now");
	
	$interval = $order_date->diff($now);

	if($interval->format('%R%a')<30){
		echo "<script>
				(function($) {
					$('.single_add_to_cart_button').css('display','none');
					
					$('.woocommerce-checkout-payment').css('display','none');
					
				})(jQuery);
				
			</script>";
		echo "Ya has solicitado una muestra de producto el día ".$order_date->format('d-m-Y').". Para pedir otra muestra deben pasar al menos 30 días.";
	}
		}
}

add_action( 'woocommerce_after_add_to_cart_button', 'get_customer_last_order' );
add_action( 'woocommerce_checkout_after_order_review', 'redirect_less_30days' );




function redirect_less_30days() {
    $customer_orders = get_posts( array(
        'numberposts' => 1,
        'meta_key'    => '_customer_user',
        'meta_value'  => get_current_user_id(),
        'post_type'   => array( 'shop_order' ),
        'post_status' => array( 'wc-completed' )
    ) );
	
	if(sizeof($customer_orders)>0){
		$order_date = new DateTime($customer_orders[0]->post_date);
		$now = new DateTime("now");

		$interval = $order_date->diff($now);

		if($interval->format('%R%a')<30){
			wp_redirect('/lo-sentimos-pero/');
		}
	}
}


//add_action( 'woocommerce_before_shop_loop', 'filters_images' );
//add_action( 'woocommerce_product_query', 'filters_images' );

function filters_images() {
    
		echo '<script>( function($){	$("[data-key=\'attro-absorcion\']").each(function() {
		var txt = "<img src=\'http://www.indasec.com/wp-content/uploads/2017/11/"+((($(this).text()).replace(" ","")).replace(".","")).replace(".","")+".png\' title=\'"+$(this).text()+"\' alt=\'"+$(this).text()+"\'/>";
    	$(this).html(txt);
	});})(jQuery);</script>';
		
}



/*
add_filter ('add_to_cart_redirect', 'redirect_to_checkout');

function redirect_to_checkout() {
    global $woocommerce;
    $checkout_url = $woocommerce->cart->get_checkout_url();
    return $checkout_url;
}
*/


function wooc_add_field_to_registration(){
    wc_get_template( 'checkout/terms.php' );
}
add_action( 'woocommerce_register_form', 'wooc_add_field_to_registration' );
 
 
 function wooc_validation_registration( $errors, $username, $password, $email ){
    if ( empty( $_POST['terms'] ) ) {
        throw new Exception( __( 'Debes aceptar los términos y condiciones', 'woocommerce' ) );
    }
	 
    return $errors;
}
add_action( 'woocommerce_process_registration_errors', 'wooc_validation_registration', 10, 4 );



add_action( 'woocommerce_edit_account_form', 'my_woocommerce_edit_account_form' );
add_action( 'woocommerce_save_account_details', 'my_woocommerce_save_account_details' );


//SI estuviera activo el registro en el checkout.... 
add_action( 'woocommerce_checkout_order_review', 'my_woocommerce_edit_account_form' );
add_action( 'woocommerce_checkout_update_user_meta', 'my_woocommerce_save_account_details' );
 

function my_woocommerce_edit_account_form() {
 
  $user_id = get_current_user_id();
  $user = get_userdata( $user_id );
 
  /*if ( !$user )
    return;
 */
$notificaciones = $user->notificaciones;
  ?>
 
  <fieldset>
    <H3>Notificaciones</H3>
    <p class="form-row form-row-thirds">
		<input type="checkbox" id="notificaciones" name="notificaciones" <?php if($notificaciones=="on") echo "checked"; ?>/> Acepto recibir notificaciones via email.
    </p>
  </fieldset>
 
  <?php
 
}
 

//add_action( 'woocommerce_checkout_before_order_review', 'test' );
function test(){
	
	//do_action('users_register_form');
}

function my_woocommerce_save_account_details( $user_id ) {
 
 // $user = wp_update_user( array( 'ID' => $user_id, 'notificaciones' => $_POST[ 'notificaciones' ] ) );
	update_user_meta( $user_id, "notificaciones", $_POST[ 'notificaciones' ], $notificaciones ); 
}




//Redireccion después de registro
function wc_custom_registration_redirect() {
    wp_logout();
    wp_destroy_current_session();
    return home_url('/gracias-por-registrarte-comprueba-tu-bandeja-de-entrada/');
}
add_action('woocommerce_registration_redirect', 'wc_custom_registration_redirect', 99);




//Quitamos campos del formulario
add_filter( 'woocommerce_checkout_fields' , 'personalizacion_checkout_fields' );
add_filter( 'woocommerce_billing_fields' , 'personalizacion_billing_fields' );
function personalizacion_checkout_fields( $fields ) {
	$user_id = get_current_user_id();
	$user = get_userdata( $user_id );
	
	
	if(is_user_logged_in()){
		unset($fields['billing']['billing_email']);	
	}
	//unset($fields['billing']['billing_email']);	
	unset($fields['billing']['billing_company']);

	return $fields;
}
function personalizacion_billing_fields( $fields ) {

	unset($fields['billing_email']);	
	unset($fields['billing_company']);

	return $fields;
}

//Quitamos títulos de woocommerce
add_filter( 'woocommerce_show_page_title' , 'woo_hide_page_title' );

function woo_hide_page_title() {
 
 return false;
 
}

//Cambiar el texto del botón que hay en el carrito para ir al checkout
function woocommerce_button_proceed_to_checkout() {
       $checkout_url = WC()->cart->get_checkout_url();
       ?>
       <a href="<?php echo $checkout_url; ?>" class="checkout-button button alt wc-forward"><?php _e( 'Finalizar solicitud de muestra', 'woocommerce' ); ?></a>
       <?php
     }



//******************************
//******************************
//*****Tracking de eventos
//******************************
//******************************


//Tracking de Listados


$wc_ga_ee_impression_counter = 0;


//Esto trackea las impresiones del listado de tienda.
function wc_ga_ee_archive_impression_tracking() {
	global $product, $wc_ga_ee_impression_counter;
	
	$wc_ga_ee_impression_counter++;
	
	$id = $product->get_sku();
	if (!$id) $id = get_the_ID();
	$name = get_the_title();
	
	$terms = get_the_terms( $product->get_id(), 'product_cat' );

	foreach ($terms as $term) {
		$product_category = $product_cat_id = $term->name;
		break;
	}
	
	$category = $product_category;
	$list = '';
	
	if (is_archive()):
		//$category = single_cat_title('', false);
		$list = 'Shop List';
	elseif (is_home()):
		$list = 'Home Page List';
	elseif (is_product()):
		$list = 'Related Products List ('.$name.')';
	endif;
	
	$position = $wc_ga_ee_impression_counter;
	
	//echo '<span class="wc-ga-ee-impression" data-id="' . esc_attr($id) . '" data-name="' . esc_attr($name) . '" data-cat="' . esc_attr($category) . '" data-list="' . esc_attr($list) . '"></span>';

	global $post;
	echo "<script>
		(function($) {
					$('.post-".$post->ID." > a' ).click(function(){";
				echo 'gtag("event", "Select_content", {
				"event_category": "Ecommerce",
				"event_label": "'.$list.'",
				"content_type": "product",
				"items": [
				{
				  "id": "' . esc_attr($id) . '",
				  "name": "' . esc_attr($name) . '",
				  "list": "' . esc_attr($list) . '",
				  "brand": "Indasec",
				  "category": "' . esc_attr($category) . '",
				  "list_position": '.$position.'
				}
				]
				});';	
					
					echo "})
					})(jQuery);";

	
		
		
	echo 'gtag("event", "View_item_list", {
		"event_category": "Ecommerce",
		"event_label": "'.$list.'",
		"items": [
			{
			  "id": "' . esc_attr($id) . '",
			  "name": "' . esc_attr($name) . '",
			  "list": "' . esc_attr($list) . '",
			  "brand": "Indasec",
			  "category": "' . esc_attr($category) . '",
			  "list_position": '.$position.'
			 // "quantity": 2,
			 // "price": 2
			}
		  ]
		});</script>';
	
}
add_action( 'woocommerce_after_shop_loop_item', 'wc_ga_ee_archive_impression_tracking', 10 );


//Esto trackea las impresiones de listados ante una búsqueda.
add_action( 'the_post', 'wc_ga_ee_search_impression_tracking', 10);
function wc_ga_ee_search_impression_tracking($post) {
	if( !is_search() ) return;
	
	global $wc_ga_ee_impression_counter;
	$wc_ga_ee_impression_counter++;
	$product = wc_get_product( get_the_ID() );
	if (!$product) return;

	$id = $product->get_sku();
	if (!$id) $id = get_the_ID();

	$name = get_the_title();
	
	$terms = get_the_terms( $product->get_id(), 'product_cat' );

	foreach ($terms as $term) {
		$product_category = $product_cat_id = $term->name;
		break;
	}
	
	$category = $product_category;
	
	$list = 'Search Results';
	$position = $wc_ga_ee_impression_counter;
	
	echo '<span class="wc-ga-ee-impression" data-id="' . esc_attr($id) . '" data-name="' . esc_attr($name) . '" data-cat="' . esc_attr($category) . '" data-list="' . esc_attr($list) . '"></span>';
	
	echo '<script>gtag("event", "View_item_list", {
		"event_category": "Ecommerce",
		"event_label": "'.$list.'",
		"items": [
			{
			  "id": "' . esc_attr($id) . '",
			  "name": "' . esc_attr($name) . '",
			  "list": "' . esc_attr($list) . '",
			  "brand": "Indasec",
			  "category": "' . esc_attr($category) . '",
			  "list_position": '.$position.'
			 // "quantity": 2,
			 // "price": 2
			}
		  ]
		});</script>';
	
}





//Tracking del checkout
add_action( 'woocommerce_after_checkout_form', 'track_checkout', 30 );
function track_checkout(){
   global $woocommerce;
    $items = $woocommerce->cart->get_cart();
    
    foreach($items as $item => $values) { 
        $product =  wc_get_product( $values['data']->get_id()); 
		$terms = get_the_terms( $product->get_id(), 'product_cat' );
		
		foreach ($terms as $term) {
			$product_category = $product_cat_id = $term->name;
			break;
		}
		echo '<script>gtag("event","Begin_checkout",{
                // Event parameters
				"event_category": "Ecommerce",
				"event_label": "User data form",
                "items": [
                    {
                    "id":"'.$product->get_sku().'",
                    "name":"'.$product->get_name().'",
                    "brand":"Indasec",
                    "category":"'.$product_category.'",
					"price": 0,
					"quantity":1
                    }]
                });</script>';
            
    } 
}


//Tracking del carrito
add_action( 'woocommerce_after_cart', 'track_cart', 30 );
function track_cart(){
    global $woocommerce;
    $items = $woocommerce->cart->get_cart();
    
    foreach($items as $item => $values) { 
        $product =  wc_get_product( $values['data']->get_id()); 
		$terms = get_the_terms( $product->get_id(), 'product_cat' );
		
		foreach ($terms as $term) {
			$product_category = $product_cat_id = $term->name;
			break;
		}
		echo '<script>gtag("event","Checkout_progress",{
                // Event parameters
				"event_category": "Ecommerce",
				"event_label": "Cart view ",
                "items": [
                    {
                    "id":"'.$product->get_sku().'",
                    "name":"'.$product->get_name().'",
                    "brand":"Indasec",
                    "category":"'.$product_category.'",
					"price": 0,
					"quantity":1
                    }]
                });</script>';
            
    } 
    
}

add_action( 'woocommerce_thankyou', 'track_purchase', 30 );
function track_purchase(){
    global $wp;
    $order_id = isset( $wp->query_vars['order-received'] ) ? intval( $wp->query_vars['order-received'] ) : 0;
    $order = new WC_Order($order_id);
	if ($order && $order->has_status('completed')){
        
        echo '<script>gtag("event", "Purchase", {
		  "event_category": "Ecommerce",
          "transaction_id": "'.$order_id.'",
          "affiliation": "'.$order->get_customer_id().'",
          "value": 0,
          "currency": "EUR",
          "tax": 0,
          "shipping": 0,
          "items": [';
        
        $line_items = $order->get_items();
       
        foreach ( $order->get_items() as $item_key => $item ) {
	       $product = $order->get_product_from_item( $item );
	       $sku = $product->get_sku();
        
            echo '{
              "id": "'.$sku.'",
              "name": "'.$product->get_name().'",
              "brand": "Indasec",';
              
            $terms = get_the_terms( $item['product_id'], 'product_cat' );
            foreach ( $terms as $term ) {
            // Categories by slug
            $product_cat_slug= $term->slug;
                echo '"category": "'.$product_cat_slug.'",';
            }
           
            echo '"price": 0,
			"quantity": 1}';
        }
        
        echo ']});</script>';
   }		
   
}    



//Tracking para cuando se visualiza la ficha de un producto y se crea el evento para el botón de añadir al carrito el producto
add_action( 'woocommerce_after_single_product_summary', 'track_add_cart', 30 );
function track_add_cart(){
    global $product;
    
    //evento de la visualización de la ficha de producto
    echo '<script> gtag("event","View_item",{"event_category":"Ecommerce","event_label":"'.$product->get_sku().' - '.$product->get_name().'"});</script>';
    
    //evento al añadir al carrito
    echo '<script>( function($){	
    $(".single_add_to_cart_button").click(function() {
		 gtag("event","Add_to_cart",{"event_category":"Ecommerce","event_label":"'.$product->get_sku().' - '.$product->get_name().'"});
	});})(jQuery);</script>';
}




//******************************
//******************************
//*****Tracking de eventos
//******************************
//******************************




// register add to cart action
/*
function dac_add_cart_button () {
    add_action( 'woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_add_to_cart', 10 );
}
add_action( 'after_setup_theme', 'dac_add_cart_button' );

*/



//control del texto del botón añadir al carrito.

add_filter( 'woocommerce_product_single_add_to_cart_text', 'woo_custom_cart_button_text' );    // 2.1 +
function woo_custom_cart_button_text() {
 
        return __( 'quiero mi muestra', 'woocommerce' );
 
}


/* Quitar mensaje de "Producto X se ha añadido a tu carrito" */
 
add_filter( 'wc_add_to_cart_message_html', '__return_null()' );


/*
Change Place Order button text on checkout page in woocommerce
*/
add_filter('woocommerce_order_button_text','custom_order_button_text',1);
function custom_order_button_text($order_button_text) {
	
	$order_button_text = 'Quiero mi muestra';
	
	return $order_button_text;
}



/* sobreescritura del carrito y Redirecciones del checkout */
add_filter( 'woocommerce_add_to_cart_validation', 'one_cart_item_at_the_time', 10, 3 );
function one_cart_item_at_the_time( $passed, $product_id, $quantity ) {
    if( ! WC()->cart->is_empty())
        WC()->cart->empty_cart();
    return $passed;
}
add_filter( 'woocommerce_add_to_cart_redirect', 'add_to_cart_checkout_redirection', 10, 1 );
function add_to_cart_checkout_redirection( $url ) {
    return wc_get_checkout_url();
}
add_action('template_redirect', 'skip_cart_page_redirection_to_checkout');
function skip_cart_page_redirection_to_checkout() {
    if( is_cart() )
        wp_redirect( wc_get_checkout_url() );
}

/* sobreescritura del carrito y Redirecciones del checkout */









add_action('woocommerce_checkout_before_order_review', 'displays_cart_products_feature_image');
function displays_cart_products_feature_image() {
    foreach ( WC()->cart->get_cart() as $cart_item ) {
        $item = $cart_item['data'];
        echo "<!--";
		//print_r($item);
		echo "-->";
        if(!empty($item)){
            $product = new WC_product($item->id);
            // $image = wp_get_attachment_image_src( get_post_thumbnail_id( $product->ID ), 'single-post-thumbnail' );
			echo "<div style='text-align: center;'>";
            echo "<h5 style='color: #666666;'>".$product->name."</h5>";
			echo $product->get_image();
			echo "</div>";
            // break;
        }
    }
}







// Acuam

// Para modificar el aspecto de los posts
function divi_child_theme_setup() {
	if ( class_exists('ET_Builder_Module')) {
		get_template_part( 'custom/cbm' );
		$cbm = new WPC_ET_Builder_Module_Blog();
		remove_shortcode( 'et_pb_blog' );
		add_shortcode( 'et_pb_blog', array($cbm, '_shortcode_callback') );
	}
}
add_action('wp', 'divi_child_theme_setup', 9999);



// Modificar el meta de los posts
function et_divi_post_meta_acuam() {
	$postinfo = is_single() ? et_get_option( 'divi_postinfo2' ) : et_get_option( 'divi_postinfo1' );
	
	if ( $postinfo ) :
	echo '<p class="post-meta">';
	echo et_pb_postinfo_meta_acuam( $postinfo, et_get_option( 'divi_date_format', 'j M, Y' ), esc_html__( '0 comments', 'Divi' ), esc_html__( '1 comment', 'Divi' ), '% ' . esc_html__( 'comments', 'Divi' ) );
	echo '</p>';
	endif;
}

if ( ! function_exists( 'et_pb_postinfo_meta_acuam' ) ) :
function et_pb_postinfo_meta_acuam( $postinfo, $date_format, $comment_zero, $comment_one, $comment_more ){
	$postinfo_meta = '';
	
	if ( in_array( 'author', $postinfo ) )
		$postinfo_meta .= ' ' . esc_html__( 'by', 'et_builder' ) . ' <span class="author vcard">' . et_pb_get_the_author_posts_link() . '</span>';
		
		if ( in_array( 'date', $postinfo ) ) {
			if ( in_array( 'author', $postinfo ) ) $postinfo_meta .= ' | ';
			$postinfo_meta .= '<span class="published">' . esc_html( get_the_time( wp_unslash( $date_format ) ) ) . '</span>';
		}
		
		if ( in_array( 'categories', $postinfo ) ) {
			$categories_list = get_the_category_list(', ');
			
			// do not output anything if no categories retrieved
			if ( '' !== $categories_list ) {
				if ( in_array( 'author', $postinfo ) || in_array( 'date', $postinfo ) )	$postinfo_meta .= ' | ';
				
				$postinfo_meta .= $categories_list;
			}
		}
		
		if ( in_array( 'comments', $postinfo ) ){
			if ( in_array( 'author', $postinfo ) || in_array( 'date', $postinfo ) || in_array( 'categories', $postinfo ) ) $postinfo_meta .= ' | ';
			$postinfo_meta .= et_pb_get_comments_popup_link( $comment_zero, $comment_one, $comment_more );
		}
		
		return $postinfo_meta;
}
endif;





/*

// Para poder mostrar categorias determinadas 
function custom_category_widget($args) {
	$include = "62,135,72"; 
	$args["include"] = $include;
	return $args;
}
add_filter("widget_categories_dropdown_args","custom_category_widget");

include ( get_stylesheet_directory().'/custom/categories_widget.php');
add_action("widgets_init", "my_custom_widgets_init");
function my_custom_widgets_init(){
	register_widget("MY_WP_Widget_Categories");
}
*/
// Dudas de mujer
include ( get_stylesheet_directory().'/dudas_de_mujer.php');
add_shortcode ('ddm', 'insertarddm');


?>