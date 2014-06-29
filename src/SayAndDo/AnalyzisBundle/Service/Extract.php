<?php

namespace SayAndDo\AnalyzisBundle\Service;

//use Guzzle\Http\Client;

use Embedly\Embedly;

class Extract
{
    // Token expires on 2014-07-04

    public function getArticle($url)
    {
        $url = array($url);
        $websiteParts = $this->extractUrls($url);
        return $websiteParts[0]->content;
    }


    /**
     * Extract website parts
     * @param array $urls
     *
     * @return object
     */
    public function extractUrls(array $urls)
    {
        $pro = new Embedly(
            array(
                'key' => '76585d936d62445aaa604e7256e82c1d',
                'user_agent' => 'Mozilla/5.0 (compatible; mytestapp/1.0)'
            )
        );

        return $pro->extract(
            array(
                'urls' => $urls
            )
        );
    }

    /**
     * Demo method
     */
    private function exampleEmbedly()
    {
        $api = new Embedly(array('user_agent' => 'Mozilla/5.0 (compatible; mytestapp/1.0)'));

        // Single url
        $objs = $api->oembed('http://www.youtube.com/watch?v=sPbJ4Z5D-n4&feature=topvideos');
        print_r($objs);

        // Multiple urls
        $obj = $api->oembed(
            array(
                'urls' => array(
                    'http://www.youtube.com/watch?v=sPbJ4Z5D-n4&feature=topvideos',
                    'http://twitpic.com/3yr7hk'
                )
            )
        );
        print_r($obj);
    }

    public function getDifdBotArticle($url)
    {
        $client = new Client();
        $res = $client->get(
            'http://api.diffbot.com/v3/article',
            [
                'query' => ['token' => '357d35ae4e944a4efcd6e62dedc10dc2', 'url' => $url]
            ]
        );
        $response = $res->getBody();
        return $response;
    }
}
