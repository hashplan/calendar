<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class CrawlerDrv
{
    protected $formatUrl;
    protected $CI;
    protected $proxies_list = array(
        array(
            'ip' => '64.31.22.131',
            'port' => 3127
        ),
        array(
            'ip' => '198.52.217.44',
            'port' => 8089
        ),
        array(
            'ip' => '199.200.120.140',
            'port' => 7808
        ),
        array(
            'ip' => '23.95.42.138',
            'port' => 3127
        ),
        array(
            'ip' => '162.208.49.45',
            'port' => 7808
        ),
        array(
            'ip' => '199.200.120.140',
            'port' => 8089
        ),
        array(
            'ip' => '162.216.155.136',
            'port' => 8089
        ),
        array(
            'ip' => '66.85.131.18',
            'port' => 7808
        ),
    );

    public function __construct()
    {
        $this->CI = & get_instance();
    }

    protected function curl($URLServer, $postdata = "", $cookieFile = null, $useProxy = false, $proxyRetry = 0)
    {
        $agent = "Mozilla/5.0 (X11; U; Linux i686; en-US; rv:1.9.2.12) Gecko/20101027 Ubuntu/10.10 (maverick) Firefox/3.6.12";
        $cURL_Session = curl_init();

        curl_setopt($cURL_Session, CURLOPT_URL, $URLServer);
        curl_setopt($cURL_Session, CURLOPT_USERAGENT, $agent);
        if ($postdata != "") {
            curl_setopt($cURL_Session, CURLOPT_POST, 1);
            curl_setopt($cURL_Session, CURLOPT_POSTFIELDS, $postdata);
        }
        curl_setopt($cURL_Session, CURLOPT_RETURNTRANSFER, 1);
        if ($cookieFile != null) {
            curl_setopt($cURL_Session, CURLOPT_COOKIEJAR, $cookieFile);
            curl_setopt($cURL_Session, CURLOPT_COOKIEFILE, $cookieFile);
        }

        if ($useProxy == true) {
            $proxy = $this->proxies_list[rand(0, (count($this->proxies_list) - 1))];
            curl_setopt($cURL_Session, CURLOPT_PROXYPORT, $proxy['port']);
            curl_setopt($cURL_Session, CURLOPT_PROXYTYPE, 'HTTP');
            curl_setopt($cURL_Session, CURLOPT_PROXY, $proxy['ip']);
        }

        $result = curl_exec($cURL_Session);

        if ($result === false && $useProxy == true && $proxyRetry <= 5) {
            $this->curl($URLServer, $postdata, $cookieFile, $useProxy, ++$proxyRetry);
        }
        curl_close($cURL_Session);

        return $result;
    }
}