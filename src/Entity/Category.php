<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Core\Annotation\ApiResource;
use App\Controller\GetCategoryController;
use App\Repository\CategoryRepository;
use Symfony\Component\Serializer\Annotation\Groups;


/**
 * @ORM\Entity(repositoryClass=CategoryRepository::class)
 */
#[
    ApiResource(
        collectionOperations:[
            'get'=>[
                'filters'=>[],
                'normalization_context'=>['groups'=>['read:categories:collection']],
                'pagination_enabled'=>false,
                'method' => 'GET',
                'path' => '/categories',
                'controller' => GetCategoryController::class,
                'read' => false,
            ],
            'post'
        ],
        itemOperations:[
            'put',
            'delete',
            'get'=>['normalization_context'=>['groups'=>['read:categories:items']]],
        ]
    )
]
class Category
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    #[Groups(['read:product:collection','read:categories:collection','read:sub_categories:collection','read:categories:items'])]
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    #[Groups(['read:product:collection','read:categories:collection','read:sub_categories:collection','read:categories:items'])]
    private $name;

    /**
     * @ORM\Column(type="string", length=255)
     */
    #[Groups(['read:product:collection','read:categories:collection','read:sub_categories:collection','read:categories:items'])]
    private $image;

    /**
     * @ORM\Column(type="string", length=255)
     */
    #[Groups(['read:product:collection','read:categories:collection','read:sub_categories:collection','read:categories:items'])]
    private $description;

    /**
     * @ORM\OneToMany(targetEntity=SubCategory::class, mappedBy="category", orphanRemoval=true)
     */
    #[Groups(['read:categories:collection','read:categories:items'])]
    private $subCategories;

    public function __construct()
    {
        $this->subCategories = new ArrayCollection();
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

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(string $image): self
    {
        $this->image = $image;

        return $this;
    }
    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    /**
     * @return Collection|SubCategory[]
     */
    public function getSubCategories(): Collection
    {
        return $this->subCategories;
    }

    public function addSubCategory(SubCategory $subCategory): self
    {
        if (!$this->subCategories->contains($subCategory)) {
            $this->subCategories[] = $subCategory;
            $subCategory->setCategory($this);
        }

        return $this;
    }

    public function removeSubCategory(SubCategory $subCategory): self
    {
        if ($this->subCategories->removeElement($subCategory)) {
            // set the owning side to null (unless already changed)
            if ($subCategory->getCategory() === $this) {
                $subCategory->setCategory(null);
            }
        }

        return $this;
    }


}
