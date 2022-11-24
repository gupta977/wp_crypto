<?php
class Crypto_Generate_Json
{

	public function __construct()
	{

		add_action('crypto_ipfs_upload', array($this, 'create_json'), 10, 1);
	}

	public function create_json($domain)
	{
		//crypto_log("xxxx " . $domain);
		echo "xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx" . $domain;
		$base_path = $_SERVER['DOCUMENT_ROOT'] . "/temp/"; //upload dir.
		if (!is_dir($base_path)) {
			mkdir($base_path);
		}
		$info = array();
		$info['name'] = strtolower($domain);
		$info['description'] = '';
		$info['image'] = '';
		$info['attributes'][0]['trait_type'] = 'domain';
		$info['attributes'][0]['value'] = $domain;
		$info['attributes'][1]['trait_type'] = 'level';
		$info['attributes'][1]['value'] = '2';
		$info['attributes'][2]['trait_type'] = 'length';
		$info['attributes'][2]['value'] = strlen($domain);
	}
}
$gen_json = new Crypto_Generate_Json();
