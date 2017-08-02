<?php

// Singletone
class EcwidRandomProductsCoreSettings {

	private static $instance;

	private $isCorePluginActive = false;
	private $isLocalCurrency;
	private $seoCatalogEnabled;
	private $currency;
	private $ecwidPageUrl;
	private $canShowProducts;
	private $useCache;
	private $isFreeAccount;
	
	private function __construct() {

                require_once(ABSPATH . 'wp-admin/includes/plugin.php');

                $this->isCorePluginActive = is_plugin_active('ecwid-shopping-cart/ecwid-shopping-cart.php');

		if ($this->isCorePluginActive) {

			require_once WP_PLUGIN_DIR . '/ecwid-shopping-cart/ecwid-shopping-cart.php';

			// Make sure that we can create instances of EcwidProductApi class
			if (!class_exists('EcwidProductApi'))
			        require_once WP_PLUGIN_DIR . '/ecwid-shopping-cart/lib/ecwid_product_api.php';

			$EcwidProductApi = new EcwidProductApi(get_ecwid_store_id());

			$result = $EcwidProductApi->get_profile();
			$this->isFreeAccount = (empty($result) || false == $result);

			$this->seoCatalogEnabled = ('on' == get_option('ecwid_noscript_seo_catalog'));

		}

		$this->useCache = ('on' == get_option('ecwid_random_products_use_cache'));

		$this->isLocalCurrency = ('on' == get_option('ecwid_random_products_use_local_currency'));

		$this->currency['local']['prefix'] = get_option('ecwid_random_products_currency_prefix');
                $this->currency['local']['suffix'] = get_option('ecwid_random_products_currency_suffix');

	}

	public function getInstance() {

		if (!isset(self::$instance)) {

			$classname = __CLASS__;
			self::$instance = new $classname();

		}

		return self::$instance;

	}

	public function canShowProducts() {

		if (!isset(self::$instance->canShowProducts)) {

			if (null != self::getEcwidPageUrl()) {

				self::$instance->canShowProducts = self::$instance->isCorePluginActive;

			} else {

				self::$instance->canShowProducts = false;

			}

		}

		return self::$instance->canShowProducts;
	
	}

	public function getEcwidPageUrl() {

		if (!isset(self::$instance->ecwidPageUrl)) {

	                $ecwidPageId = get_option("ecwid_store_page_id");
        	        $pageUrl = get_page_link($ecwidPageId);

			if (!empty($pageUrl) && null != get_page($ecwidPageId)) {

				self::$instance->ecwidPageUrl = $pageUrl;

			} else { 
				
				self::$instance->ecwidPageUrl = null;
		
			}

		}

		return self::$instance->ecwidPageUrl;
	
	}

	public function isSeoCatalogEnabled() {

		return self::$instance->seoCatalogEnabled;

	}

	public function getCurrency() {

		if (!isset($this->currency['prefix']) || !isset($this->currency['suffix'])) {

	                if ($this->isLocalCurrency) {

        	                $this->currency['prefix'] = $this->currency['local']['prefix'];
                	        $this->currency['suffix'] = $this->currency['local']['suffix'];

	                } elseif ($this->isFreeAccount) {
	
				$this->currency['prefix'] = '';
                                $this->currency['suffix'] = '';

			} else {

        	                $ecwidStore = EcwidRandomProductsEcwidStoreCreator::getInstance();
                	        $profile = $ecwidStore->getProfile();

                        	$this->currency['prefix'] = $profile['currencyPrefix'];
        	                $this->currency['suffix'] = $profile['currencySuffix'];
	
                	}

		}

		return $this->currency;

	}

	public function isCorePluginActive() {

		return self::$instance->isCorePluginActive;

	}

	public function isLocalCurrency() {

		return self::$instance->isLocalCurrency;	

	}

	public function useCache() {

		return self::$instance->useCache;

	}

	public function isFreeAccount() {

		return self::$instance->isFreeAccount;
	
	}

	public function getCacheDirectory() {
		
		return RANDOM_PRODUCTS_DIR . 'cache/';	

	}

}
