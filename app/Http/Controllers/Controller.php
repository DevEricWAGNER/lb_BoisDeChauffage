<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Support\Facades\Storage;

abstract class Controller
{
    public function downloadInvoice($invoice_pdf_url, $invoice_number)
    {
        // Créer un répertoire "invoices" dans le dossier storage/app/public
        $folder = 'invoices';

        // Définir le nom du fichier PDF (par exemple, en utilisant le numéro de facture)
        $fileName = $invoice_number . '.pdf';

        // Utiliser CURL pour télécharger le fichier PDF depuis l'URL
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $invoice_pdf_url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        $fileContent = curl_exec($ch);

        if(curl_errno($ch)) {
            throw new Exception(curl_error($ch));
        }

        curl_close($ch);

        // Enregistrer le contenu du fichier dans le répertoire "storage/app/public/invoices"
        $path = $folder . '/' . $fileName;
        Storage::disk('public')->put($path, $fileContent);

        return $path;
    }
}