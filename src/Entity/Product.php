<?php

namespace App\Entity;

use App\Repository\ProductRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ProductRepository::class)
 * @ORM\Table(name="products")
 */
class Product
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $sort;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $active;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $title;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $slug;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $category_id;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $brand_id;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $artnumber;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $preview_image;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $detail_image;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $preview_text;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $detail_text;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $video;

    /**
     * @ORM\Column(type="decimal", precision=10, scale=0, nullable=true)
     */
    private $price;

    /**
     * @ORM\Column(type="decimal", precision=10, scale=0, nullable=true)
     */
    private $discount_price;

    /**
     * @ORM\Column(type="boolean")
     */
    private $sale;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $popular;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $hit;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $viewcounter;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $meta_title;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $meta_description;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $meta_keywords;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $created_at;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $updated_at;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $createdBy;



    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSort(): ?int
    {
        return $this->sort;
    }

    public function setSort(?int $sort): self
    {
        $this->sort = $sort;

        return $this;
    }

    public function isActive(): ?bool
    {
        return $this->active;
    }

    public function setActive(?bool $active): self
    {
        $this->active = $active;

        return $this;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function setSlug(?string $slug): self
    {
        $this->slug = $slug;

        return $this;
    }

    public function getCategoryId(): ?int
    {
        return $this->category_id;
    }

    public function setCategoryId(?int $category_id): self
    {
        $this->category_id = $category_id;

        return $this;
    }

    public function getBrandId(): ?int
    {
        return $this->brand_id;
    }

    public function setBrandId(?int $brand_id): self
    {
        $this->brand_id = $brand_id;

        return $this;
    }

    public function getArtnumber(): ?string
    {
        return $this->artnumber;
    }

    public function setArtnumber(?string $artnumber): self
    {
        $this->artnumber = $artnumber;

        return $this;
    }

    public function getPreviewImage(): ?string
    {
        return $this->preview_image;
    }

    public function setPreviewImage(?string $preview_image): self
    {
        $this->preview_image = $preview_image;

        return $this;
    }

    public function getDetailImage(): ?string
    {
        return $this->detail_image;
    }

    public function setDetailImage(?string $detail_image): self
    {
        $this->detail_image = $detail_image;

        return $this;
    }

    public function getPreviewText(): ?string
    {
        return $this->preview_text;
    }

    public function setPreviewText(?string $preview_text): self
    {
        $this->preview_text = $preview_text;

        return $this;
    }

    public function getDetailText(): ?string
    {
        return $this->detail_text;
    }

    public function setDetailText(?string $detail_text): self
    {
        $this->detail_text = $detail_text;

        return $this;
    }

    public function getVideo(): ?string
    {
        return $this->video;
    }

    public function setVideo(?string $video): self
    {
        $this->video = $video;

        return $this;
    }

    public function getPrice(): ?string
    {
        return $this->price;
    }

    public function setPrice(?string $price): self
    {
        $this->price = $price;

        return $this;
    }

    public function getDiscountPrice(): ?string
    {
        return $this->discount_price;
    }

    public function setDiscountPrice(?string $discount_price): self
    {
        $this->discount_price = $discount_price;

        return $this;
    }

    public function isSale(): ?bool
    {
        return $this->sale;
    }

    public function setSale(bool $sale): self
    {
        $this->sale = $sale;

        return $this;
    }

    public function isPopular(): ?bool
    {
        return $this->popular;
    }

    public function setPopular(?bool $popular): self
    {
        $this->popular = $popular;

        return $this;
    }

    public function isHit(): ?bool
    {
        return $this->hit;
    }

    public function setHit(?bool $hit): self
    {
        $this->hit = $hit;

        return $this;
    }

    public function getViewcounter(): ?int
    {
        return $this->viewcounter;
    }

    public function setViewcounter(?int $viewcounter): self
    {
        $this->viewcounter = $viewcounter;

        return $this;
    }

    public function getMetaTitle(): ?string
    {
        return $this->meta_title;
    }

    public function setMetaTitle(?string $meta_title): self
    {
        $this->meta_title = $meta_title;

        return $this;
    }

    public function getMetaDescription(): ?string
    {
        return $this->meta_description;
    }

    public function setMetaDescription(?string $meta_description): self
    {
        $this->meta_description = $meta_description;

        return $this;
    }

    public function getMetaKeywords(): ?string
    {
        return $this->meta_keywords;
    }

    public function setMetaKeywords(?string $meta_keywords): self
    {
        $this->meta_keywords = $meta_keywords;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->created_at;
    }

    public function setCreatedAt(?\DateTimeInterface $created_at): self
    {
        $this->created_at = $created_at;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->updated_at;
    }

    public function setUpdatedAt(?\DateTimeInterface $updated_at): self
    {
        $this->updated_at = $updated_at;

        return $this;
    }

    public function createdBy(): ?int
    {
        return $this->createdBy;
    }
}
