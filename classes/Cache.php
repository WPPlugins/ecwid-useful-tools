<?php

class EcwidRandomProductsCache {

	public function putCache ($name, $object) {

		if (false === self::isCacheFolderAvailable())
			throw new Exception ('Cannot create cache for ' . $name . ' entity. Cache directory is unavailable.');

		if ($fp = @fopen(self::generateFilename($name), 'w+')) {

			fwrite ($fp, serialize($object));
			fclose ($fp);

		} else {

			throw new Exception ('Cannot create cache for ' . $name . ' entity. Cannot write the file.');

		}

	}

	public function getCache ($name) {

		$return = null;
		$filename = self::generateFilename($name);

                if ($fp = @fopen($filename, 'r+')) {

                        $return = fread($fp, filesize($filename));
			$return = unserialize($return);
                        fclose ($fp);

                } 

		return $return;

	}

	private function generateFilename($name) {

		return EcwidRandomProductsCoreSettings::getCacheDirectory() . $name . '.txt';

	}

	public function isCacheFolderAvailable () {

		$directory = EcwidRandomProductsCoreSettings::getCacheDirectory();

		if (@opendir($directory) || @mkdir($directory)) {

			return true;

		} else {

			throw new Exception ('Cache folder is unavailable and cannot be created.');

		}

	}

	public function clearCache() {

		$directory = EcwidRandomProductsCoreSettings::getCacheDirectory();

		try {

			self::isCacheFolderAvailable();

		} catch (Exception $e) {

			throw new $e;	

		}

		if ($directory_handler = opendir($directory)) {

			while (false !== ($file = readdir($directory_handler))) {

				if (preg_match('/.txt$/', $file) && $file != '.' && $file != '..') {

					unlink($directory . $file);

				}

			}

		}

	}

}
