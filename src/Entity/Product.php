<?php

namespace App\Entity;
use App\Repository\ProductRepository;
use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Core\Annotation\ApiFilter;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\SearchFilter;
use Symfony\Component\Serializer\Annotation\Groups;
use App\Controller\PostProductController;
use Symfony\Component\Serializer\Annotation\SerializedName;

/**
 * @ORM\Entity(repositoryClass=ProductRepository::class)
 */
#[
    ApiResource(
        collectionOperations:[
            'get'=>[
                'normalization_context'=> ['groups'=>[ 'read:product:collection']]
            ],
            'post'=>[
                'method'=>'POST',
                'controller'=> PostProductController::class,
                'deserialize'=>false,
                'validate'=>false,
                'openapi_context' => [
                    'requestBody' => [
                        'content' => [
                            'multipart/form-data' => [
                                'schema' => [
                                    'type' => 'object',
                                    'properties' => [
                                        'image' => [
                                            'type' => 'string',
                                            'format' => 'binary',
                                        ],
                                        'name' => [
                                            'type' => 'string',
                                            'format' => 'string',
                                        ],
                                        'origin' => [
                                            'type' => 'string',
                                            'format' => 'string',
                                        ],
                                        'price' => [
                                            'type' => 'float',
                                            'format' => 'float',
                                        ],
                                        'price_type' => [
                                            'type' => 'string',
                                            'format' => 'string',
                                        ],
                                        'sub_categories'=>[
                                            'type' => 'integer',
                                            'format' => 'integer',
                                        ]
                                    ],
                                ],
                            ],
                        ],
                    ],
                ],
            ],
           
        ],
        itemOperations:[
            'put'=>[
                'denormalization_context'=> ['groups'=>['put:product:item']]
            ],
            'delete',
            'get'=>[
                'normalization_context'=> ['groups'=>[ 'read:product:item']]
            ],          
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
    #[Groups(['read:product:collection',
        'write:order:item',
        'read:product:item'
    ])]
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    #[Groups(['read:product:collection',
        'write:order:item',
        'write:product:item',
        'read:product:item',
        'put:product:item'
    ])]
    private $name;

    /**
     * @ORM\OneToOne(targetEntity=Price::class, inversedBy="product", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    #[Groups(['read:product:collection',
        'write:order:item',
        'read:product:item',
        'put:product:item'
    ])]
    private $price;

    /**
     * @ORM\Column(type="string", length=255)
     */
    #[Groups(['read:product:collection','read:product:item',
        'write:order:item',
        'write:product:item',
        'put:product:item'
    ])]
    private $origin;

    /**
     * @ORM\OneToOne(targetEntity=Image::class, cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=true)
     */
    #[Groups(['write:order:item',
        'write:product:item',
        'read:product:item',
        'read:product:collection',
    ])]
    private $image;
    
    /**
     * @ORM\ManyToOne(targetEntity=SubCategory::class)
     * @ORM\JoinColumn(nullable=false)
     */
    #[
        SerializedName('sub_categories'),
        Groups(['read:product:collection',
            'read:subCategory',
            'write:product:item',
            'read:product:item',
            'put:product:item'
        ])
    ]
    private $subCategory;

    /**
     * @ORM\Column(type="datetime")
     */
    
    private $created_at;

    /**
     * @ORM\Column(type="datetime")
     */
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

    public function getImage(): ?Image
    {
        return $this->image;
    }

    public function setImage( Image $image): self
    {
        $this->image = $image;
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

    public function getPrice(): ?Price
    {
        return $this->price;
    }

    public function setPrice(Price $price): self
    {
        $this->price = $price;

        return $this;
    }
}
