<?php
/**
 *  This file belongs to AnonymPHP Framework
 *
 * @author vahitserifsaglam1 <vahit.serif119@gmail.com>
 * @website http://anonymphp.com/framework
 */

namespace Anonym;

use InvalidArgumentException;

/**
 * Class Whois
 * @package Anonym
 */
class Whois
{

    /**
     * the domain url address
     *
     * @var string
     */
    protected $domain;

    /**
     * Whois resolver server
     *
     * @var string
     */
    private $server = 'whois.domain.com';

    /**
     * @var string
     */
    protected $result;

    /**
     * an array story  for parsed datas
     *
     * @var array
     */
    protected $datas;

    /**
     *
     * Construct
     *
     * @param  string $domain Domain name
     * @throws InvalidArgumentException If the domain is not valid
     */
    public function __construct($domain)
    {
        // Is valid?
        if (preg_match("/^([-a-z0-9]{2,100})\.([a-z\.]{2,8})$/i", $domain)) {

            // Store
            $this->domain = $domain;

            // Run
            $this->execute();

        } else {

            // Invalid domain
            throw new InvalidArgumentException('Invalid domain');
        }
    }


    /**
     * Query DNS server
     *
     * @return bool
     */
    private function execute()
    {
        // Connect
        if ($connection = fsockopen($this->server, 43)) {

            // Query
            fputs($connection, $this->domain . "\r\n");

            // Store response
            $this->result = '';
            while (!feof($connection)) {
                $this->result .= fgets($connection);
            }

            return true;
        }

        return false;
    }

    /**
     * parse data
     *
     * @return array
     */
    public function parseData()
    {
        $lines = explode("\n", $this->getResult());

        $datas = [];

        $status = 0;
        foreach ($lines as $line) {

            if ($status == 0) {
                if (preg_match_all("/   (.*?):\s(.*+)/i", $line, $matches)) {
                    $name = $matches[1][0];
                    $value = $matches[2][0];

                    $value = trim($value);
                    if ($value == '' || empty($value)) continue;

                    $this->datas[trim($name)] = $value;
                }
            } else {
                if (preg_match_all("/(.*?):\s(.*+)/i", $line, $matches)) {
                    $name = $matches[1][0];
                    $value = $matches[2][0];

                    $value = trim($value);
                    if ($value == '' || empty($value)) continue;

                    $this->datas[trim($name)] = $value;
                }
            }
            if (strstr($line, '====================================================')) {
                $status = 1;
            }

        }

        return $this;
    }

    /**
     * @return array
     */
    public function getDatas()
    {
        return $this->datas;
    }

    /**
     * @param array $datas
     */
    public function setDatas($datas)
    {
        $this->datas = $datas;
        return $this;
    }

    /**
     * prints datas as json
     *
     * @return void
     */
    public function printByJson(){
        header('Content-Type: application/json');

        echo json_encode($this->datas);
    }
    /**
     * @return string
     */
    public function getResult()
    {
        return $this->result;
    }

    /**
     * @param string $result
     * @return $this
     */
    public function setResult($result)
    {
        $this->result = $result;
        return $this;
    }
}
