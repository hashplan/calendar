<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class StubhubDrv extends CrawlerDrv
{
    private $processed_events;

    public function __construct()
    {
        parent::__construct();
        $this->processed_events = 0;
        $this->formatUrl = 'www.stubhub.com/search/doSearch?searchStr=%s&searchMode=event&rows=100&start=%s&nS=0&ae=1&sp=Date&sd=1';
    }

    public function start()
    {
        $result = $this->CI->db
            ->select('id, city')
            ->get('metroareas')
            ->result();
        foreach ($result as $city) {
            $this->processed_events = 0;
            $this->process($city);
            sleep(30);
        }

        $this->CI->db
            ->join('cities AS c', 'v.city = c.city AND v.stateId = c.stateId')
            ->update('venues AS v', array('v.cityid' => 'c.id'), array('v.cityId' => 0));
    }

    protected function process($city)
    {
        $dom = $this->curl(sprintf($this->formatUrl, $city->city, 0));
        $html = new simple_html_dom();
        $html->Load($dom);
        $resultRed = $html->find('span[@class="resultRed"]', 0);

        $insert_data = array(
            'crawler' => 'stubhub',
            'city' => $city->city,
            'total_event' => (int)$resultRed

        );
        $this->CI->db->insert('crawlstatus', $insert_data);
        $row_id = $this->db->insert_id();

        if ($resultRed) {
            $totalCount = $resultRed->innertext;
            if ($totalCount > 0) {
                for ($i = 0; $i <= $totalCount; $i = $i + 100) {
                    $this->processed_events = 0;
                    $this->scraping(sprintf($this->formatUrl, $city->city, $i));
                    $this->CI->db->update(
                                 'crawlstatus',
                                     array('processed_events' => $this->processed_events),
                                     array('id' => $row_id));
                }
            }
        }
    }

    protected function scraping($url)
    {
        $dom = $this->curl($url);
        $html = new simple_html_dom();
        $html->load($dom);
        // get count
        $ret['count'] = $html->find('span.resultRed', 0)->innertext;

        // get overview
        foreach ($html->find('tr') as $tr) {

            if (sizeof($tr->find('th', 0))) {
                continue;
            }
            $this->processed_events++;

            $title = $tr->find('td.eventName a', 0);
            $eventName = trim($title->title);
            if (!$eventName) {
                continue;
            }
            $eventLink = $title->href;

            $day = trim($tr->find('td.eventDate span#ticketEventDate', 0)->innertext);
            $month = trim($tr->find('td.eventDate span#ticketEventMonth', 0)->innertext);
            if (!is_null($tr->find('td.eventDate span#tticketEventYear', 0))) {
                $year = $tr->find('td.eventDate span#tticketEventYear', 0)->innertext;

            }
            else {
                $year = date('Y');
            }
            $year = trim($year);
            if (!$day || !$month || !$year) {
                continue;
            }

            $venueName = $tr->find('td.eventLocation a', 0)->innertext;
            $pieces = preg_split('/<br[^>]*>/i', $tr->find('td.eventLocation', 0)->innertext);

            $citystate = explode(",", $pieces[2]);

            $city = trim($citystate[0]);
            $state = trim($citystate[1]);
            $time = trim($pieces[3]);

            $date = date_parse($year . "-" . date('m', strtotime($month)) . "-" . $day . " " . $time);
            $datetime = $date["year"] . "-" . sprintf("%02d", $date["month"]) . "-" . sprintf("%02d", $date["day"]) . " " . sprintf("%02d", $date["hour"]) . ":" . sprintf("%02d", $date["minute"]);

            $sql = "call " . $this->CI->db->database . ".InsertEvent('" . addslashes($eventName) . "','" . $datetime . "','" .
                addslashes($venueName) . "','" . $city .
                "','" . $state . "','" . addslashes($eventLink) . "');";
            echo $sql. "<br/>";
            //$this->CI->db->query($sql);
        }
        $html->clear();
        unset($html);
        return $ret;
    }
}