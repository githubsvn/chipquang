<?php
namespace SM\Bundle\AdminBundle\Utilities;

class Rss
{

    /**
     * @param type $url
     * @return type
     */
    private static function getContentBytUrl($url, $authParam = array())
    {
        if (!function_exists('curl_init')) {
            return file_get_contents($url);
        }
	//$usr = 'USER_ID_OF_USER';
	//$pwd = 'PASSWORD_OF_USER';
        //echo "<pre>"; var_dump($authParam); die;

        $tmpfile = tempnam('/tmp', "owa");
        $curl = curl_init();
	//Return the transfer as a string of the return value of curl_exec() instead of outputting it out directly
	curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
	//Set URL to fetch
	curl_setopt($curl, CURLOPT_URL, $url);
	//Force HTTP version 1.1
	curl_setopt($curl, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);

        if (strpos($url, 'caisse-epargne.fr') !== false ) {
            //Use NTLM for HTTP authentication
            curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_NTLM);
            //Username:password to use for the connection
            curl_setopt($curl, CURLOPT_USERPWD, $authParam['rss_user'] . ':' . $authParam['rss_password']);
        } else {
            curl_setopt($curl, CURLOPT_PROXYTYPE, 'HTTP');
            //Use Proxy authentication
            curl_setopt($curl, CURLOPT_PROXY, $authParam['proxy_server']);
            //Username:password to use for the connection
            curl_setopt($curl, CURLOPT_PROXYUSERPWD, $authParam['proxy_user'] . ':' . $authParam['proxy_password']);
        }

	//Stop cURL from verifying the peers certification
	curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
	curl_setopt($curl, CURLOPT_COOKIEJAR, $tmpfile);
        curl_setopt($curl, CURLOPT_COOKIEFILE, $tmpfile);
	$useragent = 'Mozilla/5.0 (Macintosh; U; Intel Mac OS X; en-US; rv:1.8.1) Gecko/20061024 BonEcho/2.0';
        curl_setopt($curl, CURLOPT_USERAGENT, $useragent);

	$headers = array();
        $useragent = 'Accept: text/xml,application/xml,application/xhtml+xml,text/html;';
        $useragent .= 'q=0.9,text/plain;q=0.8,image/png,*/*;q=0.5';
        $headers[] = $useragent;
        $headers[] = 'Accept-Language: en-us,en;q=0.5';
        $headers[] = 'Accept-Charset: ISO-8859-1,utf-8;q=0.7,*;q=0.7';
	curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
	//Execute cURL session
	$result = curl_exec($curl);
	//Close cURL session
	curl_close($curl);
	return $result;
    }

   /**
     * @param type $url
     * @return type
     */
    private static function getContentBytUrlBackup($url)
    {
        if (!function_exists('curl_init')) {
            return file_get_contents($url);
        }
        $tmpfile = tempnam('/tmp', "owa");
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_COOKIEJAR, $tmpfile);
        curl_setopt($ch, CURLOPT_COOKIEFILE, $tmpfile);
        $useragent = 'Mozilla/5.0 (Macintosh; U; Intel Mac OS X; en-US; rv:1.8.1) Gecko/20061024 BonEcho/2.0';
        curl_setopt($ch, CURLOPT_USERAGENT, $useragent);

        $headers = array();
        $useragent = 'Accept: text/xml,application/xml,application/xhtml+xml,text/html;';
        $useragent .= 'q=0.9,text/plain;q=0.8,image/png,*/*;q=0.5';
        $headers[] = $useragent;
        $headers[] = 'Accept-Language: en-us,en;q=0.5';
        $headers[] = 'Accept-Charset: ISO-8859-1,utf-8;q=0.7,*;q=0.7';
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        $html = curl_exec($ch);
        curl_close($ch);
        return $html;
    }

    /**
     * @param type $url
     * @return type
     */
    public static function getXmlByRssLink($url, $authParam = array())
    {
        $content = Rss::getContentBytUrl($url, $authParam);
        if(Rss::checkIsRssFeed($content)){
            return $content;
        }
        return '';
    }

    /**
     * Check content is rss or not
     * @param type $content
     * @return int
     */
    private static function checkIsRssFeed($content)
    {
        if (strpos($content, "<?xml") !== false){
            return 1;
        }
        return 0;
    }

    /**
     * count item feed
     * @param type $url
     * @return int
     */
    public static function countItemFeedByRssLink($url)
    {
        $count = 0;
        try {
            $feed = @\Zend_Feed_Reader::import($url);
            foreach ($feed as $entry) {
                $count ++;
            }
        } catch (Exception $ex) {

        }
        return $count;
    }

    /**
     * get item feed
     * @param type $url
     * @return type
     */
    public static function getItemFeedsByRssLink($url)
    {
        $data = array();
        $feed = @\Zend_Feed_Reader::import($url);
        $data = array(
            'title' => $feed->getTitle(),
            'link' => $feed->getLink(),
            'dateModified' => $feed->getDateModified(),
            'description' => $feed->getDescription(),
            'language' => $feed->getLanguage(),
            'entries' => array(),
        );

        foreach ($feed as $entry) {
            $edata = array(
                'title' => $entry->getTitle(),
                'description' => $entry->getDescription(),
                'dateModified' => $entry->getDateModified(),
                'authors' => $entry->getAuthors(),
                'link' => $entry->getLink(),
                'content' => $entry->getContent()
            );
            $data['entries'][] = $edata;
        }
        return $data;
    }
}
