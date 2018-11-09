<?php

interface ClientInterface
{
    public function getHTML() : string;
}


/**
 * Класс для получения html по ссылке
 */
class HTMLClient implements ClientInterface
{
    /**
     * @var string Ссылка
     */
    private $url;

    /**
     * HTMLClient constructor.
     * @param string $url ссылка
     */
    public function __construct(string $url)
    {
        if(!$this->isValidUrl($url)) {
            throw new \Exception('Ссылка не верная!');
        }
        $this->url = $url;
    }

    /**
     * Проверка ссылки
     * @param string $url ссылка
     * @return boolean|string
     */
    protected function isValidUrl(string $url)
    {
        return filter_var($url, FILTER_VALIDATE_URL) !== false;
    }

    /**
     * Получение html
     * @return string
     * @throws Exception
     */
    public function getHTML() : string
    {
        $html = file_get_contents($this->url);

        if(empty($html)) {
            throw new \Exception('Ответ не получен или пустой!');
        }

        return $html;
    }

}

/**
 * Класс парсинга html
 */
class HTMLParser
{
    /**
     * @var Клиент
     */
    private $client;

    /**
     * @var array Список тегов и их кол-во
     */
    private $htmlList;

    /**
     * HTMLParser constructor.
     * @param ClientInterface $client
     */
    public function __construct(ClientInterface $client)
    {
        $this->client = $client;
        $this->htmlList = [];
    }

    /**
     * Парсит HTML
     * @throws Exception
     */
    public function parse()
    {
        $html = $this->client->getHTML();

        // Не совсем верная, но другую не подобрал =(
        preg_match_all('/<([^\/!][a-z1-9]*)/i', $html, $matches);

        if (!empty($matches[1])){
            $this->htmlList = array_count_values($matches[1]);
        }

        return $this;
    }

    /**
     * Возвращает список HTML тегов с кол-вом
     * @return array
     */
    public function getResult() :array
    {
        return $this->htmlList;
    }

}


###############################################################

try {
    $parser = new HTMLParser(new HTMLClient('https://github.com/'));
    $htmlList = $parser->parse()->getResult();
    if(count($htmlList) > 0){
        foreach ($htmlList as $tag => $cnt){
            echo $tag.' => '.$cnt.PHP_EOL;
        }
    }
} catch (\Exception $e){
    echo 'Ошибка: '.$e->getMessage();
}

