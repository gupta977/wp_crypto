<?php
class Crypto_Generate_Json
{

	public function __construct()
	{

		add_action('crypto_ipfs_upload', array($this, 'create_json'), 10, 1);
	}

	public function create_json($domain)
	{
		$uploaddir = wp_upload_dir();
		$base_path =  $uploaddir['path'] . "/w3d/"; //upload dir.
		//crypto_log($base_path);
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
		$info['records'][50]['type'] = 'web_url';
		$info['records'][50]['value'] = get_site_url();
		$info['records'][51]['type'] = 'web3_url';
		$info['records'][51]['value'] = "";


		$primary = crypto_split_domain($domain, 'primary');
		$second = crypto_split_domain($domain, 'subdomain');

		if ($primary == '') {
			$primary = $second;
			$second = "";
		}

		$svg_data = '<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="100%" height="100%" viewBox="0 0 250 250" version="1.1" class="signid_body">
		<style>
			.signid_body {
				background: linear-gradient(-45deg, #ee7752, #e73c7e, #23a6d5, #23d5ab);
				background-size: 400% 400%;
				animation: fgradient 15s ease infinite;
				height: 100vh;
			}

			  @keyframes fgradient {
				0% {
					background-position: 0% 50%;
				}

				50% {
					background-position: 100% 50%;
				}

				100% {
					background-position: 0% 50%;
				}
			}
		</style>

		<g id="web3domain" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
		<g transform="matrix(1.3333334 0 0 1.3333334 0 0)">
	  <image  x="30" y="0" xlink:href="data:image/png;base64,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" width="125" height="125"/>
  </g>
  <g id="Group-6" transform="translate(70.000000, 154.000000)">
  <g id="Group" transform="translate(5.000000, 43.000000)">
	  <rect x="-15" y="0" width="130" height="34" stroke="#363636" stroke-width="2.112px" rx="17" />
	  <text dominant-baseline="middle" text-anchor="middle" font-size="16" font-weight="bold" fill="#363636" font-family="system-ui, -apple-system, BlinkMacSystemFont, Oxygen, Cantarell, sans-serif">
		  <tspan x="20%" y="20">.' . $primary . '</tspan>
	  </text>
  </g>
  <text text-anchor="middle" id="domain" font-family="system-ui, -apple-system, BlinkMacSystemFont, Roboto, Ubuntu, Oxygen, Cantarell, sans-serif" font-size="24" font-weight="bold" fill="#ffffff">
	  <tspan x="22%" y="26">' . $second . '</tspan>
  </text>
</g>


	  </g>
	</svg>';


		$info['image_data'] = $svg_data;
		$data = json_encode($info);
		$file_name = strtolower($domain) . '.json';
		$save_path = $base_path . '/' . $file_name;
		$f = @fopen($save_path, "w") or die(print_r(error_get_last(), true)); //if json file doesn't gets saved, uncomment this to check for errors
		fwrite($f, $data);
		fclose($f);
	}
}
$gen_json = new Crypto_Generate_Json();