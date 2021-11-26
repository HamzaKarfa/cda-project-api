<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\SubCategoryRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=SubCategoryRepository::class)
 */
#[
    ApiResource(
        collectionOperations:[
            'get'=>[
                'normalization_context'=>['groups'=>['read:sub_categories:collection']],
                'pagination_enabled'=>false,
            ],
            'post'
        ],
        itemOperations:[
            'put',
            'delete',
            'get'
        ]
    )
]
class SubCategory
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    #[Groups(['read:product:collection','read:sub_categories:collection', 'read:categories:collection','read:categories:items',  'write:product:item'])]
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    #[Groups(['read:product:collection','read:sub_categories:collection','read:categories:collection','read:categories:items'])]
    private $name;

    /**
     * @ORM\Column(type="string", length=255)
     */
    #[Groups(['read:product:collection','read:sub_categories:collection','read:categories:collection'])]
    private $image;
    /**
     * @ORM\ManyToOne(targetEntity=Category::class, inversedBy="subCategories")
     * @ORM\JoinColumn(nullable=false)
     */
    #[Groups(['read:product:collection','read:sub_categories:collection'])]

    private $category;


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

    public function getCategory(): ?Category
    {
        return $this->category;
    }

    public function setCategory(?Category $category): self
    {
        $this->category = $category;

        return $this;
    }
}
