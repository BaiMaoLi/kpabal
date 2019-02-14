<?php

class Webhose
{
    var $API_URL = "http://webhose.io";
    var $API_URL_PARAMS = "/%s?format=json&token=%s";
    var $API_KEY = null;
    var $ECHO_REQUEST_URL = false;

    var $NEXT = null;

    var $CURLOPTS = array(
        CURLOPT_SSL_VERIFYPEER => 0,
        CURLOPT_SSL_VERIFYHOST => 0,
        CURLOPT_RETURNTRANSFER => true
    );

    public function __construct() {

    }

    /**
     * @param string $api_key
     */
    public function config($api_key)
    {
        $this->API_KEY = $api_key;
    }

    /**
     * @param string $query_url
     * @return mixed
     */
    public function fetch_request($query_url)
    {
        if($this->ECHO_REQUEST_URL)
            echo "<p>" . $query_url . "</p>";

        $curl = curl_init($query_url);
        curl_setopt_array($curl, $this->CURLOPTS);
        $json = curl_exec($curl);
        curl_close($curl);

        $result = json_decode($json);


        $this->NEXT = isset($result->next) ? $this->API_URL . $result->next : null;

        return $result;
    }

    /**
     * @param bool $enable_debug
     */
    public function enable_debug($enable_debug)
    {
        $this->ECHO_REQUEST_URL = $enable_debug;
    }

    /**
     * @param string $type
     * @param ArrayObject $param_dict
     * @return mixed|null
     */
    public function query($type, $param_dict)
    {
        if($this->API_KEY == null) return null;
        $queryURL = $this->API_URL . sprintf($this->API_URL_PARAMS, $type, $this->API_KEY);

        foreach($param_dict as $key=> $value)
            $queryURL .= sprintf("&%s=%s", $key, urlencode($value));

        return $this->fetch_request($queryURL);
    }

    /**
     * @return mixed|null
     */
    public function get_next()
    {
        if($this->API_KEY == null) return null;
        if($this->NEXT == null) return null;
        return $this->fetch_request($this->NEXT);
    }
}

?>