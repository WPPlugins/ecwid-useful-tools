<?php

class EcwidRandomProductsProductSettings {

	private $showTitle;
	private $showPrice;
	private $productWidth;
	private $howManyPerRow;

	function __construct($showTitle = false, $showPrice = false, $productWidth = 0, $howManyPerRow = 1) {

		$this->showTitle	= (bool) $showTitle;
		$this->showPrice 	= (bool) $showPrice;
		$this->productWidth 	= (int) $productWidth;
		$this->howManyPerRow 	= (int) $howManyPerRow;

		if ($this->productWidth < 0)
			$this->productWidth = 0;


		if ($this->howManyPerRow < 1)
			$this->howManyPerRow = 1;

	}

	public function showPrice() {

		return $this->showPrice;

	}

	public function showTitle() {

		return $this->showTitle;

	}

	public function getProductWidth() {

		return $this->productWidth;

	}

	public function howManyPerRow() {

		return $this->howManyPerRow;

	}

}
