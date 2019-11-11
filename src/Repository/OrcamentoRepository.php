<?php

namespace App\Repository;

use App\Entity\Orcamento;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;

use Doctrine\ORM\Query\ResultSetMapping;
/**
 * @method Orcamento|null find($id, $lockMode = null, $lockVersion = null)
 * @method Orcamento|null findOneBy(array $criteria, array $orderBy = null)
 * @method Orcamento[]    findAll()
 * @method Orcamento[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class OrcamentoRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Orcamento::class);
    }
  

    public function criarOrcamento(EntityManagerInterface $entityManager, Orcamento $orcamento){

        try{
            
            $entityManager->persist($orcamento);
            $entityManager->flush();

        }catch(Exception $e){

             return 0;

        }finally{

             return 1;
             
        }
        
    }
    public function listarOrcamento(): array{

        $entityManager = $this->getEntityManager();
        $query = $entityManager->createQuery('SELECT o FROM App\Entity\Orcamento o');

        return $query->getResult();

    }
    public function excluirOrcamento($id): int{

        $entityManager = $this->getEntityManager();
        $query = $entityManager->createQuery('DELETE FROM App\Entity\Orcamento o WHERE o.id = :id')
        ->setParameter('id', $id);

        return $query->getResult();

    }
    public function atualizarOrcamento(Orcamento $orcamento): int{

        $entityManager = $this->getEntityManager();
        $query = $entityManager->createQuery(
            'UPDATE App\Entity\Orcamento o SET o.cliente = :cliente, 
                                               o.data_hora_orcamento = :data_hora_orcamento,
                                               o.vendedor = :vendedor,
                                               o.descricao = :descricao,
                                               o.valor_orcado = :valor_orcado 
                                               WHERE o.id = :id'
        )->setParameter('id', $orcamento->getId())
        ->setParameter('cliente', $orcamento->getCliente())
        ->setParameter('data_hora_orcamento', $orcamento->getDataHoraOrcamento())
        ->setParameter('vendedor', $orcamento->getVendedor())
        ->setParameter('descricao', $orcamento->getDescricao())
        ->setParameter('valor_orcado', $orcamento->getValorOrcado());

        return $query->getResult();

    }
    public function filtrarOrcamento($cliente, $vendedor, $data_inicial, $data_final): array{

        $entityManager = $this->getEntityManager();
        $consulta = 'SELECT o FROM App\Entity\Orcamento o WHERE ';

        if(!($cliente == null || $cliente == '')){
            $consulta .= 'o.cliente = :cliente and ';
        }
        if(!($vendedor == null || $vendedor == '')){
            $consulta .= 'o.vendedor = :vendedor and ';
        }
        
        $consulta .= 'o.data_hora_orcamento BETWEEN :data_inicial and :data_final';
        
        
        if(!($cliente == null || $cliente == '') && ($vendedor == null || $vendedor == '')){

            $query = $entityManager->createQuery($consulta)->setParameter('cliente', $cliente)
                                                           ->setParameter('data_inicial', $data_inicial)
                                                           ->setParameter('data_final', $data_final);
            
        }else if(!($vendedor == null || $vendedor == '') && ($cliente == null || $cliente == '')){
            
            $query = $entityManager->createQuery($consulta)->setParameter('data_inicial', $data_inicial)
                                                           ->setParameter('data_final', $data_final)
                                                           ->setParameter('vendedor', $vendedor);

        }else if(!($vendedor == null || $vendedor == '') && !($cliente == null || $cliente == '')){

            $query = $entityManager->createQuery($consulta)->setParameter('cliente', $cliente)
                                                           ->setParameter('data_inicial', $data_inicial)
                                                           ->setParameter('data_final', $data_final)
                                                           ->setParameter('vendedor', $vendedor);
        }else{

            
            $query = $entityManager->createQuery($consulta)->setParameter('data_inicial', $data_inicial)
                                                           ->setParameter('data_final', $data_final);
        
        }
        
                                                    
        

        return $query->getResult();

    }

}
