<?php

if (!class_exists('EcwidRandomProductsPaidEcwidStore'))
	require_once RANDOM_PRODUCTS_DIR . 'classes/PaidEcwidStore.php';

class EcwidRandomProductsPaidCachedEcwidStore extends EcwidRandomProductsPaidEcwidStore {

	private $products;
	private $categories;
	private $profile;

	public function getRandomProducts($howMany) {

		$products = $this->getProductsInternal();

		if (is_array($products)) {

			return self::randomizeProducts($howMany, $products);

		} else {
		
			return null;

		}

	}

	public function getProfile() {

		if (!isset($this->profile)) {

			$profile = EcwidRandomProductsCache::getCache('profile');

			if (is_null($profile)) {

				$EcwidProductApi = new EcwidProductApi(get_ecwid_store_id());
				$profile = $EcwidProductApi->get_profile();

				try {

					EcwidRandomProductsCache::putCache('profile', $profile);

				} catch (Exception $e) {

					// Info was not added to cache

				}

			}

			$this->profile = $profile;

		}

		return $this->profile;

	}

	public function getProduct($productid) {
		
		$products = $this->getProductsInternal(); 

		if (is_array($products) && isset($products[$productid])) {
	
			return $products[$productid];

		} else {
		
			null;

		}

	}

        public function getRandomProductsByCategoryId($howMany, $categoryId) {

		$categoryId = (int) $categoryId;

		if (0 >= $categoryId)
			return null;

                $products = $this->getProductsByCategoryId($categoryId);

                if (is_array($products)) {

	                return self::randomizeProducts($howMany, $products);

		} else {

			return null;

		}

        }

	public function getProductsByCategoryId ($categoryId) {

		$return = null;

		$currentCategory = $this->getCategory($categoryId);

		if (is_array($currentCategory) && isset($currentCategory['products']) && is_array($currentCategory['products'])) {

			foreach ($currentCategory['products'] as $productid) {

				$return[] = $this->getProduct($productid);		
	
			}

		}

		return $return;

	}

	private function getCategory($categoryId) {

		$categories = $this->getCategoriesInternal();

		if (is_array($categories) && isset($categories[$categoryId])) {

			return $categories[$categoryId];
	
		} else {
		
			return null;

		}

	}

	private function getCategoriesInternal() {

		if (!isset($this->categories)) {

			$categories = EcwidRandomProductsCache::getCache('categories');

			if (is_null($categories)) {

				$EcwidProductApi = new EcwidProductApi(get_ecwid_store_id());;
				$rawCategories = $EcwidProductApi->get_all_categories();

				if (is_array($rawCategories)) {

		                        foreach ($rawCategories as $category) {

						$categoryId = $category['id'];
						$currentCategory = $category;

        	        	                $products = $EcwidProductApi->get_products_by_category_id($categoryId);
	
						if (is_array($products)) {

                                                        foreach ($products as $product) {

                                                        	$currentCategory['products'][] = $product['id'];

                                                        }


						} else {

							$currentCategory['products'] = null;

						}
				
						$categories[$categoryId] = $currentCategory;

        	                	}

				}

				try {

					EcwidRandomProductsCache::putCache('categories', $categories);

				} catch (Exception $e) {

					// Cache was not created

				}

			}

			$this->categories = $categories;

		}

		return $this->categories;

	}

	private function getProductsInternal() {

		if (!isset($this->products)) {

			$products = EcwidRandomProductsCache::getCache('products');

			if (!is_array($products)) {

				$EcwidProductApi = new EcwidProductApi(get_ecwid_store_id());;

				$rawProducts = $EcwidProductApi->get_all_products();

				foreach ($rawProducts as $product) {

					$products[$product['id']] = $product;

				}

				EcwidRandomProductsCache::putCache('products', $products);

			}

			$this->products = $products;

		}

		return $this->products;

	}

}
