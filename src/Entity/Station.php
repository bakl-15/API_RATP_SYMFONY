<?php

namespace App\Entity;

use App\Repository\StationRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: StationRepository::class)]
class Station
{
    #[ORM\Id]

    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    private $name;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $nameLong;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $nameIv;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $x;

    /**
     * @param mixed $id
     * @return Station
     */
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return mixed
     */
    public function getMain()
    {
        return $this->main;
    }

    /**
     * @param mixed $name
     * @return Station
     */
    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $y;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $geoPoint;

    #[ORM\Column(type: 'boolean', nullable: true)]
    private $main;

    #[ORM\ManyToMany(targetEntity: Line::class, inversedBy: 'stations')]
    private $line;

    #[ORM\OneToMany(mappedBy: 'station', targetEntity: Node::class)]
    private $nodes;



    public function __construct()
    {
        $this->line = new ArrayCollection();
        $this->nodes = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNameStation(): ?string
    {
        return $this->name;
    }

    public function setNameStation(string $nameStation): self
    {
        $this->name = $nameStation;

        return $this;
    }

    public function getNameLong(): ?string
    {
        return $this->nameLong;
    }

    public function setNameLong(?string $nameLong): self
    {
        $this->nameLong = $nameLong;

        return $this;
    }

    public function getNameIv(): ?string
    {
        return $this->nameIv;
    }

    public function setNameIv(?string $nameIv): self
    {
        $this->nameIv = $nameIv;

        return $this;
    }

    public function getX(): ?string
    {
        return $this->x;
    }

    public function setX(?string $x): self
    {
        $this->x = $x;

        return $this;
    }

    public function getY(): ?string
    {
        return $this->y;
    }

    public function setY(?string $y): self
    {
        $this->y = $y;

        return $this;
    }

    public function getGeoPoint(): ?string
    {
        return $this->geoPoint;
    }

    public function setGeoPoint(?string $geoPoint): self
    {
        $this->geoPoint = $geoPoint;

        return $this;
    }

    public function isMain(): ?bool
    {
        return $this->main;
    }

    public function setMain(?bool $main): self
    {
        $this->main = $main;

        return $this;
    }

    /**
     * @return Collection<int, Line>
     */
    public function getLine(): Collection
    {
        return $this->line;
    }

    public function addLine(Line $line): self
    {
        if (!$this->line->contains($line)) {
            $this->line[] = $line;
        }

        return $this;
    }

    public function removeLine(Line $line): self
    {
        $this->line->removeElement($line);

        return $this;
    }

    /**
     * @return Collection<int, Node>
     */
    public function getNodes(): Collection
    {
        return $this->nodes;
    }

    public function addNode(Node $node): self
    {
        if (!$this->nodes->contains($node)) {
            $this->nodes[] = $node;
            $node->setStation($this);
        }

        return $this;
    }

    public function removeNode(Node $node): self
    {
        if ($this->nodes->removeElement($node)) {
            // set the owning side to null (unless already changed)
            if ($node->getStation() === $this) {
                $node->setStation(null);
            }
        }

        return $this;
    }


}
