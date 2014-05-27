<?php

class Yelp_oauth {

	const YELP_SEARCH_URL = 'http://api.yelp.com/v2/search/';

	public $config = array();

	public function __construct() {
		require_once(FCPATH . APPPATH .'third_party/Yelp_oauth.php');
	}

	public function search_request($term, $location) {
		$CI =& get_instance();
		$unsigned_url = self::YELP_SEARCH_URL .'?term='. $term .'&location='. $location .'&limit=1';
		$token = new OAuthToken($CI->config->item('yelp_token'), $CI->config->item('yelp_token_secret'));
		$consumer = new OAuthConsumer($CI->config->item('yelp_consumer_key'), $CI->config->item('yelp_consumer_secret'));
		$signature_method = new OAuthSignatureMethod_HMAC_SHA1();
		$request = OAuthRequest::from_consumer_and_token($consumer, $token, 'GET', $unsigned_url);
		$request->sign_request($signature_method, $consumer, $token);
		$signed_url = $request->to_url();

		$ch = curl_init($signed_url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_HEADER, 0);
		$data = curl_exec($ch);
		curl_close($ch);

		return $data;
	}
}