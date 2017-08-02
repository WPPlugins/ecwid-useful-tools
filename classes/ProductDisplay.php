<?php

class EcwidRandomProductsProductDisplay {

	private function showProductsTable(	EcwidRandomProductsProductGroup $productData,
					  	EcwidRandomProductsProductSettings $settings ) {

		$config = EcwidRandomProductsCoreSettings::getInstance();

                if (!$config->canShowProducts()) {

                        return 'Ecwid page does not exist. Refer to <a href="http://kb.ecwid.com/w/page/15853324/WordPress#IhaveaccidentallydeletedmystorepageinWordPresswhatshouldIdonow">the article</a> in Ecwid&amp; KB in order to restore it.';

                }

		$products = $productData->getProducts();

		if (is_array($products)) {

			$productCounter = 0;
                        $widthString = ($settings->getProductWidth() > 0) ? ' width=' . $settings->getProductWidth() . ' ' : '';

        	        $return = '<div class="ecwid-random-products"><table>';
	
	                foreach ($products as $product) {

				$productCounter += 1;

                	        if (0 == (($productCounter - 1) % ($settings->howManyPerRow())))
        	                        $return .= '<tr>';

        	                $return .= '<td' . $widthString . '>' . self::showProduct($product, $settings) . '</td>';

				if (0 == ($productCounter % ($settings->howManyPerRow())) && count($products) != $productCounter)
                        	        $return .= '</tr>';

        	        }

	                $return .= '</tr></table></div>';

		} else {

			throw new Exception ('Product data is invalid.');

		}

		return $return;

	}

	public function showProductsInternal ($atts) {

	        $showPrice      = (bool) $atts['show_price'];
        	$showTitle      = (bool) $atts['show_title'];
	        $productWidth   = (int) $atts['product_width'];
        	$howManyPerRow  = (int) $atts['per_row'];
	        $howMany        = (int) $atts['number'];
        	$categoryId     = (int) $atts['category'];

	        try {

        	        $settings = new EcwidRandomProductsProductSettings($showTitle, $showPrice, $productWidth, $howManyPerRow);
                	$products = new EcwidRandomProductsProductGroup($howMany, $categoryId);

	                $return = self::showProductsTable($products, $settings);

        	} catch (Exception $e) {

                	$return = 'Cannot generate shortcode for this configuration.<br />';
	                $return .= $e->getMessage();

        	}

		return $return;

	}

	public function showProducts ($atts) {

		$return = '<!--mfunc echo EcwidRandomProductsProductDisplay::showProductsInternal(' . var_export($atts, true) . ')-->';
		$return .= self::showProductsInternal($atts);
		$return .= '<!--/mfunc-->';

		return $return;

	}

	public function showProduct(	EcwidRandomProductsProduct $product,
					EcwidRandomProductsProductSettings $settings) {

	        $return = '<div class="product" style="text-align: center;">';
        	$return .= '<a href="' . $product->getProductUrl() . '">';
                $return .= '<img src="' . $product->getThumbnailUrl() . '" title="' . $product->getName() . '" class="ecwid-random-thumbnail" />';
                $return .= '</a>';

                if ($settings->showTitle()) {

                        $return .= '<br />';
                        $return .= '<span class="product-name">' . $product->getName() . '</span>';

                }

                if ($settings->showPrice()) {
		
			$config = EcwidRandomProductsCoreSettings::getInstance();
			$currency = $config->getCurrency();

                        $return .= '<br />';
                        $return .= '<span class="product-price">' . $currency['prefix'] . $product->getPrice() . $currency['suffix'] . '</span>';

                }

                $return .= '</div>';

                return $return;		

	}

}
