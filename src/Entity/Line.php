<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\LineRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: LineRepository::class)]
#[ApiResource]
class Line
{
    #[ORM\Id]

    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    private $name;

    #[ORM\ManyToMany(targetEntity: Station::class, mappedBy: 'line')]
    private $stations;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $idrefliga;

    /**
     * @param mixed $id
     * @return Line
     */
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $idrefligc;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $codLigf;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $resCom;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $codeResf;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $resStif;

    #[ORM\OneToMany(mappedBy: 'line', targetEntity: Node::class)]
    private $node;



    public function __construct()
    {
        $this->stations = new ArrayCollection();
        $this->node = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return Collection<int, Station>
     */
    public function getStations(): Collection
    {
        return $this->stations;
    }

    public function addStation(Station $station): self
    {
        if (!$this->stations->contains($station)) {
            $this->stations[] = $station;
            $station->addLine($this);
        }

        return $this;
    }

    public function removeStation(Station $station): self
    {
        if ($this->stations->removeElement($station)) {
            $station->removeLine($this);
        }

        return $this;
    }

    public function getIdrefliga(): ?string
    {
        return $this->idrefliga;
    }

    public function setIdrefliga(?string $idrefliga): self
    {
        $this->idrefliga = $idrefliga;

        return $this;
    }

    public function getIdrefligc(): ?string
    {
        return $this->idrefligc;
    }

    public function setIdrefligc(?string $idrefligc): self
    {
        $this->idrefligc = $idrefligc;

        return $this;
    }

    public function getCodLigf(): ?string
    {
        return $this->codLigf;
    }

    public function setCodLigf(?string $codLigf): self
    {
        $this->codLigf = $codLigf;

        return $this;
    }

    public function getResCom(): ?string
    {
        return $this->resCom;
    }

    public function setResCom(?string $resCom): self
    {
        $this->resCom = $resCom;

        return $this;
    }

    public function getCodeResf(): ?string
    {
        return $this->codeResf;
    }

    public function setCodeResf(?string $codeResf): self
    {
        $this->codeResf = $codeResf;

        return $this;
    }

    public function getResStif(): ?string
    {
        return $this->resStif;
    }

    public function setResStif(?string $resStif): self
    {
        $this->resStif = $resStif;

        return $this;
    }

    /**
     * @return Collection<int, Node>
     */
    public function getNode(): Collection
    {
        return $this->node;
    }

    public function addNode(Node $node): self
    {
        if (!$this->node->contains($node)) {
            $this->node[] = $node;
            $node->setLine($this);
        }

        return $this;
    }

    public function removeNode(Node $node): self
    {
        if ($this->node->removeElement($node)) {
            // set the owning side to null (unless already changed)
            if ($node->getLine() === $this) {
                $node->setLine(null);
            }
        }

        return $this;
    }


}
