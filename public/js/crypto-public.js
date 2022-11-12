(function( $ ) {
	'use strict';

	/**
	 * All of the code for your public-facing JavaScript source
	 * should reside in this file.
	 *
	 * Note: It has been assumed you will write jQuery code here, so the
	 * $ function reference has been prepared for usage within the scope
	 * of this function.
	 *
	 * This enables you to define handlers, for when the DOM is ready:
	 *
	 * $(function() {
	 *
	 * });
	 *
	 * When the window is loaded:
	 *
	 * $( window ).load(function() {
	 *
	 * });
	 *
	 * ...and/or other possibilities.
	 *
	 * Ideally, it is not considered best practise to attach more than a
	 * single DOM-ready or window-load handler for a particular page.
	 * Although scripts in the WordPress core, Plugins and Themes may be
	 * practising this, we should strive to set a better example in our own work.
	 */

})( jQuery );

function crypto_wallet_short(str, keep) {
    var len = str.length,
        re = new RegExp("(.{" + keep + "})(.{" + (len - keep * 2) + "})(.{" + keep + "})", "g")
   // console.log(re)
    return str.replace(re, function(match, a, b, c) {
        var xx = a + ("" + b).replace(/./g, "*") + c;
        return xx.replace('**********************************', '***');
    });
}


/** add a parameter at the end of the URL. Manage '?'/'&', but not the existing parameters.
   *  does escape the value (but not the key)
   */
 function crypto_addParameterToURL(_url,_key,_value){
	var param = _key+'='+escape(_value);

	var sep = '&';
	if (_url.indexOf('?') < 0) {
	  sep = '?';
	} else {
	  var lastChar=_url.slice(-1);
	  if (lastChar == '&') sep='';
	  if (lastChar == '?') sep='';
	}
	_url += sep + param;

	return _url;
}

	const crypto_plugin_url = crypto_connectChainAjax.crypto_plugin_url;

//console.log(crypto_plugin_url);
    const contractAddress = "0x826fe8a7E5983000E5E52657384C4f5d4BAE20D0"; // Update with the address of your smart contract
    const contractAbi = crypto_plugin_url+"/public/js/web3domain.json?19"; // Update with an ABI file, for example "./sampleAbi.json"
    let web3; // Web3 instance
    let contract; // Contract instance
    let account; // Your account as will be reported by Metamask