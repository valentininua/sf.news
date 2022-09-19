<?php

namespace App\Entity;

use App\Repository\NewsRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use phpDocumentor\Reflection\Types\Integer;

#[ORM\Entity(repositoryClass: NewsRepository::class)]
class News
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 455, nullable: true)]
    private ?string $title = null;

    #[ORM\Column(length: 455, nullable: true)]
    private ?string $description = null;

    #[ORM\Column(length: 455, nullable: true)]
    private ?string $image = null;

    #[Assert\DateTime]
    #[ORM\Column(type: 'datetime' , options: [
        "default"=>"CURRENT_TIMESTAMP"
    ] )]
    private ?\DateTime $createAt;

    #[Assert\DateTime]
    #[ORM\Column(type: 'datetime',  columnDefinition: "DATETIME on update CURRENT_TIMESTAMP" )]
    private ?\DateTime $updateAt;

    public function __construct()
    {
        $this->updateAt = new \DateTime();
        $this->createAt = new \DateTime();
    }
    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(?string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getUpdateAt(): ?\DateTime
    {
        return $this->updateAt;
    }

    public function setUpdateAt(?\DateTime $updateAt): ?self
    {
        $this->updateAt = $updateAt;

        return $this;
    }

    public function getCreateAt(): ?\DateTime
    {
        return $this->createAt;
    }

    public function setCreateAt(?\DateTime $createAt): ?self
    {
        $this->updateAt = $createAt;

        return $this;

    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(?string $image): self
    {
        $this->image = $image;

        return $this;
    }

}
