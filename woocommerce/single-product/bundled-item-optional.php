<?php
/**
 * Optional Bundled Item Checkbox template
 *
 * Override this template by copying it to 'yourtheme/woocommerce/single-product/bundled-item-optional.php'.
 *
 * On occasion, this template file may need to be updated and you (the theme developer) will need to copy the new files to your theme to maintain compatibility.
 * We try to do this as little as possible, but it does happen.
 * When this occurs the version of the template file will be bumped and the readme will list any important changes.
 *
 * @version 5.0.2
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}
if(class_exists('FlycartWooDiscountRulesPricingRules')){
    global $product;
    $price_rules = new FlycartWooDiscountRulesPricingRules();
    $price_html = $price_rules->replaceVisiblePrices($bundled_item->product->get_price(),$bundled_item->product);
    if($bundled_item->product->get_price() == $price_html){
        $price_html = $bundled_item->product->get_price_html();
    }

    $price_html = '(+' . $price_html. ')';

    $product_to_apply = array();
    $product_rule_data = $price_rules->generateDiscountTableData($product);
    $matched_rule = getProductRulebyTitle($product_rule_data[0][0]->title);

    if(!empty($matched_rule)){
        $product_condition = $matched_rule->meta['product_based_condition'];
        if(!empty($product_condition)){
            $conditions = json_decode($product_condition[0]);
            $product_to_apply = $conditions->product_to_apply;
        }
    }

    //check if product id is included on the list of products with discounts
    if(in_array($bundled_item->item_data['product_id'], $product_to_apply)){
        //create a discounted price html
        $discount_type = $product_rule_data[0][0]->discount_type;
        $discount = $product_rule_data[0][0]->to_discount;
        if($discount_type == 'percentage_discount'){
            $total_discount = $bundled_item->product->get_price() * ($discount / 100 );
            $discounted_price = $bundled_item->product->get_price() - $total_discount;
            if(class_exists('FlycartWoocommerceProduct')){
                $price_to_display = FlycartWoocommerceProduct::wc_price($discounted_price);
                $show_original = 0;
                if(FlycartWoocommerceVersion::wcVersion('3.0'))
                    $price_to_display = $price_rules->checkForHighestVariantIfExists($bundled_item->product, $price_to_display, $show_original);
                    $price_html = '+'.$price_to_display." (".$discount."% Off)";
            }
        }
    }

} else {
    $price_html = $bundled_item->product->get_price_html();
    $price_html = '(+' . $price_html. ')';
}
?><label class="bundled_product_optional_checkbox">
    <?php
    //$price_html         = $bundled_item->product->get_price_html();
    $label_price        = $bundled_item->is_priced_individually() && $price_html ? sprintf( __( ' for %s', 'woocommerce-product-bundles' ), '<span class="price">' . $price_html. '</span>' ) : '';
    $label_title        = $bundled_item->get_title() === '' ? sprintf( __( ' &quot;%s&quot;', 'woocommerce-product-bundles' ), WC_PB_Helpers::format_product_shop_title( $bundled_item->get_raw_title(), ( $quantity > 1 && $bundled_item->get_quantity( 'max' ) === $quantity ) ? $quantity : '' ) ) : '';
    $label_stock_status = '';

    if ( false === $bundled_item->is_in_stock() ) {

        $availability      = $bundled_item->get_availability();
        $availability_html = empty( $availability[ 'availability' ] ) ? '' : esc_html( $availability[ 'availability' ] );
        if ( $availability_html ) {
            $label_stock_status = sprintf( _x( ' &mdash; %s', 'optional label stock status', 'woocommerce-product-bundles' ), '<span class="bundled_item_stock_label stock out-of-stock">' . $availability_html . '</span>' );
        }
    }

    echo sprintf( __( 'Add%1$s%2$s%3$s', 'woocommerce-product-bundles' ), $label_title, $label_price, $label_stock_status );

    ?>
</label>
