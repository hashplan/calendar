<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class StubhubDrv extends CrawlerDrv
{
    public function __construct()
    {
        parent::__construct();
        $this->formatUrl = 'www.stubhub.com/search/doSearch?searchStr=%s&searchMode=event&rows=100&start=%s&nS=0&ae=1&sp=Date&sd=1';
    }

    public function start()
    {
        $result = $this->CI->db
            ->select('city')
            ->get('metroareas')
            ->result();
        foreach ($result as $cities) {
            $this->process($cities->city);
            sleep(30);
        }

       $this->CI->db
            ->join('cities AS c', 'v.city = c.city AND v.stateId = c.stateId')
            ->update('venues AS v', array('v.cityid' => 'c.id'), array('v.cityId' => 0));
    }

    protected function process($city)
    {
        $dom = $this->curl(sprintf($this->formatUrl, $city, 0));
        $html = new simple_html_dom();
        $html->Load($dom);
        $resultRed = $html->find('span[@class="resultRed"]', 0);
        if($resultRed){
            $totalCount = $resultRed->innertext;
            if ($totalCount > 0) {
                for ($i = 0; $i <= $totalCount; $i = $i + 100) {
                    $this->scraping(sprintf($this->formatUrl, $city, $i));
                }
            }
        }
    }

    protected function scraping($url)
    {
        $isFirst = true;
        $dom = $this->curl($url);
        $html = new simple_html_dom();
        $html->Load($dom);
        // get count
        $ret['Count'] = $html->find('span[@class="resultRed"]', 0)->innertext;

        // get overview
        foreach ($html->find('//tr') as $div) {

            $insideDiv = $div->find('//th', 0);
            if (sizeof($insideDiv) == 0) {
                $link = $div->find('/a', 0)->href;

                for ($i = 0; $i <= 2; $i++) {
                    if ($i == 0) {
                        $eventName = $div->find('/a', $i)->title;
                    };
                    if ($i == 1) {
                        $day = $div->find('span[@id="ticketEventDate"]', 0)->innertext;
                        $month = $div->find('span[@id="ticketEventMonth"]', 0)->innertext;
                        if (!is_null($div->find('span[@id="ticketEventYear"]', 0))) {
                            $year = $div->find('span[@id="ticketEventYear"]', 0)->innertext;

                        } else {
                            $year = date('Y');

                        }

                        $day = trim($day);
                    };
                    if ($i == 2) {
                        $new = $div->find('//td', $i);
                        $var = $new->innertext;
                        foreach ($new->find('//a') as $a) {
                            $venueName = $a->innertext;

                        }
                        $pieces = explode("<br/>", $var);

                        $citystate = explode(",", $pieces[2]); // piece2
                        $city = $citystate[0];
                        $state = $citystate[1];
                        $time = $pieces[3];
                        $time = trim($time);

                        $date = date_parse($year . "-" . date('m', strtotime($month)) . "-" . $day . " " . $time);
                        $datetime = $date["year"] . "-" . $date["month"] . "-" . $date["day"] . " " . $date["hour"] . ":" . $date["minute"];

                        if ($isFirst == true) {
                            $this->CI->db->query("insert into crawlstatus(crawler, city) values('stubhub', '" . trim($city) . "');");
                            $isFirst = false;
                        }

                        $sql = "call calendar.InsertEvent('" . addslashes(trim($eventName)) . "','" . $datetime . "','" . addslashes(trim($venueName)) . "','" . trim($city) . "','" . trim($state) . "','" . addslashes(trim($link)) . "');";
                        $this->CI->db->query($sql);
                    };
                }
            }
        }
        $html->clear();
        unset($html);
        return $ret;
    }
}