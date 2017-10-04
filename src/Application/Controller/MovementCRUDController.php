<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
namespace Sil\Bundle\StockBundle\Application\Controller;

use Blast\CoreBundle\Controller\CRUDController;

/**
 * Description of MovementController
 *
 * @author Glenn Cavarlé <glenn.cavarle@libre-informatique.fr>
 */
class MovementCRUDController extends CRUDController
{

    public function createAction($object = null)
    {
        $request = $this->getRequest();
        // the key used to lookup the template
        $templateKey = 'edit';

        $this->admin->checkAccess('create');

        $class = new \ReflectionClass($this->admin->hasActiveSubClass() ? $this->admin->getActiveSubClass() : $this->admin->getClass());

        if ( $class->isAbstract() ) {
            return $this->render(
                    'SonataAdminBundle:CRUD:select_subclass.html.twig',
                    array(
                        'base_template' => $this->getBaseTemplate(),
                        'admin' => $this->admin,
                        'action' => 'create',
                    ), null, $request
            );
        }

//        $object = $object ? $object : $this->admin->getNewInstance();
//
//        $preResponse = $this->preCreate($request, $object);
//        if ( $preResponse !== null ) {
//            return $preResponse;
//        }
//
//        $this->admin->setSubject($object);
//
//        /** @var $form \Symfony\Component\Form\Form */
        $form = $this->admin->getForm();
//        $form->setData($object);
        
        $form->handleRequest($request);

        if ( $form->isSubmitted() ) {
            //TODO: remove this check for 4.0
            if ( method_exists($this->admin, 'preValidate') ) {
                $this->admin->preValidate($object);
            }
            $isFormValid = $form->isValid();

            // persist if the form was valid and if in preview mode the preview was approved
            if ( $isFormValid && (!$this->isInPreviewMode($request) || $this->isPreviewApproved($request)) ) {
                $this->admin->checkAccess('create', $object);

                try {
                    $object = $this->admin->create($object);

                    if ( $this->isXmlHttpRequest() ) {
                        return $this->renderJson(array(
                                'result' => 'ok',
                                'objectId' => $this->admin->getNormalizedIdentifier($object),
                                ), 200, array());
                    }

                    $this->addFlash(
                        'sonata_flash_success',
                        $this->admin->trans(
                            'flash_create_success',
                            array('%name%' => $this->escapeHtml($this->admin->toString($object))),
                            'SonataAdminBundle'
                        )
                    );

                    // redirect to edit mode
                    return $this->redirectTo($object);
                } catch ( ModelManagerException $e ) {
                    $this->handleModelManagerException($e);

                    $isFormValid = false;
                }
            }

            // show an error message if the form failed validation
            if ( !$isFormValid ) {
                if ( !$this->isXmlHttpRequest() ) {
                    $this->addFlash(
                        'sonata_flash_error',
                        $this->admin->trans(
                            'flash_create_error',
                            array('%name%' => $this->escapeHtml($this->admin->toString($object))),
                            'SonataAdminBundle'
                        )
                    );
                }
            } elseif ( $this->isPreviewRequested() ) {
                // pick the preview template if the form was valid and preview was requested
                $templateKey = 'preview';
                $this->admin->getShow();
            }
        }

        $view = $form->createView();

        // set the theme for the current Admin Form
        $this->defineFormTheme($view, $this->admin->getFormTheme());

        return $this->render($this->admin->getTemplate($templateKey),
                array(
                'action' => 'create',
                'form' => $view,
                'object' => $object,
                ), null);
    }
}
