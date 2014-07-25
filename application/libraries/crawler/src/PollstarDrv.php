<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class PollstarDrv extends CrawlerDrv
{
    public function __construct()
    {
        parent::__construct();
        $this->formatUrl = 'http://www.pollstar.com/pollstarRSS.aspx?feed=city&id=%s&surrounding=True';
    }

    public function start()
    {
        $result = $this->CI->db
            ->where(array('crawl' => 1))
            ->where('pollstarID IS NOT NULL', null, false)
            ->get('metroareas')
            ->result();

        foreach ($result as $pollstar) {
            $this->process($pollstar->PollstarID);
            sleep(30);
        }
    }

    protected function process($cityId)
    {
        $url = sprintf($this->formatUrl, $cityId);
        $this->scraping($url, $cityId);
    }

    protected function scraping($url, $cityId)
    {
        $feed_uri = $url;
        $isFirst = true;

        $xml_source = $this->curl($feed_uri);
        if (strlen($xml_source) <= 3) {
            return "blank";
        }

        $x = simplexml_load_string($xml_source);

        if (count($x) == 0)
            return "blank";

        foreach ($x->channel->item as $item) {
            $tmp = explode(">", $item->description);
            $event = str_replace("</a", "", $tmp[2]);
            $event = str_replace('"', "", $event);
            if ($event == "Straight Line Stitch") {
                //var_dump($tmp);
            }
            if ($event == "Mindless Behavior") {
                //var_dump($tmp);
            }

            for ($v = 4; $v <= sizeof($tmp) - 1; $v++) {
                if (strrpos($tmp[$v], "ppearing at") != false) {
                    $venue = str_replace("</a", "", $tmp[$v + 1]);
                    break;
                }
            }


            for ($c = 6; $c <= sizeof($tmp) - 1; $c++) {
                if (strrpos($tmp[$c], "(") != false) {
                    $citytmp = explode(")", str_replace("</p", "", $tmp[$c]));
                }
            }


            $city = explode(",", str_replace("(", "", $citytmp[0]));
            $city = $city[0];
            $state = explode(",", str_replace("(", "", $citytmp[0]));
            $state = $state[1];
            $datetmp = explode(",", $citytmp[1]);

            $date = $datetmp[1] . "," . $datetmp[2];
            $time = "19:00";
            $datetime = trim($date) . " " . $time;

            if ($isFirst == true) {
                $this->CI->db->query("insert into crawlstatus(crawler, city) values('pollstar', '" . $cityId . "');");
                $isFirst = false;
            }

            $sql = "call " . $this->CI->db->database . ".InsertPollStarEvent('" . addslashes(trim($event)) . "','" . $datetime . "','" . addslashes(trim($venue)) . "','" . trim($city) . "','" . trim($state) . "'," . $cityId . ");";
            echo $sql . "</br>";
            $this->CI->db->query($sql);


        }
    }

}