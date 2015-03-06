<?php

namespace Knlv\Slim\Middleware;

use DOMPDF;
use Slim\Middleware;

class PdfResponse extends Middleware
{
    protected $pdf;

    public function __construct(DOMPDF $pdf)
    {
        $this->pdf = $pdf;
    }

    public function call()
    {
        $this->next->call();
        $response = $this->app->response;
        if ('application/pdf' === $response->headers->get('Content-Type')) {
            $this->pdf->load_html($response->getBody());
            $this->pdf->render();
            $response->setBody($this->pdf->output());
            $response->headers->set('Content-Type', 'application/pdf');
        }
    }
}
