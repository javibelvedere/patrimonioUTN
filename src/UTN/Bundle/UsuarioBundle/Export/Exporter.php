<?php


namespace UTN\Bundle\UsuarioBundle\Export;

use Exporter\Source\SourceIteratorInterface;
use Symfony\Component\HttpFoundation\Response;
use Sonata\AdminBundle\Export\Exporter as BaseExporter;


class Exporter extends BaseExporter
{
    protected $knpSnappyPdf;
    protected $templateEngine;

    public function getResponse($format, $filename, SourceIteratorInterface $source)
    {
        if ('pdf' != $format) {
            return parent::getResponse($format, $filename, $source);
        }

        /*$html = $this->templateEngine->renderView('UTNUsuarioBundle:Export:pdf.html.twig', array(
            'source' => $source
        ));*/
        $html = $this->templateEngine->render('UTNUsuarioBundle:Export:pdf.html.twig', array(
            'source' => $source
        ));
        $content = $this->knpSnappyPdf->getOutputFromHtml($html);

        return new Response($content, 200, array(
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => sprintf('attachment; filename=%s', $filename)
        ));
    }

    public function setKnpSnappyPdf($service)
    {
        $this->knpSnappyPdf = $service;
    }

    public function setTemplateEngine($service)
    {
        $this->templateEngine = $service;
    }

}