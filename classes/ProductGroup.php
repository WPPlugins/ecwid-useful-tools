<?php

class EcwidRandomProductsProductGroup {

	private $products;

	public function __construct($howMany, $parentCategoryId = 0) {

		$ecwidStore = EcwidRandomProductsEcwidStoreCreator::getInstance();

		$howMany 		= (int) $howMany;
		$parentCategoryId 	= (int) $parentCategoryId;

		if ($howMany < 1)
			throw new Exception ('Number of products to display is incorrect');

		if ($parentCategoryId < 0)
			throw new Exception ('Category ID is incorrect');

		if ($parentCategoryId > 0) {

			$products = $ecwidStore->getRandomProductsByCategoryId($howMany, $parentCategoryId);

			if (!is_array($products))
				throw new Exception ('Cannot pull products from category with ID ' . $parentCategoryId . '.');


		} else {

			$products = $ecwidStore->getRandomProducts($howMany);

			if (!is_array($products))
				throw new Exception ('Cannot get Random products for some reason.');

		}

                foreach ($products as $product) {

			$this->products[] = new EcwidRandomProductsProduct($product['id']);

                }

	}

	public function getProducts() {

		return $this->products;

	}

}
