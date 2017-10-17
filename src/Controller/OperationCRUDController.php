<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
namespace Sil\Bundle\StockBundle\Controller;

use Blast\CoreBundle\Controller\CRUDController;
use Sil\Bundle\StockBundle\Domain\Entity\Operation;
use Sil\Bundle\StockBundle\Domain\Service\OperationServiceInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;

/**
 * Description of MovementController
 *
 * @author Glenn Cavarlé <glenn.cavarle@libre-informatique.fr>
 */
class OperationCRUDController extends CRUDController
{


    public function preEdit(Request $request, $operation)
    {
        $this->getOperationService()->makeItDraft($operation);
        $this->admin->update($operation);
        parent::preEdit($request, $operation);
    }

    /**
     *
     * @var OperationServiceInterface 
     */
    protected $operationService;

    public function confirmAction()
    {
        /* @var $operation Operation */
        $operation = $this->admin->getSubject();

        $this->getOperationService()->confirm($operation);
        $this->admin->update($operation);

        return $this->redirectTo($operation);
    }

    public function reserveAction()
    {
        /* @var $operation Operation */
        $operation = $this->admin->getSubject();

        $this->getOperationService()->reserveUnits($operation);
        $this->admin->update($operation);

        //nothing has been reserved because no stock available
        if ( $operation->isConfirmed() ) {
            $this->addFlash('sonata_flash_info',
                $this->trans(
                    'sil.stock.operation.message.no_available_stock_for_reservation'));
        }


        return $this->redirectTo($operation);
    }

    public function cancelAction()
    {
        /* @var $operation Operation */
        $operation = $this->admin->getSubject();

        $this->getOperationService()->cancel($operation);
        $this->admin->update($operation);

        return $this->redirectTo($operation);
    }

    public function applyAction()
    {
        /* @var $operation Operation */
        $operation = $this->admin->getSubject();

        $this->getOperationService()->apply($operation);
        $this->admin->update($operation);

        return $this->redirectTo($operation);
    }

    /**
     * Redirect the user depend on this choice.
     *
     * @param object $object
     *
     * @return RedirectResponse
     */
    protected function redirectTo($object)
    {
        $request = $this->getRequest();

        $url = false;

        if ( null !== $request->get('btn_update_and_list') ) {
            $url = $this->admin->generateUrl('list');
        }
        if ( null !== $request->get('btn_create_and_list') ) {
            $url = $this->admin->generateUrl('list');
        }

        if ( null !== $request->get('btn_create_and_create') ) {
            $params = array();
            if ( $this->admin->hasActiveSubClass() ) {
                $params['subclass'] = $request->get('subclass');
            }
            $url = $this->admin->generateUrl('create', $params);
        }

        if ( $this->getRestMethod() === 'DELETE' ) {
            $url = $this->admin->generateUrl('list');
        }

        if ( !$url ) {
            foreach ( array('show', 'edit') as $route ) {
                if ( $this->admin->hasRoute($route) && $this->admin->hasAccess($route,
                        $object) ) {
                    $url = $this->admin->generateObjectUrl($route, $object);

                    break;
                }
            }
        }

        if ( !$url ) {
            $url = $this->admin->generateUrl('list');
        }

        return new RedirectResponse($url);
    }

    /**
     * 
     * @return OperationServiceInterface
     */
    public function getOperationService(): OperationServiceInterface
    {
        return $this->operationService;
    }

    /**
     * 
     * @param OperationServiceInterface $operationService
     */
    public function setOperationService(OperationServiceInterface $operationService)
    {
        $this->operationService = $operationService;
    }
}
