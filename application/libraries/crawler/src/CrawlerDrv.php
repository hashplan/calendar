<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class CrawlerDrv
{
    protected $formatUrl;
    protected $CI;

    public function __construct()
    {
        $this->CI = & get_instance();
    }

    protected function curl($URLServer, $postdata = "", $cookieFile = null, $proxy = false, $proxyRetry = 0)
    {
        global $proxyCache;
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

        if ($proxy == true) {
            if ($proxyCache == "") {
                $c = curl("http://www.xroxy.com/proxylist.htm", "", null, false);
                preg_match_all("/[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\:[0-9]{1,5}/", $c, $matches);
                echo $matches;
                $matches = $matches[0];
                echo $matches;
                print_r($matches);
                $proxyCache = $matches[rand(0, (count($matches) - 1))];
            }

            echo "proxy:$proxyCache\n";


            list($proxy_ip, $proxy_port) = explode(":", $proxyCache);

            curl_setopt($cURL_Session, CURLOPT_PROXYPORT, $proxy_port);
            curl_setopt($cURL_Session, CURLOPT_PROXYTYPE, 'HTTP');
            curl_setopt($cURL_Session, CURLOPT_PROXY, $proxy_ip);
        }

        $result = curl_exec($cURL_Session);

        if ($result === false) {
            echo 'Curl error: ' . curl_error($cURL_Session) . "\n";

            if ($proxy == true && $proxyRetry <= 5) {
                $proxyCache = "";
                curl($URLServer, $postdata = "", $cookieFile, $proxy, $proxyRetry++);
            }
        }
        curl_close($cURL_Session);

        return $result;
    }
}