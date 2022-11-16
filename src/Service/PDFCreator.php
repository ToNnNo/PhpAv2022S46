<?php

namespace App\Service;

use Spipu\Html2Pdf\Html2Pdf;

class PDFCreator
{

    protected function create($source): Html2Pdf
    {
        ob_start();
        $client = "Abergel Michael";
        require $source;
        $content = ob_get_clean();

        $html2pdf = new Html2Pdf('P', 'A4', 'fr');
        $html2pdf->writeHTML($content); // converti le HTML en PDF

        return $html2pdf;
    }

    // void (= procedure), on ne retourne pas de valeur
    public function display($source, $outputname = null): void
    {
        // creation du pdf
        $html2pdf = $this->create($source);
        // l'affichage
        if( null == $outputname ) {
            $html2pdf->output();
        } else {
            $html2pdf->output($outputname);
        }
    }

    public function download($source, $outputname): void
    {
        $html2pdf = $this->create($source);
        $html2pdf->output($outputname, 'D');
    }

    public function save($source, $outputname): void
    {
        $html2pdf = $this->create($source);
        $html2pdf->output($outputname, 'F');
    }

}
