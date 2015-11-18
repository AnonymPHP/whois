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
