<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

use App\Entity\Orcamento;
use App\Repository\OrcamentoRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;

use Symfony\Component\HttpFoundation\Request;

use Symfony\Component\Validator\Constraints\DateTime;

class OrcamentoController extends AbstractController
{
   

    /**
     * @Route("/orcamento", name="criar_orcamento", methods="POST")
     */
    public function criarOrcamento(Request $request): Response
    {
       
        $hora = date('H:i:s');
        $format = "Y-m-d H:i:s";
    
        $entityManager = $this->getDoctrine()->getManager();

        $orcamento = new Orcamento();
        $orcamento->setCliente($request->get('cliente'));
        $orcamento->setDataHoraOrcamento(\DateTime::createFromFormat($format, $request->get('data').' '.$hora));
        $orcamento->setVendedor($request->get('vendedor'));
        $orcamento->setDescricao($request->get('descricao'));
        $orcamento->setValorOrcado($request->get('valor'));
      
        $orcamentoRepository = $entityManager->getRepository(Orcamento::class)->criarOrcamento($entityManager,$orcamento);
         
        if($orcamentoRepository == 1){
            return $this->redirectToRoute('listaOrcamento');
        }else{
            return $this->render('orcamento/index.html.twig',['mensagem' => 'Erro ao cadastrar!']);
        } 

    }

    /**
     * @Route("/listaOrcamento", name="listaOrcamento", methods="GET")
     */
    public function listarOrcamento(){

       
       $array = array();
       $repositoryOrcamento = $this->getDoctrine()->getRepository(Orcamento::class);
       $orcamentos = $repositoryOrcamento->listarOrcamento();

       foreach ($orcamentos as $value) {
                $arrayOrcamento = array('id'=>$value->getId(),
                                    'cliente'=>$value->getCliente(),    
                                    'data' => date_format($value->getDataHoraOrcamento(),'d/m/Y H:i:s'),
                                    'vendedor'=>$value->getVendedor(),
                                    'descricao'=>$value->getDescricao(),
                                    'valor'=>$value->getValorOrcado()
                                    ); 
                array_push($array, $arrayOrcamento);
        }
        
        return $this->render('orcamento/listaOrcamento.html.twig', ['orcamentos' => $array]); 
        
    }

    /**
     * @Route("/excluirOrcamento/{id}", name="excluirOrcamento")
     */
    public function excluirOrcamento($id){

        $repositoryOrcamento = $this->getDoctrine()->getRepository(Orcamento::class);
        $orcamentos = $repositoryOrcamento->excluirOrcamento($id);
 
        return $this->redirectToRoute('listaOrcamento');
    }

     /**
     * @Route("/atualizarOrcamento", name="atualizarOrcamento", methods="POST")
     */
    public function atualizarOrcamento(Request $request){

        $repositoryOrcamento = $this->getDoctrine()->getRepository(Orcamento::class);
        $hora = date('H:i:s');
        $format = "Y-m-d H:i:s";
        
        $orcamento = new Orcamento();
        $orcamento->setId($request->get('id'));
        $orcamento->setCliente($request->get('cliente'));
        $orcamento->setDataHoraOrcamento(\DateTime::createFromFormat($format, $request->get('data').' '.$hora));
        $orcamento->setVendedor($request->get('vendedor'));
        $orcamento->setDescricao($request->get('descricao'));
        $orcamento->setValorOrcado($request->get('valor'));

        $orcamentos = $repositoryOrcamento->atualizarOrcamento($orcamento);
 
        if($orcamentos == 1){
            return $this->redirectToRoute('listaOrcamento');
        }else{
            return $this->redirectToRoute('index');
        } 
    }

     /**
     * @Route("/getOrcamento/{id}", name="getOrcamento")
     */
    public function getOrcamento($id){

        $repositoryOrcamento = $this->getDoctrine()->getRepository(Orcamento::class);
        $orcamento = $repositoryOrcamento->find($id);
        $arrayOrcamento = array();

        if($orcamento){
            $arrayOrcamento = array('id'=>$orcamento->getId(),
                                    'cliente'=>$orcamento->getCliente(),    
                                    'data'=>date_format($orcamento->getDataHoraOrcamento(),'Y-m-d'),
                                    'vendedor'=>$orcamento->getVendedor(),
                                    'descricao'=>$orcamento->getDescricao(),
                                    'valor'=>$orcamento->getValorOrcado()
            ); 

            return $this->render('orcamento/index.html.twig', ['orcamento' => $arrayOrcamento, 'mensagem' => null]);
        }else{
            return $this->render('orcamento/index.html.twig', ['orcamento' => $arrayOrcamento, 'mensagem' => 'Orçamento não identificado']);
        }
    }

    /**
     * @Route("/filtrarOrcamento/", name="filtrarOrcamento", methods="GET")
     */
    public function filtrarOrcamento(){

        $request = Request::createFromGlobals();
        $cliente = $request->query->get('cliente');
        $vendedor = $request->query->get('vendedor');
        $format = "Y-m-d H:i:s";
        
        $data_inicial = \DateTime::createFromFormat($format, $request->get('data_inicial') . '00:00:00');
        $data_final = \DateTime::createFromFormat($format, $request->get('data_final') . '00:00:00');

        $repositoryOrcamento = $this->getDoctrine()->getRepository(Orcamento::class);
        $orcamentos = $repositoryOrcamento->filtrarOrcamento($cliente, $vendedor, date_format($data_inicial,'Y-m-d'), date_format($data_final,'Y-m-d'));
        $arrayOrcamento = array();
        foreach ($orcamentos as $value) {
            $array = array(
                                'cliente'=>$value->getCliente(),    
                                'data' => date_format($value->getDataHoraOrcamento(),'d/m/Y H:i:s'),
                                'vendedor'=>$value->getVendedor(),
                                'descricao' => $value->getDescricao(),
                                'valor_orcado'=>$value->getValorOrcado()
                                ); 
            array_push($arrayOrcamento, $array);
    }

        return $this->render('orcamento/filtroOrcamento.html.twig', ['orcamento' => null, 'orcamentos' => $arrayOrcamento, 'mensagem' => null]);
        
    }

    /**
     * @Route("/", name="index");
     */
    public function index(){

        return $this->render('orcamento/index.html.twig',['orcamento' => null, 'mensagem' => null]);
    }
     /**
     * @Route("/filtroOrcamento", name="filtroOrcamento");
     */
    public function filtroOrcamento(){

        return $this->render('orcamento/filtroOrcamento.html.twig',['orcamento' => null, 'orcamentos' => array()]);
    }























    // public function index()
    // {
    //     return $this->render('orcamento/index.html.twig', [
    //         'controller_name' => 'OrcamentoController',
    //     ]);
    // }
}
