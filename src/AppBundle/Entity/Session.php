<?php
namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;


/**
 * @ORM\Entity()
 * @ORM\Table(name="sessions")
 */
class Session
{
    /**
     * @ORM\Id
     * @ORM\Column(type="string", length=128)
     */
    private $sess_id;

    /**
     * @ORM\Column(type="blob", nullable=false)
     */
    private $sess_data;

    /**
     * @ORM\Column(type="integer", nullable=false)
     */
    private $sess_time;

    /**
     * @ORM\Column(type="integer", nullable=false)
     */
    private $sess_lifetime;



    /**
     * @return mixed
     */
    public function getSessId()
    {
        return $this->sess_id;
    }

    /**
     * @return mixed
     */
    public function getSessData()
    {
        return $this->sess_data;
    }

    /**
     * @param mixed $sess_data
     */
    public function setSessData($sess_data)
    {
        $this->sess_data = $sess_data;
    }

    /**
     * @return mixed
     */
    public function getSessTime()
    {
        return $this->sess_time;
    }

    /**
     * @param mixed $sess_time
     */
    public function setSessTime($sess_time)
    {
        $this->sess_time = $sess_time;
    }

    /**
     * @return mixed
     */
    public function getSessLifetime()
    {
        return $this->sess_lifetime;
    }

    /**
     * @param mixed $sess_lifetime
     */
    public function setSessLifetime($sess_lifetime)
    {
        $this->sess_lifetime = $sess_lifetime;
    }
}