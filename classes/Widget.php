<?php

// widget class
class EcwidRandomProductsWidget extends WP_Widget {

	function EcwidRandomProductsWidget() {

		$widget_ops = array('description' => __('Displays several random products from your Ecwid store'));

		$this->WP_Widget('ecwid_random_products_random_products_widget', __('Ecwid\'s random products'), $widget_ops );

	}

	function widget($args, $instance) {

		extract ($args);
		extract ($instance);

		$title = apply_filters('widget_title', $instance['title']);

		// output started
		echo $before_widget;

		if ($title && !empty($title)) {
			echo $before_title . $title . $after_title;
		}

		$atts = array (
				'show_price' => $show_price,
				'show_title' => $show_title,
	                        'product_width' => 0,
	                        'per_row' => 1,
        	                'number' => $product_quantity,
                	        'category' => $category,
			);

		echo EcwidRandomProductsProductDisplay::showProducts($atts);

		echo $after_widget;
	}

	function update($new_instance, $old_instance) {

		$return_instance['title'] = strip_tags(stripslashes(($new_instance['title'])));

		$return_instance['product_quantity'] = (intval($new_instance['product_quantity']) > 0 ) ? intval($new_instance['product_quantity']) : 1;

		$return_instance['show_price'] = ('on' == $new_instance['show_price']) ? true : false;

		$return_instance['show_title'] = ('on' == $new_instance['show_title']) ? true : false;

		$return_instance['category'] = (intval($new_instance['category']) > 0 ) ? intval($new_instance['category']) : 0;

		return $return_instance;
	}

	function form($instance) {

		$defaults = array('title' => '', 'product_quantity' => 1, 'show_title' => false, 'show_price' => false, 'category' => 0);

		$instance = wp_parse_args((array) $instance, $defaults);

		extract ($instance);

		if ($category === 0)
			$category = '';

		echo WPSwiftLib::showWidgetStringSetting($this, 'title', $title, __('Title:'));
	
		echo WPSwiftLib::showWidgetStringSetting($this, 'product_quantity', $product_quantity, __('Number of random products to display:'));

		echo WPSwiftLib::showWidgetCheckboxSetting($this, 'show_title', $show_title, __('Display product\'s title?'));
	
		echo WPSWiftLib::showWidgetCheckboxSetting($this, 'show_price', $show_price, __('Display product\'s price?'));

		echo WPSwiftLib::showWidgetStringSetting($this, 'category', $category, __('Category ID to select products from:'));
	}

}
