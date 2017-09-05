<?php

namespace SBC\GrifoflexTunisieBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * QuotationProduct
 *
 * @ORM\Table(name="quotation_product")
 * @ORM\Entity(repositoryClass="SBC\GrifoflexTunisieBundle\Repository\QuotationProductRepository")
 */
class QuotationProduct
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="reference", type="string", length=255)
     */
    private $reference;

    /**
     * @var string
     *
     * @ORM\Column(name="title", type="string", length=255)
     */
    private $title;

    /**
     * @var string
     *
     * @ORM\Column(name="quantity", type="string", length=255)
     */
    private $quantity;


    /**
     * @ORM\ManyToOne(targetEntity="SBC\GrifoflexTunisieBundle\Entity\Quotation", inversedBy="products")
     * @ORM\JoinColumn(name="event_id", referencedColumnName="id")
     */
    protected $quotation;


    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set reference
     *
     * @param string $reference
     *
     * @return QuotationProduct
     */
    public function setReference($reference)
    {
        $this->reference = $reference;

        return $this;
    }

    /**
     * Get reference
     *
     * @return string
     */
    public function getReference()
    {
        return $this->reference;
    }

    /**
     * Set title
     *
     * @param string $title
     *
     * @return QuotationProduct
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set quantity
     *
     * @param string $quantity
     *
     * @return QuotationProduct
     */
    public function setQuantity($quantity)
    {
        $this->quantity = $quantity;

        return $this;
    }

    /**
     * Get quantity
     *
     * @return string
     */
    public function getQuantity()
    {
        return $this->quantity;
    }


    /**
     * Set quotation
     *
     * @param \SBC\GrifoflexTunisieBundle\Entity\Quotation $quotation
     *
     * @return QuotationProduct
     */
    public function setQuotation( $quotation = null)
    {
        $this->quotation = $quotation;

        return $this;
    }

    /**
     * Get quotation
     *
     * @return \SBC\GrifoflexTunisieBundle\Entity\Quotation
     */
    public function getQuotation()
    {
        return $this->quotation;
    }

}

