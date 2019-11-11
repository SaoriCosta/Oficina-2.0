<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints\DateTime;
/**
 * @ORM\Entity(repositoryClass="App\Repository\OrcamentoRepository")
 */
class Orcamento
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private $cliente;

    // /**
    //  * @ORM\Column(type="datetime")
    //  */
    // private $data_hora_orcamento;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private $vendedor;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private $descricao;

    /**
     * @ORM\Column(type="float")
     */
    private $valor_orcado;

    /**
     * @ORM\Column(type="datetime")
     */
    private $data_hora_orcamento;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(int $id): self
    {
        $this->id = $id;

        return $this;
    }
    public function getCliente(): ?string
    {
        return $this->cliente;
    }

    public function setCliente(string $cliente): self
    {
        $this->cliente = $cliente;

        return $this;
    }

    public function getVendedor(): ?string
    {
        return $this->vendedor;
    }

    public function setVendedor(string $vendedor): self
    {
        $this->vendedor = $vendedor;

        return $this;
    }

    public function getDescricao(): ?string
    {
        return $this->descricao;
    }

    public function setDescricao(string $descricao): self
    {
        $this->descricao = $descricao;

        return $this;
    }

    public function getValorOrcado(): ?float
    {
        return $this->valor_orcado;
    }

    public function setValorOrcado(float $valor_orcado): self
    {
        $this->valor_orcado = $valor_orcado;

        return $this;
    }

    public function getDataHoraOrcamento(): ?\DateTimeInterface
    {
        return $this->data_hora_orcamento;
    }

    public function setDataHoraOrcamento(\DateTimeInterface $data_hora_orcamento): self
    {
        $this->data_hora_orcamento = $data_hora_orcamento;

        return $this;
    }

}
