<?php
/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 03.10.2018
 * Time: 23:13
 */

namespace Controllers;

use Models\Zodiac;
use Models\ZodiacYear;
use Models\ZodiacMonth;
use Models\ZodiacDay;
use Symfony\Component\DomCrawler\Crawler;


class ParserController
{
    private $url;
    protected $config;
    protected $zodiacs;


    /**
     * ParserController constructor.
     * @throws \Exception
     */
    public function __construct()
    {
        $this->config = require __DIR__ . "/../config/config.php";
        $this->url = $this->config['url'];
        if (empty($this->url)) {
            throw new \Exception("Адрес сайта пустой.");
        }
    }

    /**
     * Получаем страницу для парсинага
     * @param string $url
     * @return Crawler
     */
    public function getPage(string $url)
    {
        $html = file_get_contents($url);
        $crawler = new Crawler($html);
        return $crawler;
    }

    /**
     * Парсим зодиаки с сайта
     * и сразу заполняем БД
     * @throws \Exception
     */
    public function parseZodiacs()
    {
        $dom = $this->getPage($this->url);
        $dataArray = $dom->filter('.zodiaks li a')->each(function (Crawler $node, $i) {
            return [
                'id' => $i,
                'name' => $node->text(),
                'link' => $node->attr('href')];
        });
        foreach ($dataArray as $data) {
            $zodiac = new Zodiac();
            $zodiac->prepareAttributes($data);
            $zodiac->save();
        }
    }

    /**
     * Парсим гороскопы всех дней  с сайта
     *
     * @param Zodiac
     * @return array $dataArray
     */
    public function parseZodiacsDay($zodiac)
    {
        $dataArray = [];
        $dom = $this->getPage($zodiac->link);
        $navbar = $dom->filter('#tabdays ul li a')->extract(array('href'));
        foreach ($navbar as $navbarID) {
            $array = [
                'zodiac_id' => $zodiac->id,
                'day' => str_replace('#d', '', $navbarID),
                'value' => $dom->filter($navbarID . ' p')->text()
            ];
            $dataArray[] = $array;
        }

        return ($dataArray);
    }

    /**
     * Парсим гороскопы на месяц  с сайта
     *
     * @param Zodiac
     * @return array $dataArray
     */
    public function parseZodiacsMonth($zodiac)
    {
        $dom = $this->getPage($zodiac->link);
        $data = [
            'zodiac_id' => $zodiac->id,
            'month' => $dom->filter('#tabs-1 p')->text(),
            'work' => $dom->filter('#tabs-2 p')->text(),
            'love' => $dom->filter('#tabs-3 p')->text(),
            'money' => $dom->filter('#tabs-4 p')->text()
        ];

        return $data;
    }

    /**
     * Парсим гороскопы на год  с сайта
     *
     * @param Zodiac
     * @return array $dataArray
     */
    public function parseZodiacsYear($zodiac)
    {
        $dom = $this->getPage($zodiac->link);
        $data = [
            'zodiac_id' => $zodiac->id,
            'year' => $dom->filter('#ty-1 p')->text(),
            'work' => $dom->filter('#ty-2 p')->text(),
            'love' => $dom->filter('#ty-3 p')->text(),
            'money' => $dom->filter('#ty-4 p')->text()
        ];

        return ($data);
    }

    /** actionIndex
     * @throws \Exception
     */
    public function actionIndex()
    {
        $this->prepareZodiacs();

        echo 'Done index' . PHP_EOL;
    }


    /**
     * actionEveryMonth
     * @throws \Exception
     */
    public function actionEveryMonth()
    {
        $this->actionIndex();
        $this->prepareZodiacsMonth();

        $this->prepareZodiacsDay();
        echo 'Done update Month and Day' . PHP_EOL;
    }

    /**
     * actionEverYear
     * @throws \Exception
     */
    public function actionEverYear()
    {
        $this->actionIndex();
        $this->prepareZodiacsYear();
        echo 'Done update Year' . PHP_EOL;
    }

    /**
     * Проверяем  зодиаки
     * и
     * @throws \Exception
     */
    public function prepareZodiacs()
    {
        $this->zodiacs = Zodiac::getAllZodiac();
        if (empty($this->zodiacs)) {
            $this->parseZodiacs();
            $this->zodiacs = Zodiac::getAllZodiac();
        }

    }

    /**
     * Проверяем и обновляем ZodiacsDay
     * @throws \Exception
     */
    public function prepareZodiacsDay()
    {

        foreach ($this->zodiacs as $zodiac) {

            $datadb = ZodiacDay::getZodiacDayByZodiac($zodiac->id);
            $dataparse = $this->parseZodiacsDay($zodiac);
            if (empty($datadb)) {
                $this->updateZodiacsDays($dataparse, true);
            }

            if ($dataparse != null and $dataparse != $datadb) {
                $this->updateZodiacsDays($dataparse);

            }
            if ($dataparse != null and ZodiacDay::getZodiacDayByZodiac($zodiac->id) != $dataparse) {
                ZodiacDay::delDays($zodiac->id);

                $this->updateZodiacsDays($dataparse, true);

            }

        }

    }


    /**
     * Обновляем гороскопы  на все дни
     * @param $days
     * @param bool $first
     * @throws \Exception
     */
    public function updateZodiacsDays($days, $first = false)
    {
        foreach ($days as $day) {
            $zodiac = new ZodiacDay();
            $zodiac->prepareAttributes($day);
            if ($first == true) {
                $zodiac->save();
            } else {
                $zodiac->updateDay();
            }
        }
    }

    /**
     * @throws \Exception
     */
    public function prepareZodiacsMonth()
    {

        foreach ($this->zodiacs as $zodiac) {
            $datadb = ZodiacMonth::getZodiacMonthByZodiac($zodiac->id);
            $dataparse = $this->parseZodiacsMonth($zodiac);
            if (empty($datadb)) {
                $zodiac = new ZodiacMonth();
                $zodiac->prepareAttributes($dataparse);
                $zodiac->save();
            }
            if ($dataparse != null and $dataparse != $datadb) {
                $zodiac = new ZodiacMonth();
                $zodiac->prepareAttributes($dataparse);
                $zodiac->updateMonth();

            }

        }
    }

    /**
     * @throws \Exception
     */
    public function prepareZodiacsYear()
    {

        foreach ($this->zodiacs as $zodiac) {
            $datadb = ZodiacYear::getZodiacYearByZodiac($zodiac->id);
            $dataparse = $this->parseZodiacsYear($zodiac);
            if (empty($datadb)) {
                $zodiac = new ZodiacYear();
                $zodiac->prepareAttributes($dataparse);
                $zodiac->save();
            }
            if ($dataparse != null and $dataparse != $datadb) {
                $zodiac = new ZodiacYear();
                $zodiac->prepareAttributes($dataparse);
                $zodiac->updateYear();

            }

        }


    }
}