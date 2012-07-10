<?php
/*
* Per Product shipping
* @package    Jigoshop
* @category   Checkout
* @author     Roberto Hiribarne Guedes
* @license    GPL
 */

class pp_shipping extends jigoshop_shipping_method {
  public function __construct() {
    $this->id = 'pp_shipping';
    $this->enabled = get_option('jigoshop_pp_shipping_enabled');
    $this->title = get_option('jigoshop_pp_shipping_title');
    
    if (isset($_SESSION['chosen_shipping_method_id']) && $_SESSION['chosen_shipping_method_id'] == $this->id) {
      $this->chosen = true;
    }
    
    add_action('jigoshop_update_options', array(&$this, 'process_admin_options'));
    add_option('jigoshop_pp_shipping_title', 'Per Product Shipping');
  }
  public function calculate_shipping() {
    //$this->shipping_total = $this->cost + $this->get_fee( $this->fee, jigoshop_cart::$cart_contents_total );
    //$this->shipping_total = 10;
    //$this->shipping_tax = 0;
    $this->shipping_label = $this->title;
    
    // Shipping per item
    if (sizeof(jigoshop_cart::$cart_contents) > 0) {
      foreach (jigoshop_cart::$cart_contents as $item_id => $values) {
        $_product = $values['data'];
        if ($_product->exists() && $values['quantity'] > 0 && $_product->product_type != 'downloadable') {
          //$item_shipping_price = ($this->cost + $this->get_fee( $this->fee, $_product->get_price() )) * $values['quantity'];
          $shipping_key = 'shipping-price';
          if (isset($_product->attributes[$shipping_key]) && isset($_product->attributes[$shipping_key]['value']) && 
              is_numeric($_product->attributes[$shipping_key]['value'])) {
                $product_shipping_price = $_product->attributes[$shipping_key]['value'];
          } else {
                $product_shipping_price = 0;
          }
          
          $item_shipping_price = ($this->cost + $product_shipping_price) * $values['quantity'];
          $this->shipping_total = $this->shipping_total + $item_shipping_price;
        }
      }
    }
  }
  
  public function admin_options() {
  ?>
      <thead>
        <tr>
          <th scope="col" width="200px"><?php _e('Per Product Shipping', 'jigoshop'); ?></th><th scope="col" class="desc">&nbsp;</th>
        </tr>
      </thead>
      <tr>
        <td class="titledesc"><?php _e('Enable Per Product Shipping', 'jigoshop') ?>:</td>
        <td class="forminp">
          <select name="jigoshop_pp_shipping_enabled" id="jigoshop_pp_shipping_enabled" style="min-width:100px;">
            <option value="yes" <?php if (get_option('jigoshop_pp_shipping_enabled') == 'yes') echo 'selected="selected"'; ?>><?php _e('Yes', 'jigoshop'); ?></option>
            <option value="no" <?php if (get_option('jigoshop_pp_shipping_enabled') == 'no') echo 'selected="selected"'; ?>><?php _e('No', 'jigoshop'); ?></option>
          </select>
        </td>
      </tr>
    <tr>
      <td class="titledesc"><a href="#" tip="<?php _e('This controls the title which the user sees during checkout.','jigoshop') ?>" class="tips" tabindex="99"></a><?php _e('Method Title', 'jigoshop') ?>:</td>
      <td class="forminp">
        <input type="text" name="jigoshop_pp_shipping_title" id="jigoshop_pp_shipping_title" style="min-width:50px;" value="<?php if ($value = get_option('jigoshop_pp_shipping_title')) echo $value; else echo 'Per Product Shipping'; ?>" />
      </td>
    </tr>
  <?php
  }

  public function process_admin_options() {
    if(isset($_POST['jigoshop_pp_shipping_enabled'])) 
      update_option('jigoshop_pp_shipping_enabled', jigowatt_clean($_POST['jigoshop_pp_shipping_enabled'])); 
    else 
      @delete_option('jigoshop_pp_shipping_enabled');
    
    if(isset($_POST['jigoshop_pp_shipping_title'])) 
      update_option('jigoshop_pp_shipping_title', jigowatt_clean($_POST['jigoshop_pp_shipping_title'])); 
    else 
      @delete_option('jigoshop_pp_shipping_title');
  }

} // class

function add_pp_shipping_method( $methods ) {
  $methods[] = 'pp_shipping';
  return $methods;
}

add_filter('jigoshop_shipping_methods', 'add_pp_shipping_method' );

