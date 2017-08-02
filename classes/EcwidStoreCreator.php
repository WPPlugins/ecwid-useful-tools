<?php

// Singleton 
class EcwidRandomProductsEcwidStoreCreator {

	private static $instance;

	public function getInstance() {

		$settings = EcwidRandomProductsCoreSettings::getInstance();

		if (!isset(self::$instance)) {

			if (false === $settings->isFreeAccount())
	
		                if (true === $settings->useCache()) {

        		                self::$instance = new EcwidRandomProductsPaidCachedEcwidStore();

		                } else {

        		                self::$instance = new EcwidRandomProductsPaidEcwidStore();

                	} else {

				self::$instance = new EcwidRandomProductsFreeEcwidStore();

			}

		}

		return self::$instance;

	}

}
