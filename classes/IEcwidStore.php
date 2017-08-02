<?php

interface EcwidRandomProductsEcwidStore {

	public function getRandomProducts($howMany);
	public function getProfile();
	public function getProduct($productid);
	public function getProductsByCategoryId($categoryId);
	public function getRandomProductsByCategoryId($howMany, $categoryId); 

}
