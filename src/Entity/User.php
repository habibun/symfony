<?php

namespace App\Entity;

use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="fos_user")
 */
class User extends BaseUser
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var int
     * @ORM\Column(name="github_id", type="string", length=255, nullable=true)
     */
    private $githubId;

    /**
     * @var string
     * @ORM\Column(name="github_access_token", type="string", length=255, nullable=true)
     */
    private $githubAccessToken;

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return int
     */
    public function getGithubId()
    {
        return $this->githubId;
    }

    /**
     * @param int $githubId
     *
     * @return User
     */
    public function setGithubId($githubId)
    {
        $this->githubId = $githubId;

        return $this;
    }

    /**
     * @return string
     */
    public function getGithubAccessToken(): string
    {
        return $this->githubAccessToken;
    }

    /**
     * @param string $githubAccessToken
     * @return User
     */
    public function setGithubAccessToken(string $githubAccessToken = null): User
    {
        $this->githubAccessToken = $githubAccessToken;
        return $this;
    }
}
