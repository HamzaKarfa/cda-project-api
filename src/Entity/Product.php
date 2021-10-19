<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\ProductRepository;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Core\Annotation\ApiFilter;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\SearchFilter;
use Symfony\Component\Serializer\Annotation\Groups;
/**
 * @ORM\Entity(repositoryClass=ProductRepository::class)
 */
#[
    ApiResource(
        paginationItemsPerPage:15,
        normalizationContext:['groups'=>['read:product:collection']],
        itemOperations:[
            'put'=>[
                'denormalization_context'=> ['groups'=>['put:product:item']]
            ],
            'delete',
            'get'=>[
                'normalization_context'=> ['groups'=>['read:product:collection', 'read:product:item']]
            ]
        ]
    ),
    ApiFilter(SearchFilter::class , properties: ['subCategory.name'=> 'exact', 'subCategory.category.name' => 'exact'])
]
class Product
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    #[Groups(['read:product:collection'])]
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    #[Groups(['read:product:collection', 'put:Product'])]
    private $name;

    /**
     * @ORM\Column(type="float")
     */
    #[Groups(['read:product:collection'])]
    private $price;

    /**
     * @ORM\Column(type="string", length=255)
     */
    #[Groups(['read:product:collection','read:product:item'])]
    private $origin;

    /**
     * @ORM\Column(type="string", length=255)
     */
    #[Groups(['read:product:collection'])]
    private $image;

    /**
     * @ORM\ManyToOne(targetEntity=SubCategory::class)
     * @ORM\JoinColumn(nullable=false)
     */
    #[Groups(['read:product:collection','read:subCategory'])]
    private $subCategory;

    /**
     * @ORM\Column(type="datetime")
     */
    #[Groups(['read:product:item'])]
    private $created_at;

    /**
     * @ORM\Column(type="datetime")
     */
    #[Groups(['read:product:item'])]
    private $updated_at;

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

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(string $image): self
    {
        $this->image = $image;
        return $this;
    }

    public function getPrice(): ?float
    {
        return $this->price;
    }

    public function setPrice(float $price): self
    {
        $this->price = $price;

        return $this;
    }

    public function getOrigin(): ?string
    {
        return $this->origin;
    }

    public function setOrigin(string $origin): self
    {
        $this->origin = $origin;

        return $this;
    }

    public function getSubCategory(): ?SubCategory
    {
        return $this->subCategory;
    }

    public function setSubCategory(?SubCategory $subCategory): self
    {
        $this->subCategory = $subCategory;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->created_at;
    }

    public function setCreatedAt(\DateTimeInterface $created_at): self
    {
        $this->created_at = $created_at;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->updated_at;
    }

    public function setUpdatedAt(\DateTimeInterface $updated_at): self
    {
        $this->updated_at = $updated_at;

        return $this;
    }
}
