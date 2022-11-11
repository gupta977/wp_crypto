<?php
class Crypto_Domain_URL
{
    private $market_page;
    private $search_page;
    function __construct()
    {
        add_filter('init', array($this, 'rw_init'));
        add_filter('query_vars', array($this,  'rw_query_vars'));
        add_shortcode('crypto-domain-url', array($this, 'start'));
        $this->search_page = crypto_get_option('search_page', 'crypto_marketplace_settings', 0);
        $this->market_page = crypto_get_option('market_page', 'crypto_marketplace_settings', 0);
    }

    public function rw_query_vars($aVars)
    {
        $aVars[] = "web3domain"; // represents the name of the variable as shown in the URL
        return $aVars;
    }

    public function rw_init()
    {
        add_rewrite_rule(
            '^web3/([^/]*)$',
            'index.php?web3domain=$matches[1]&page_id=30',
            'top'
        );
    }

    public function start()
    {
        global $wp_query;
        if (0 != $this->search_page) {
            $this->search_page = esc_url(get_page_link($this->search_page));
        } else {
            $this->search_page = "#";
        }
        if (0 != $this->market_page) {
            $this->market_page = esc_url(get_page_link($this->market_page));
        } else {
            $this->market_page = "#";
        }

        if (isset($wp_query->query_vars['web3domain'])) {
            $subdomain = $wp_query->query_vars['web3domain'];
            if (isset($_GET['domain'])) {

?>

<div class="fl-buttons fl-has-addons">
    <a href="<?php echo $this->search_page; ?>" class="fl-button ">Search</a>
    <a href="<?php echo $this->market_page; ?>" class="fl-button">My Domains</a>
    <a href="#" class="fl-button fl-is-success fl-is-selected">Manage Domain</a>
</div>

<?php
            } else {

            ?>

<h1 id="step1">Connecting to <?php echo $subdomain; ?></h1>

<?php
            }
        }
    }
}
new Crypto_Domain_URL();