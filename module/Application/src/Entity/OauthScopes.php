<?php

namespace Application\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * OauthScopes
 *
 * @ORM\Table(name="oauth_scopes")
 * @ORM\Entity
 */
class OauthScopes
{
    /**
     * @var string
     *
     * @ORM\Column(name="scope", type="string", length=200, nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $scope;

    /**
     * @var string
     *
     * @ORM\Column(name="type", type="string", length=255, nullable=false)
     */
    private $type = 'supported';

    /**
     * @var string
     *
     * @ORM\Column(name="client_id", type="string", length=80, nullable=true)
     */
    private $clientId;

    /**
     * @var integer
     *
     * @ORM\Column(name="is_default", type="smallint", nullable=true)
     */
    private $isDefault;

    /**
     * Get scope
     *
     * @return string
     */
    public function getScope()
    {
        return $this->scope;
    }

    /**
     * Set type
     *
     * @param string $type
     *
     * @return OauthScopes
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get type
     *
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Set clientId
     *
     * @param string $clientId
     *
     * @return OauthScopes
     */
    public function setClientId($clientId)
    {
        $this->clientId = $clientId;

        return $this;
    }

    /**
     * Get clientId
     *
     * @return string
     */
    public function getClientId()
    {
        return $this->clientId;
    }

    /**
     * Set isDefault
     *
     * @param integer $isDefault
     *
     * @return OauthScopes
     */
    public function setIsDefault($isDefault)
    {
        $this->isDefault = $isDefault;

        return $this;
    }

    /**
     * Get isDefault
     *
     * @return integer
     */
    public function getIsDefault()
    {
        return $this->isDefault;
    }
}

