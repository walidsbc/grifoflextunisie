<?php

namespace SBC\GrifoflexTunisieBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

/**
 * ProductPicture
 *
 * @ORM\Table(name="product_picture")
 * @ORM\Entity(repositoryClass="SBC\GrifoflexTunisieBundle\Repository\ProductPictureRepository")
 * @Vich\Uploadable
 */
class ProductPicture extends Picture
{

    /**
     * @ORM\ManyToOne(targetEntity="SBC\GrifoflexTunisieBundle\Entity\Product", inversedBy="pictures")
     * @ORM\JoinColumn(name="product_id", referencedColumnName="id")
     */
    protected $product;

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Set product
     *
     * @param \SBC\GrifoflexTunisieBundle\Entity\Product $product
     *
     * @return ProductPicture
     */
    public function setProduct(Product $product = null)
    {
        $this->product = $product;

        return $this;
    }

    /**
     * Get product
     *
     * @return \SBC\GrifoflexTunisieBundle\Entity\Product
     */
    public function getProduct()
    {
        return $this->product;
    }
}

