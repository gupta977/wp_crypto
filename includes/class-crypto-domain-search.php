<?php
class Crypto_Domain_Search
{
	function __construct()
	{

		add_shortcode('crypto-domain-search', array($this, 'search'));


		add_filter('crypto_dashboard_tab', array($this, 'dashboard_add_tabs'));
		add_action('crypto_dashboard_tab_content', array($this, 'dashboard_add_content'));
	}




	public function search()
	{

		ob_start();
?>
		<div class="fl-field fl-has-addons">
			<div class="fl-control">
				<input class="fl-input" type="text" placeholder="Search names or addresses">
			</div>
			<div class="fl-control">
				<a class="fl-button fl-is-info">
					Search
				</a>
			</div>
		</div>

		<hr>

		<nav class="fl-panel">
			<p class="fl-panel-heading">
				jack.eth
			</p>
			<div class="fl-panel-block">
				<p class="fl-control fl-has-icons-left">
					<input class="fl-input" type="text" placeholder="Search">
					<span class="fl-icon fl-is-left">
						<i class="fas fa-search" aria-hidden="true"></i>
					</span>
				</p>
			</div>
			<p class="fl-panel-tabs">
				<a class="fl-is-active">All</a>
				<a>Public</a>
				<a>Private</a>
				<a>Sources</a>
				<a>Forks</a>
			</p>
			<a class="fl-panel-block fl-is-active">
				<span class="fl-panel-icon">
					<i class="fas fa-book" aria-hidden="true"></i>
				</span>
				bulma
			</a>
			<a class="fl-panel-block">
				<span class="fl-panel-icon">
					<i class="fas fa-book" aria-hidden="true"></i>
				</span>
				marksheet
			</a>
			<a class="fl-panel-block">
				<span class="fl-panel-icon">
					<i class="fas fa-book" aria-hidden="true"></i>
				</span>
				minireset.css
			</a>
			<a class="fl-panel-block">
				<span class="fl-panel-icon">
					<i class="fas fa-book" aria-hidden="true"></i>
				</span>
				jgthms.github.io
			</a>
			<a class="fl-panel-block">
				<span class="fl-panel-icon">
					<i class="fas fa-code-branch" aria-hidden="true"></i>
				</span>
				daniellowtw/infboard
			</a>
			<a class="fl-panel-block">
				<span class="fl-panel-icon">
					<i class="fas fa-code-branch" aria-hidden="true"></i>
				</span>
				mojs
			</a>
			<label class="fl-panel-block">
				<input type="checkbox">
				remember me
			</label>
			<div class="fl-panel-block">
				<button class="fl-button fl-is-link fl-is-outlined fl-is-fullwidth">
					Reset all filters
				</button>
			</div>
		</nav>


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
					<b>Register your primary top-level domain (TLD) Web3 Domain Name from web3domain.org and start selling subdomains of it.</b>


				</div>
			</div>
		</div>
<?php
		$content = ob_get_clean();
		return $content;
	}
}
new Crypto_Domain_Search();
