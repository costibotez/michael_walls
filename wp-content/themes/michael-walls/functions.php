<?php
/* ADD custom theme functions here  */

/* Remove tabs without content - frontend - Product page */
add_filter( 'woocommerce_product_tabs', 'woo_remove_product_tabs', 98 );

function woo_remove_product_tabs( $tabs ) {
	global $post, $product;

	// Additional Information
	if(!$product->has_attributes() && !$product->has_dimensions() && !$product->has_weight() ) {
		unset( $tabs['additional_information'] );
	}
	// Reviews
	unset( $tabs['reviews'] );

    return $tabs;
}

/* Remove SKU - frontend - Product page */

function woo_remove_product_page_skus( $enabled ) {
    if ( ! is_admin() && is_product() ) {
        return false;
    }

    return $enabled;
}
add_filter( 'wc_product_sku_enabled', 'woo_remove_product_page_skus' );

function woo_get_homepage_book( ) {

	ob_start();

    $product_id = wc_get_product_id_by_sku( 'mw-001' );

    if ( $product_id ) {
    	$book = new WC_Product( $product_id );
	}
	else {
		return null;
	}

	echo do_shortcode('[add_to_cart id="'.$product_id.'"]');

	$content = ob_get_contents();
	ob_end_clean();
	return $content;
}

add_shortcode( 'woo_get_homepage_book', 'woo_get_homepage_book' );

// Search website
function search_website($atts) {
	extract(shortcode_atts(array(
		'size' => 'normal',
	), $atts));

	if($size == 'small') $size = 'style="font-size:80%"';
	if($size == 'large') $size = 'style="font-size:150%"';
	if($size == 'xlarge') $size = 'style="font-size:200%"';

	ob_start();

	if(function_exists('get_search_form')){
		echo '<div class="ux-search-box" '.$size.'>';
			get_search_form( TRUE );
		echo '</div>';
	}

	$content = ob_get_contents();
	ob_end_clean();
	return $content;
}

add_shortcode('search_website', 'search_website');

// Publications
function get_publications( ) {

	//https://iris.ucl.ac.uk/iris/browse/profile/publications/paged?upi=MJWAL06&isFirstReq=true&isLastPage=false&pageNum=1&itemsPerPage=100&orderBy=4%20D

	ob_start();

	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, 'https://iris.ucl.ac.uk/iris/browse/profile/publications/paged');
	curl_setopt($ch, CURLOPT_HEADER, FALSE);
	$data = array('upi' => 'MJWAL06', 'isFirstReq' => 'true', 'isLastPage' => 'true', 'pageNum' => '1', 'itemsPerPage' => '100', 'orderBy' => '4%20D');
	curl_setopt($ch, CURLOPT_POST, true);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
	curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
	$response = curl_exec($ch);
	curl_close($ch);

	// Replace href="/iris/ for target="_blank" href="https://iris.ucl.ac.uk/iris/
	$response = str_replace('href="/iris/', 'target="_blank" href="https://iris.ucl.ac.uk/iris/', $response);

	// Replace http://www.redsea-online.com/modules.php?name=News&file=article&sid=995 for http://www.michael-walls.com/product/a-somali-nation-state-history-culture-and-somalilands-political-transition/
	$response = str_replace('http://www.redsea-online.com/modules.php?name=News&file=article&sid=995', 'http://www.michael-walls.com/product/a-somali-nation-state-history-culture-and-somalilands-political-transition/', $response);

	// Remove <img src="/iris/images/icon/icon_ext_res.png"/>
	$response = str_replace('<img src="/iris/images/icon/icon_ext_res.png"/>', '<img style="vertical-align: text-top;" src="http://www.michael-walls.com/images/open-new-window.png" alt="Opne in a new window" />', $response);

	$exit = TRUE;
	$publications = array();

	do {
		// Check if it is Group Name or Publication
		if (strpos($response, '<li class="groupName">') === FALSE) {
			// Find Publication - <div class="leftSideRight" style="width:100%;">
			$response = substr($response, strpos($response, '<div class="leftSideRight" style="width:100%;">') + 47);

			// Publication
			$publication = '<p>' . substr($response, 0, strpos($response, '</div>')) . '<a>';

			// Find Publication Link - <div class="rightSide">
			$response = substr($response, strpos($response, '<div class="rightSide">') + 23);

			// Link
			$publication .= substr($response, 0, strpos($response, '</div>')) . '</a></p>';
			array_push($publications[$key], $publication);
		}
		elseif (strpos($response, '<li class="groupName">') < strpos($response, '<div class="leftSideRight" style="width:100%;">')) {
			// Find Group Name - <li class="groupName">
			$response = substr($response, strpos($response, '<li class="groupName">') + 22);

			// Group Name
			$key = substr($response, 0, strpos($response, '</li>'));
			if (!array_key_exists(substr($response, 0, strpos($response, '</li>')), $publications)) {
				$publications[substr($response, 0, strpos($response, '</li>'))] = array();
			}
		}
		else {
			// Find Publication - <div class="leftSideRight" style="width:100%;">
			$response = substr($response, strpos($response, '<div class="leftSideRight" style="width:100%;">') + 47);

			// Publication
			$publication = '<p>' . substr($response, 0, strpos($response, '</div>')) . '<a>';

			// Find Publication Link - <div class="rightSide">
			$response = substr($response, strpos($response, '<div class="rightSide">') + 23);

			// Link
			$publication .= substr($response, 0, strpos($response, '</div>')) . '</a></p>';
			array_push($publications[$key], $publication);
		}
		if ((strpos($response, '<li class="groupName">') === FALSE) && (strpos($response, '<div class="leftSideRight" style="width:100%;">') === FALSE)) {
			$exit = FALSE;
		}

	} while ($exit);

	ksort($publications);
	foreach ($publications as $key => $value) {
		?>
		<h2><?php echo $key; ?></h2>
		<?php
		for($x = 0; $x < count($value); $x++) {
			echo $value[$x];
		}
    }

	$content = ob_get_contents();
	ob_end_clean();
	return $content;
}

add_shortcode('get_publications', 'get_publications');