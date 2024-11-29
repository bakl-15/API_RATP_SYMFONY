<?php

namespace App\Entity;

use App\Repository\NodeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: NodeRepository::class)]
class Node
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'boolean', nullable: true)]
    private $isTerminus;

    #[ORM\ManyToOne(targetEntity: Line::class, inversedBy: 'node')]
    private $line;

    #[ORM\ManyToOne(targetEntity: Station::class, inversedBy: 'nodes')]
    private $station;



    public function __construct()
    {

    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function isIsTerminus(): ?bool
    {
        return $this->isTerminus;
    }

    public function setIsTerminus(?bool $isTerminus): self
    {
        $this->isTerminus = $isTerminus;

        return $this;
    }

    public function getLine(): ?Line
    {
        return $this->line;
    }

    public function setLine(?Line $line): self
    {
        $this->line = $line;

        return $this;
    }

    public function getStation(): ?Station
    {
        return $this->station;
    }

    public function setStation(?Station $station): self
    {
        $this->station = $station;

        return $this;
    }








}
