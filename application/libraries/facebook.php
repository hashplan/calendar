<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
require_once(APPPATH . 'libraries/Facebook/autoload.php');

use Facebook\GraphSessionInfo;
use Facebook\FacebookSession;
use Facebook\FacebookCurl;
use Facebook\FacebookHttpable;
use Facebook\FacebookCurlHttpClient;
use Facebook\FacebookResponse;
use Facebook\FacebookAuthorizationException;
use Facebook\FacebookRequestException;
use Facebook\FacebookRequest;
use Facebook\FacebookSDKException;
use Facebook\FacebookRedirectLoginHelper;
use Facebook\GraphObject;

class Facebook
{
    private $CI = null;
    private $appId = null;
    private $appSecret = null;
    private $scope = null;
    private $redirectUrl = null;
    private $helper = null;
    private $session = null;


    public function __construct($config = array())
    {
        $this->CI = & get_instance();
        $this->CI->config->load('facebook', TRUE);
        $this->CI->load->library('session');

        $this->appId = isset($config['appId']) ? $config['appId'] : $this->CI->config->item('appId', 'facebook');
        $this->appSecret = isset($config['appSecret']) ? $config['appSecret'] : $this->CI->config->item('appSecret', 'facebook');
        $this->scope = isset($config['scope']) ? $config['scope'] : $this->CI->config->item('scope', 'facebook');
        $this->redirectUrl = isset($config['redirectUrl']) ? $config['redirectUrl'] : $this->CI->config->item('redirectUrl', 'facebook');

        FacebookSession::setDefaultApplication($this->appId, $this->appSecret);
        $this->helper = new FacebookRedirectLoginHelper($this->redirectUrl);

        if ($this->CI->session->userdata('fb_token')) {
            $this->session = new FacebookSession($this->CI->session->userdata('fb_token'));

            // Validate the access_token to make sure it's still valid
            try {
                if (!$this->session->validate()) {
                    $this->session = false;
                }
            } catch (Exception $e) {
                // Catch any exceptions
                $this->session = false;
            }
        } else {
            try {
                $this->session = $this->helper->getSessionFromRedirect();
            } catch (FacebookRequestException $ex) {
                // When Facebook returns an error
            } catch (\Exception $ex) {
                // When validation fails or other local issues
            }
        }

        if ($this->session) {
            $this->CI->session->set_userdata('fb_token', $this->session->getToken());
            $this->session = new FacebookSession($this->session->getToken());
        }
    }

    public function get_login_url()
    {
        return $this->helper->getLoginUrl($this->scope);
    }

    public function get_logout_url()
    {
        if ($this->session) {
            return $this->helper->getLogoutUrl($this->session, site_url('logout'));
        }
        return false;
    }

    public function get_user()
    {
        if ($this->session) {
            try {
                $request = (new FacebookRequest($this->session, 'GET', '/me'))->execute();
                $user = $request->getGraphObject()->asArray();

                return $user;

            } catch (FacebookRequestException $e) {
                return false;

                /*echo "Exception occured, code: " . $e->getCode();
                echo " with message: " . $e->getMessage();*/
            }
        }
    }
}