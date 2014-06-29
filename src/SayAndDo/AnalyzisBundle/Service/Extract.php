<?php

namespace SayAndDo\AnalyzisBundle\Service;

//use Guzzle\Http\Client;

use Embedly\Embedly;

class Extract
{
    // Token expires on 2014-07-04

    public function getArticle($url)
    {

        if (!is_array($url)) {
            $url = array($url);
        }

        // Call with pro (you'll need a real key)
        $pro = new Embedly(
            array(
                'key' => '76585d936d62445aaa604e7256e82c1d',
                'user_agent' => 'Mozilla/5.0 (compatible; mytestapp/1.0)'
            )
        );

        $objs = $pro->extract(
            array(
                'urls' => $url
            )
        );

        return $objs[0]->content;
    }

    public function  getEmbedlyParts()
    {

        // require_once('src/Embedly/Embedly.php');  // if using source
        $api = new Embedly(array('user_agent' => 'Mozilla/5.0 (compatible; mytestapp/1.0)'));

        // Single url
        $objs = $api->oembed('http://www.youtube.com/watch?v=sPbJ4Z5D-n4&feature=topvideos');
        print_r($objs);

        // Multiple urls
        $obj = $api->oembed(array(
                'urls' => array(
                    'http://www.youtube.com/watch?v=sPbJ4Z5D-n4&feature=topvideos',
                    'http://twitpic.com/3yr7hk'
                )
            ));
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
