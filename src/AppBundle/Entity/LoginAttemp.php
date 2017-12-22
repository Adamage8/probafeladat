<?php
/**
 * Created by PhpStorm.
 * User: Lenovo
 * Date: 2017. 12. 21.
 * Time: 23:44
 */

namespace AppBundle\Entity;


use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="login_attemp")
 */
class LoginAttemp
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", nullable=false)
     */
    private $ipAddress;

    /**
     * @ORM\Column(type="integer", nullable=false)
     */
    private $attemptCount;

    public function __construct($ip)
    {
        $this->attemptCount = 1;
        $this->ipAddress = $ip;
    }

    public function incrementAttemptCount()
    {
        $this->attemptCount += 1;
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getIpAddress()
    {
        return $this->ipAddress;
    }

    /**
     * @param mixed $ipAddress
     */
    public function setIpAddress($ipAddress)
    {
        $this->ipAddress = $ipAddress;
    }

    /**
     * @return mixed
     */
    public function getAttemptCount()
    {
        return $this->attemptCount;
    }

    /**
     * @param mixed $attemptCount
     */
    public function setAttemptCount($attemptCount)
    {
        $this->attemptCount = $attemptCount;
    }


}