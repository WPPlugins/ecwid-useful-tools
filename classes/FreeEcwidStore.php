<?php

if (!interface_exists('EcwidRandomProductsEcwidStore'))
        require_once RANDOM_PRODUCTS_DIR . 'classes/IEcwidStore.php';

class EcwidRandomProductsFreeEcwidStore implements EcwidRandomProductsEcwidStore{

	protected $EcwidProductApi;
	protected $products;

	public function __construct() {

                $this->EcwidProductApi = new EcwidProductApi(get_ecwid_store_id());

	}

	public function getRandomProducts($howMany) {

		$return = $this->EcwidProductApi->get_random_products($howMany);

		if (is_array($return)) {

			return $return;

		} else {
			return null;

		}
	
	}

	public function getProfile() { 

		throw new Exception ('This is free Ecwid Account and its Product API features are limited. Consider upgrading your Ecwid.');

	}

	public function getProduct($productid) { 

		$products = $this->getProductsInternal();

		if (is_array($products) && isset($products[$productid])) {

			return $products[$productid];

		} else {

			return null;
		}

	}

	public function getProductsByCategoryId($categoryId) {
		
		throw new Exception ('This is free Ecwid Account and its Product API features are limited. Consider upgrading your Ecwid.');

        }

	public function getRandomProductsByCategoryId($howMany, $categoryId) {

		return $this->getProductsByCategoryId($categoryId);

	}

	protected function getProductsInternal() {

		if (!isset($this->products)) {

			$config = EcwidRandomProductsCoreSettings::getInstance();

			if ($config->useCache()) {

				$products = EcwidRandomProductsCache::getCache('products');
	
				if (is_array($products)) {

					$this->products = $products;

					return $this->products;

				}

			}

			$rawProducts = $this->EcwidProductApi->get_random_products(10000000);

			if (is_array($rawProducts)) {

				foreach ($rawProducts as $product) {

					$products[$product['id']] = $product;
	
				}

				if ($config->useCache()) {

					EcwidRandomProductsCache::putCache('products', $products);

				}

				$this->products = $products;

			} else {

				$this->products = null;

			}

		}

		return $this->products;

	}

}
