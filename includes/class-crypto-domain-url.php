<?php
class Crypto_Domain_URL
{
    private $market_page;
    private $search_page;
    private $url_page;
    function __construct()
    {
        add_filter('init', array($this, 'rw_init'));
        add_filter('query_vars', array($this,  'rw_query_vars'));
        add_shortcode('crypto-domain-url', array($this, 'start'));
        $this->search_page = crypto_get_option('search_page', 'crypto_marketplace_settings', 0);
        $this->market_page = crypto_get_option('market_page', 'crypto_marketplace_settings', 0);
        $this->url_page = crypto_get_option('url_page', 'crypto_marketplace_settings', 0);
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
            'index.php?web3domain=$matches[1]&page_id=' . $this->url_page,
            'top'
        );
    }

    public function start()
    {
        ob_start();
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
?>
        <div class="fl-buttons fl-has-addons">
            <a href="<?php echo $this->search_page; ?>" class="fl-button ">Search</a>
            <a href="<?php echo $this->market_page; ?>" class="fl-button">My Domains</a>
            <a href="#" class="fl-button fl-is-success fl-is-selected">Manage Domain</a>
        </div>

        <div class="fl-card" id="crypto_panel">
            <header class="fl-card-header">
                <p class="fl-card-header-title" id="crypto_domain_name">
                    Web3 Domain Name
                </p>
            </header>
            <div class="fl-card-content">
                <div class="fl-content" id="crypto_domain_result_box">
                    <div id="crypto_loading" style="text-align:center;"> <img src="<?php echo esc_url(CRYPTO_PLUGIN_URL . '/public/img/loading.gif'); ?>">
                    </div>


                    <article class="fl-message fl-is-danger" id="crypto_unavailable">
                        <div class="fl-message-body">
                            <div class="fl-tags fl-has-addons">
                                <span class="fl-tag fl-is-large" id="crypto_domain_name">Domain Name</span>
                                <span class="fl-tag fl-is-danger fl-is-large" id="crypto_domain_name_error">Unavailable</span>
                            </div>
                        </div>
                    </article>

                    <div id="json_container">Connecting ....</div>

                </div>




                <?php
                if (isset($wp_query->query_vars['web3domain'])) {
                    $subdomain = $wp_query->query_vars['web3domain'];
                    $subdomain = strtolower($subdomain);
                    if (isset($_GET['domain'])) {



                ?>

                        <script>
                            jQuery(document).ready(function() {
                                jQuery("#crypto_unavailable").hide();
                                jQuery("[id=crypto_domain_name]").html('<?php echo  $subdomain; ?>');
                                jQuery("#transfer_box").hide();

                            });

                            crypto_is_metamask_Connected().then(acc => {
                                if (acc.addr == '') {
                                    console.log("Metamask not connected. Please connect first");
                                } else {
                                    jQuery("#crypto_loading").show();
                                    console.log("Connected to:" + acc.addr + "\n Network:" + acc.network);

                                    if ((acc.network != '80001')) {
                                        var msg =
                                            "Change your network to Polygon (MATIC). Your connected network is " +
                                            acc.network;
                                        jQuery("[id=crypto_msg_ul]").empty();
                                        jQuery("[id=crypto_msg_ul]").append(msg).fadeIn("normal");
                                    } else {
                                        //  crypto_init();
                                        web3 = new Web3(window.ethereum);

                                        const connectWallet = async () => {
                                            const accounts = await ethereum.request({
                                                method: "eth_requestAccounts"
                                            });
                                            var persons = [];
                                            account = accounts[0];
                                            console.log(`Connectedxxxxxxx account...........: ${account}`);
                                            // getBalance(account);
                                            await crypto_sleep(1000);
                                            var domain_id = await getId('<?php echo  $subdomain; ?>');
                                            jQuery('#json_container').html('Checking ownership...');
                                            if (typeof domain_id !== 'undefined') {
                                                console.log(domain_id);
                                                var domain_owner = await getOwner(domain_id);
                                                console.log('Domain owner ' + domain_owner);

                                                if (domain_owner.toLowerCase() === account.toLowerCase()) {
                                                    console.log("Authorized");
                                                    jQuery("#transfer_box").show();
                                                } else {
                                                    console.log("Not authorized");
                                                    jQuery('#json_container').html(
                                                        '<div class="flexi_alert-box flexi_notice"> Your are not owner of this domain name. Check your connected wallet address </div>');
                                                    jQuery("#transfer_box").hide();
                                                }
                                                jQuery("#crypto_loading").hide();
                                            } else {
                                                console.log("Domain not minted yet");
                                                jQuery("#crypto_loading").hide();
                                            }

                                            console.log(contract);

                                        };

                                        connectWallet();
                                        connectContract(contractAbi, contractAddress);




                                    }
                                }
                            });
                        </script>
                        <div id="transfer_box">
                            <div class="fl-column fl-is-full">
                                <div class="fl-box">


                                    <div class="fl-field">
                                        <label class="fl-label">Enter polygon wallet address:</label>
                                        <div class="fl-control">
                                            <input class="fl-input" id="to_add" placeholder="e.g. 0xf11a4fac7b7839771da0a526145198e99d0575be">
                                        </div>
                                    </div>
                                    <p class="fl-help fl-is-success">This will transfer current NFT domain to new owner.<br>You will not
                                        have
                                        any controls later </p>

                                    <div class="fl-control">
                                        <button class="fl-button fl-is-primary" id="transfer">Transfer</button>
                                    </div>



                                </div>
                            </div>
                        </div>
                    <?php
                    } else {
                    ?>



                        <script>
                            jQuery(document).ready(function() {
                                jQuery("#crypto_unavailable").hide();
                                crypto_check_w3d_name_json('<?php echo  $subdomain; ?>');

                                function crypto_check_w3d_name_json(domain_name) {
                                    fetch('https://w3d.name/api/index.php?domain=' + domain_name)
                                        .then(res => res.json())
                                        .then((out) => {
                                            console.log('Output: ', out);
                                            if (typeof out.error !== 'undefined') {
                                                console.log("This domain name is available to mint.");
                                                jQuery("[id=crypto_domain_name]").html(domain_name + "");
                                                jQuery("#crypto_loading").hide();
                                                // jQuery("#crypto_available").show();
                                                jQuery("#crypto_unavailable").show();
                                            } else {
                                                console.log("Already registered");
                                                //console.log(out);
                                                // jQuery("#crypto_loading").hide();
                                                jQuery("#crypto_unavailable").hide();
                                                var web_url = "https://ipfs.io/ipfs/" + out.records["50"].value;
                                                var web3_url = '';
                                                if (out.records.hasOwnProperty('51')) {
                                                    var web3_url = out.records["51"].value;
                                                }

                                                if (web3_url != '') {
                                                    // console.log(web3_url);
                                                    window.location.href = web3_url;
                                                } else {
                                                    //  console.log(web_url);
                                                    // chrome.tabs.create({ active: true, url: web_url });
                                                    window.location.href = web_url;
                                                    // window.location.replace(web_url);
                                                }

                                                //   jQuery("#crypto_loading").hide();
                                                //    jQuery("#crypto_unavailable").show();
                                            }
                                        }).catch(err => console.error(err));
                                }
                            });
                        </script>


                    <?php

                    }
                    ?>
                    ...............
            </div>
        </div>
<?php
                }
                $content = ob_get_clean();
                return $content;
            }

            public function fetch_url($domain_name, $update)
            {
                $uri = "https://w3d.name/api/index.php?domain=" . $domain_name . "&" . rand();

                if ($update == 'true') {
                    $uri = "https://w3d.name/api/index.php?domain=" . $domain_name . "&update=true&" . rand();
                }

                // Open file
                $handle = @fopen($uri, 'r');

                // Check if file exists
                if ($handle) {

                    $json = crypto_file_get_contents_ssl($uri);
                    //var_dump($json);
                    $json_data = json_decode($json, true);
                    //return $json_data;
                    if (isset($json_data['records']['51']['value']) && $json_data['records']['51']['value'] != '') {

                        return $json_data['records']['51']['value'];
                    } else {
                        if (isset($json_data['records']['50']['value'])) {
                            return 'https://ipfs.io/ipfs/' . $json_data['records']['50']['value'];
                        } else {
                            return "";
                        }
                    }
                }
            }
        }
        new Crypto_Domain_URL();
