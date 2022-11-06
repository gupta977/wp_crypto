<?php
class Crypto_Domain_Search
{
	function __construct()
	{

		add_shortcode('crypto-domain-search', array($this, 'search'));

		add_filter('crypto_settings_tabs', array($this, 'add_tabs'));
		add_filter('crypto_settings_sections', array($this, 'add_section'));
		add_filter('crypto_settings_fields', array($this, 'add_fields'));

		add_filter('crypto_dashboard_tab', array($this, 'dashboard_add_tabs'));
		add_action('crypto_dashboard_tab_content', array($this, 'dashboard_add_content'));
	}

	//add_filter flexi_settings_tabs
	public function add_tabs($new)
	{

		$tabs = array(
			'marketplace'   => __('Marketplace', 'crypto'),

		);
		$new  = array_merge($new, $tabs);

		return $new;
	}


	//Add Section title
	public function add_section($new)
	{

		$sections = array(
			array(
				'id' => 'crypto_marketplace_settings',
				'title' => __('Sell Web3 Domain Name', 'crypto'),
				'description' => __('Sell your own web3 domain name like ENS, unstoppable. ', 'crypto') . "<br>" . "<b>Shortcode examples</b><br><code> [crypto-price symbol=\"BTC\"] </code><br><code>[crypto-price symbol=\"MATIC,BTC,XRP\" style=\"style1\"]</code><br><code>[crypto-price symbol=\"BTC\" style=\"style1\" currency=\"INR\" color=\"fl-is-warning\"]</code>",
				'tab' => 'marketplace',
			),
		);
		$new = array_merge($new, $sections);

		return $new;
	}

	//Add section fields
	public function add_fields($new)
	{
		$fields = array(
			'crypto_marketplace_settings' => array(
				array(
					'name' => 'base_curr',
					'label' => __('Currency', 'crypto'),
					'description' => __('Select your primary currency', 'crypto'),
					'type' => 'select',
					'options' => array(
						'USD' => __('United States Dollar ($) USD', 'crypto'),
						'ALL' => __('Albanian Lek (L)', 'crypto'),
						'DZD' => __('Algerian Dinar (د.ج)	DZD', 'crypto'),
						'ARS' => __('Argentine Peso ($)	ARS', 'crypto'),
						'AMD' => __('Armenian Dram (֏)	AMD', 'crypto'),
						'AUD' => __('Autralian Dollar ($)	AUD', 'crypto'),
						'AZN' => __('Azerbaijani Manat (₼)	AZN', 'crypto'),
						'BHD' => __('Bahraini Dinar (.د.ب)	BHD', 'crypto'),
						'BDT' => __('Bangladeshi Taka (৳)	BDT', 'crypto'),
						'BYN' => __('Belarusian Ruble (Br)	BYN', 'crypto'),
						'BMD' => __('Bermudan Dollar ($)	BMD', 'crypto'),
						'BOB' => __('Bolivian Boliviano (Bs.)	BOB', 'crypto'),
						'BAM' => __('Bosnia-Herzegovina Convertible Mark (KM)	BAM', 'crypto'),
						'BRL' => __('Brazilian Real (R$)	BRL', 'crypto'),
						'BGN' => __('Bulgarian Lev (лв)	BGN', 'crypto'),
						'KHR' => __('Cambodian Riel (៛)	KHR', 'crypto'),
						'CAD' => __('Canadian Dollar ($)	CAD', 'crypto'),
						'CLP' => __('Chilean Peso ($)	CLP', 'crypto'),
						'CNY' => __('Chinese Yuan (¥)	CNY', 'crypto'),
						'COP' => __('Colombian Peso ($)	COP', 'crypto'),
						'CRC' => __('Costa Rican Colón (₡)	CRC', 'crypto'),
						'HRK' => __('Croatian Kuna (kn)	HRK', 'crypto'),
						'CUP' => __('Cuban Peso ($)	CUP', 'crypto'),
						'CZK' => __('Czech Koruna (Kč)	CZK', 'crypto'),
						'DKK' => __('Danish Krone (kr)	DKK', 'crypto'),
						'DOP' => __('Dominican Peso ($)	DOP', 'crypto'),
						'EGP' => __('Egyptian Pound (£)	EGP', 'crypto'),
						'EUR' => __('Euro (€)	EUR', 'crypto'),
						'EUR' => __('Georgian Lari (₾)	GEL', 'crypto'),
						'GHS' => __('Ghanaian Cedi (₵)	GHS', 'crypto'),
						'GTQ' => __('Guatemalan Quetzal (Q)	GTQ', 'crypto'),
						'HNL' => __('Honduran Lempira (L)	HNL', 'crypto'),
						'HKD' => __('Hong Kong Dollar ($)	HKD', 'crypto'),
						'HUF' => __('Hungarian Forint (Ft)	HUF', 'crypto'),
						'ISK' => __('Icelandic Króna (kr)	ISK', 'crypto'),
						'INR' => __('Indian Rupee (₹)	INR', 'crypto'),
						'IDR' => __('Indonesian Rupiah (Rp)	IDR', 'crypto'),
						'IRR' => __('Iranian Rial (﷼)	IRR', 'crypto'),
						'IQD' => __('Iraqi Dinar (ع.د)	IQD', 'crypto'),
						'ILS' => __('Israeli New Shekel (₪)	ILS', 'crypto'),
						'JMD' => __('Jamaican Dollar ($)	JMD', 'crypto'),
						'JPY' => __('Japanese Yen (¥)	JPY', 'crypto'),
						'JOD' => __('Jordanian Dinar (د.ا)	JOD', 'crypto'),
						'KZT' => __('Kazakhstani Tenge (₸)	KZT', 'crypto'),
						'KES' => __('Kenyan Shilling (Sh)	KES', 'crypto'),
						'KWD' => __('Kuwaiti Dinar (د.ك)	KWD', 'crypto'),
						'KGS' => __('Kyrgystani Som (с)	KGS', 'crypto'),
						'LBP' => __('Lebanese Pound (ل.ل)	LBP', 'crypto'),
						'MKD' => __('Macedonian Denar (ден)	MKD', 'crypto'),
						'MYR' => __('Malaysian Ringgit (RM)	MYR', 'crypto'),
						'MUR' => __('Mauritian Rupee (₨)	MUR', 'crypto'),
						'MXN' => __('Mexican Peso ($)	MXN', 'crypto'),
						'MDL' => __('Moldovan Leu (L)	MDL', 'crypto'),
						'MNT' => __('Mongolian Tugrik (₮)	MNT', 'crypto'),
						'MAD' => __('Moroccan Dirham (د.م.)	MAD', 'crypto'),
						'MMK' => __('Myanma Kyat (Ks)	MMK', 'crypto'),
						'NAD' => __('Namibian Dollar ($)	NAD', 'crypto'),
						'NPR' => __('Nepalese Rupee (₨)	NPR', 'crypto'),
						'TWD' => __('New Taiwan Dollar (NT$)	TWD', 'crypto'),
						'NZD' => __('New Zealand Dollar ($)	NZD', 'crypto'),
						'NIO' => __('Nicaraguan Córdoba (C$)	NIO', 'crypto'),
						'NGN' => __('Nigerian Naira (₦)	NGN', 'crypto'),
						'NOK' => __('Norwegian Krone (kr)	NOK', 'crypto'),
						'OMR' => __('Omani Rial (ر.ع.)	OMR', 'crypto'),
						'PKR' => __('Pakistani Rupee (₨)	PKR', 'crypto'),
						'PAB' => __('Panamanian Balboa (B/.)	PAB', 'crypto'),
						'PEN' => __('Peruvian Sol (S/.)	PEN', 'crypto'),
						'PHP' => __('Philippine Peso (₱)	PHP', 'crypto'),
						'PLN' => __('Polish Złoty (zł)	PLN', 'crypto'),
						'GBP' => __('Pound Sterling (£)	GBP', 'crypto'),
						'QAR' => __('Qatari Rial (ر.ق)	QAR', 'crypto'),
						'RON' => __('Romanian Leu (lei)	RON', 'crypto'),
						'RUB' => __('Russian Ruble (₽)	RUB', 'crypto'),
						'SAR' => __('Saudi Riyal (ر.س)	SAR', 'crypto'),
						'RSD' => __('Serbian Dinar (дин.)	RSD', 'crypto'),
						'SGD' => __('Singapore Dollar (S$)	SGD', 'crypto'),
						'ZAR' => __('South African Rand (R)	ZAR', 'crypto'),
						'KRW' => __('South Korean Won (₩)	KRW', 'crypto'),
						'SSP' => __('South Sudanese Pound (£)	SSP', 'crypto'),
						'VES' => __('Sovereign Bolivar (Bs.)	VES', 'crypto'),
						'LKR' => __('Sri Lankan Rupee (Rs)	LKR', 'crypto'),
						'SEK' => __('Swedish Krona ( kr)	SEK', 'crypto'),
						'CHF' => __('Swiss Franc (Fr)	CHF', 'crypto'),
						'THB' => __('Thai Baht (฿)	THB', 'crypto'),
						'TTD' => __('Trinidad and Tobago Dollar ($)	TTD', 'crypto'),
						'TND' => __('Tunisian Dinar (د.ت)	TND', 'crypto'),
						'TRY' => __('Turkish Lira (₺)	TRY', 'crypto'),
						'UGX' => __('Ugandan Shilling (Sh)	UGX', 'crypto'),
						'UAH' => __('Ukrainian Hryvnia (₴)	UAH', 'crypto'),
						'AED' => __('United Arab Emirates Dirham (د.إ)	AED', 'crypto'),
						'UYV' => __('Uruguayan Peso ($)	UYU', 'crypto'),
						'UZS' => __('Uzbekistan Som	UZS', 'crypto'),
						'VND' => __('Vietnamese Dong (₫)	VND', 'crypto'),
					),
				),

				array(
					'name' => 'price_api',
					'label' => __('CoinMarketCap API', 'crypto'),
					'description' => __('Get free API key from CoinMarketCap', 'crypto') . " <a href='https://pro.coinmarketcap.com/signup/' target='_blank'>Click Here </a>",
					'type' => 'text',
					'sanitize_callback' => 'sanitize_key',
				),
				array(
					'name' => 'price_cache',
					'label' => __('Crypto Data Caching', 'crypto'),
					'description' => __('Enter cache time for crypto data in seconds. It saves API limit and speed up results.', 'crypto'),
					'type' => 'number',
					'size' => 'small',
					'sanitize_callback' => 'intval',
				),
				array(
					'name'              => 'theme',
					'label'             => __('Theme Style', 'flexi'),
					'description'       => '',
					'type'              => 'radio',
					'options'           => array(
						'none'   => __('None', 'flexi'),
						'style1' => __('Style 1', 'flexi'),
					),
					'sanitize_callback' => 'sanitize_key',
				),
				array(
					'name'              => 'theme_color',
					'label'             => __('Theme Color', 'flexi'),
					'description'       => '',
					'type'              => 'radio',
					'options'           => array(
						''   => __('Default', 'flexi'),
						'fl-is-primary' => __('Primary', 'flexi'),
						'fl-is-link'     => __('Link', 'flexi'),
						'fl-is-info'     => __('Information', 'flexi'),
						'fl-is-success'     => __('Success', 'flexi'),
						'fl-is-warning'     => __('Warning', 'flexi'),
						'fl-is-danger'     => __('Danger', 'flexi'),

					),
					'sanitize_callback' => 'sanitize_key',
				),

			),
		);
		$new = array_merge($new, $fields);

		return $new;
	}



	public function search()
	{

		ob_start();
?>
<div class="fl-field fl-has-addons">
    <div class="fl-control fl-is-expanded">
        <input class="fl-input fl-is-large" type="text" placeholder="Search names or addresses"
            id="crypto_search_domain">
    </div>
    <div class="fl-control">
        <a class="fl-button fl-is-info fl-is-large" id="crypto_search">
            Search
        </a>
    </div>
</div>

<hr>

<div class="fl-card" id="crypto_panel">
    <header class="fl-card-header">
        <p class="fl-card-header-title" id="crypto_domain_name">
            Web3 Domain Name
        </p>
    </header>
    <div class="fl-card-content">
        <div class="fl-content" id="crypto_domain_result_box">
            <div id="crypto_loading" style="text-align:center;"> <img
                    src="<?php echo esc_url(CRYPTO_PLUGIN_URL . '/public/imG/loading.gif'); ?>">
            </div>
        </div>
    </div>
    <footer class="fl-card-footer">
        <a href="#" class="fl-card-footer-item">Mint</a>
        <a href="#" class="fl-card-footer-item">View</a>
        <a href="#" class="fl-card-footer-item">Delete</a>
    </footer>
</div>

<script>
jQuery(document).ready(function() {
    jQuery("#crypto_panel").hide();

    jQuery("#crypto_search").click(function() {
        jQuery("#crypto_panel").slideDown();
        var str = jQuery("#crypto_search_domain").val();
        var result = str.replace(".web3", "");
        console.log(result);
        jQuery("#crypto_domain_name").html(result + ".web3");
    });

    jQuery("#crypto_search_domain").on("input", function() {
        jQuery("#crypto_panel").slideUp();
        // Print entered value in a div box

    });
});
</script>


<?php
		$content = ob_get_clean();
		return $content;
	}
	public function dashboard_add_tabs($tabs)
	{

		$extra_tabs = array("domain" => 'Domain Marketplace');

		// combine the two arrays
		$new = array_merge($tabs, $extra_tabs);
		//crypto_log($new);
		return $new;
	}

	public function dashboard_add_content()
	{
		if (isset($_GET['tab']) && 'domain' == $_GET['tab']) {
			echo wp_kses_post($this->crypto_dashboard_content());
		}
	}

	public function crypto_dashboard_content()
	{
		ob_start();
	?>
<div class="changelog section-getting-started">
    <div class="feature-section">
        <h2>Become a Web3 Domain Name provider</h2>
        <div class="wrap">
            <b>Register your primary top-level domain (TLD) Web3 Domain Name from web3domain.org and start selling
                subdomains of it.</b>


        </div>
    </div>
</div>
<?php
		$content = ob_get_clean();
		return $content;
	}
}
new Crypto_Domain_Search();