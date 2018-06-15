<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\LikedRepository")
 */
class Liked
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="boolean")
     */
    private $likeIt;



    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Works", inversedBy="likes")
     * @ORM\JoinColumn(nullable=false)
     */
    private $works;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $clientId;

    public function __construct()
    {
        $this->works = new ArrayCollection();
    }

    public function getId()
    {
        return $this->id;
    }

    public function getLikeIt(): ?bool
    {
        return $this->likeIt;
    }

    public function setLikeIt(bool $likeIt): self
    {
        $this->likeIt = $likeIt;

        return $this;
    }

    public function getWorks(): ?Works
    {
        return $this->works;
    }

    public function setWorks(?Works $works): self
    {
        $this->works = $works;

        return $this;
    }

    public function getClientId(): ?string
    {
        return $this->clientId;
    }

    public function setClientId(string $clientId): self
    {
        $this->clientId = $clientId;

        return $this;
    }

    public function addWork(Works $work): self
    {
        if (!$this->works->contains($work)) {
            $this->works[] = $work;
        }

        return $this;
    }

    public function removeWork(Works $work): self
    {
        if ($this->works->contains($work)) {
            $this->works->removeElement($work);
        }

        return $this;
    }


}
