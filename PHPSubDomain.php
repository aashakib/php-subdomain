<?php

/**
 * Class PHPSubDomain
 */
class PHPSubDomain
{
    /**
     * @var
     */
    protected $username;
    /**
     * @var
     */
    protected $password;
    /**
     * @var
     */
    protected $domain;
    /**
     * @var
     */
    protected $subDomain;
    /**
     * @var
     */
    protected $skin;
    /**
     * @var
     */
    protected $locationPath;
    /**
     * @var int
     */
    protected $port;
    /**
     * @var array
     */
    private $error = array();

    /**
     * PHPSubDomain constructor.
     * @param $username
     * @param $password
     * @param $domain
     * @param $subDomain
     * @param $skin
     * @param $path
     * @param $port
     */
    public function __construct($username, $password, $domain, $subDomain, $skin, $path, $port)
    {
        $this->username = $username;
        $this->password = $password;
        $this->domain = $domain;
        $this->subDomain = $subDomain;
        $this->skin = $skin;
        $this->locationPath = $path;
        $this->port = $port;
    }

    /**
     * @return string
     */
    public function create()
    {
        $errors = $this->validateData($this->domain, $this->port, $this->username, $this->password, $this->skin, $this->subDomain, $this->locationPath);

        if (!$errors){
            $request = '/frontend/'.$this->skin.'/subdomain/doadddomain.html?rootdomain='.$this->domain.'&domain='.$this->subDomain.'&dir='.$this->locationPath;

            return $this->_processRequest($this->domain, $this->port, $this->username, $this->password, $request);
        }else{
            return $errors;
        }
    }

    /**
     *
     */
    public function delete()
    {
        $errors = $this->validateData($this->domain, $this->port, $this->username, $this->password, $this->skin, $this->subDomain, $this->locationPath);

        if (!$errors){
            $request = '/frontend/'.$this->skin.'/subdomain/dodeldomain.html?domain='.$this->subDomain.'_'.$this->domain;

            return $this->_processRequest($this->domain, $this->port, $this->username, $this->password, $request);
        }else{
            return $errors;
        }
    }

    /**
     * @param $host
     * @param $port
     * @param $ownerName
     * @param $password
     * @param $requestUrl
     * @return string
     */
    private function _processRequest($host, $port, $ownerName, $password, $requestUrl)
    {
        $result = '';

        $socket = fsockopen($host, $port);
        if (!$socket) {
            print('Socket error');
            exit();
        }

        $authorize = base64_encode($ownerName.':'.$password);
        $request = "GET $requestUrl\r\n";
        $request .= "HTTP/1.0\r\n";
        $request .= "Host:$host\r\n";
        $request .= "Authorization: Basic $authorize\r\n";
        $request .= "\r\n";

        fputs($socket, $request);
        while (!feof($socket)) {
            $result .= fgets($socket, 128);
        }
        fclose($socket);

        return $result;
    }

    /**
     * @param $domain
     * @param $port
     * @param $username
     * @param $password
     * @param $skin
     * @param $subDomain
     * @param $path
     * @return array
     */
    protected function validateData($domain, $port, $username, $password, $skin, $subDomain, $path){
        if (empty($domain)){
            $this->error['errors']['domain'] = 'Domain cannot be empty!';
        }
        if (empty($port)){
            $this->error['errors']['port'] = 'Port cannot be empty!';
        }
        if (empty($username)){
            $this->error['errors']['username'] = 'Username cannot be empty!';
        }
        if (empty($password)){
            $this->error['errors']['password'] = 'Password cannot be empty!';
        }
        if (empty($skin)){
            $this->error['errors']['skin'] = 'Skin cannot be empty!';
        }
        if (empty($subDomain)){
            $this->error['errors']['subdomain'] = 'Subdomain cannot be empty!';
        }
        if (empty($path)){
            $this->error['errors']['path'] = 'Path cannot be empty!';
        }

        return $this->error;
    }

}