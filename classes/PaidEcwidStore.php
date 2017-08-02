<?php

if (!interface_exists('EcwidRandomProductsEcwidStore'))
        require_once RANDOM_PRODUCTS_DIR . 'classes/IEcwidStore.php';

class EcwidRandomProductsPaidEcwidStore implements EcwidRandomProductsEcwidStore {

	protected $EcwidProductApi;

	public function __construct() {

                $this->EcwidProductApi = new EcwidProductApi(get_ecwid_store_id());

	}

	public function getRandomProducts($howMany) {

		return $this->EcwidProductApi->get_random_products($howMany);
	
	}

	public function getProfile() { 

		return $this->EcwidProductApi->get_profile();

	}

	public function getProduct($productid) { 

		return $this->EcwidProductApi->get_product($productid);

	}

	public function getProductsByCategoryId($categoryId) {

		$categoryId = (int) $categoryId;

		if (0 >= $categoryId)
			return null;

                $products = $this->EcwidProductApi->get_products_by_category_id($categoryId);

                if (is_array($products)) {

                        return $products;

                } else {

                        return null;

                }

        }

	public function getRandomProductsByCategoryId($howMany, $categoryId) {

		$return = null;

		if (0 === $categoryId) {

			$return = $this->getRandomProducts($howMany);

		}

		$products = $this->getProductsByCategoryId($categoryId);

		if (is_array($products)) {

			$return = self::randomizeProducts($howMany, $products);

		}

		return $return;

	}

	protected function randomizeProducts($howMany, $products) {

		if (!is_array($products) || !is_int($howMany))
			return null;

                $countProducts = count($products);
                $productIds = array_keys($products);
                $usedProducts = array();
                $return = null;

                while ($howMany-- > 0) {

                        $key = rand(0, $countProducts - 1);

                        if ($howMany < $countProducts) {

                                while (in_array($key, $usedProducts))
                                        $key = rand(0, $countProducts - 1);

                                $usedProducts[] = $key;

                        }

                        $return[] = $products[$productIds[$key]];

                }

		return $return;
	}
}
