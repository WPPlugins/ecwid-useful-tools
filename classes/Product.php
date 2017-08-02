<?php

class EcwidRandomProductsProduct {

	private $id;
	private $categoryId;
	private $price;
	private $name;
	private $thumbnailUrl;
	private $productUrl;

	public function __construct ($id = 0) {

		$id = (int) $id;

		if ($id < 0)
			throw new Exception ('Incorrect productd ID.');

		$this->id = $id;

		$config = EcwidRandomProductsCoreSettings::getInstance();
		$ecwidStore = EcwidRandomProductsEcwidStoreCreator::getInstance();

		$product = $ecwidStore->getProduct($id);

		if (!is_array($product))
			throw new Exception ('Cannot get product data.');
		
		$this->thumbnailUrl = $product['thumbnailUrl'];

		if (get_ecwid_protocol() == "https") {

			$this->thumbnailUrl = str_replace($search = 'http://', $replacement = 'https://', $this->thumbnailUrl);

		}

		$this->name = $product['name'];
		$this->price = sprintf('%01.2f', $product['price']);

		preg_match('/(.*)(#!\/~\/)(.*)/', $product['url'], $matches);
		$productUrlSuffix = $matches[2] . $matches[3]; 

		$this->productUrl = $config->getEcwidPageUrl()
      	                    . (($config->isSeoCatalogEnabled()) ? '?ecwid_product_id=' . $this->id : '')
                            . $productUrlSuffix; 

	}

	public function getName() {

		return $this->name;
	
	}

	public function getCategoryId() {

		return $this->categoryId;

	}

	public function getPrice() {

		return $this->price;

	}

	public function getThumbnailUrl() {

		return $this->thumbnailUrl;

	}

	public function getProductUrl() {

		return $this->productUrl;

	}

}
