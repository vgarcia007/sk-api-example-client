<?php

class SK_API
{

    private $base_url;
    private $cache_dir;
    private $cache_time;
    private $image_cache_time;
    private $profile_image_cache_time;
    private $api_key;
    private $ssl;

    public function __construct()
    {

        $this->base_url = 'https://sk-api.satoshisplace.space/api/v1/';
        $this->api_key = '####'; // YOUR API KEY. GET ONE AT https://sk-api.satoshisplace.space
        $this->cache_dir = '/cache'; // ABSOLUTE PATH TO CACHE DIR. MUST BE WRITABLE!
        $this->cache_time = 600; // STANDARD CACHE TIME IN SECONDS
        $this->image_cache_time = 31536000; // CACHE TIME FOR IMAGES IN SECONDS
        $this->profile_image_cache_time = 86400; // CACHE TIME FOR PROFILE IMAGES IN SECONDS
        $this->ssl = true; // USE SSL?
    }


    private function generate_cache_path($url)
    {
        $url_hash = hash('md5', $url);
        return  $this->cache_dir . '/' . $url_hash;
    }


    private function is_cache_up2date($url)
    {

        $cache_time = $this->cache_time;

        if (strpos($url, 'get-image') !== false) {
            $cache_time = $this->image_cache_time;
        }

        if ((strpos($url, 'user_') !== false) and (strpos($url, 'get-image') !== false)) {
            $cache_time = $this->profile_image_cache_time;
        }

        $file = $this->generate_cache_path($url);

        if ((file_exists($file)) and (!(time() - filemtime($file) > 1 * $cache_time))) {
            return true;
        }
        return false;
    }

    private function write_cache($url, $content)
    {
        $file = $this->generate_cache_path($url);
        file_put_contents($file, $content);
    }

    private function get($url)
    {

        if ($this->is_cache_up2date($url)) {
            $file = $this->generate_cache_path($url);
            return file_get_contents($file);
        }

        $options = array(
            'http' => array(
                'method'  => 'GET',
                'header' => 'Authorization: Bearer ' . $this->api_key
            ),
            "ssl" => array(
                "verify_peer" => $this->ssl,
                "verify_peer_name" => $this->ssl,
            )
        );

        $context  = stream_context_create($options);
        if ($response = file_get_contents($url, false, $context)) {
            $this->write_cache($url, $response);
        };
        return $response;
    }

    public function get_posts()
    {
        return $this->get($this->base_url . 'get-posts');
    }

    public function get_post($id)
    {
        return $this->get($this->base_url . 'get-post/' . $id);
    }

    public function get_image($file_unique_id)
    {
        return $this->get($this->base_url . 'get-image/' . $file_unique_id);
    }
}
