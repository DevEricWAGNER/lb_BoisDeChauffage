<?php

namespace App\Http\Controllers;

use App\Mail\PostMailInvoice;
use App\Mail\PostMailWelcome;
use App\Mail\PostMailCommand;
use App\Mail\ReactivateAccountMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class SendMailController extends Controller
{
    public static function sendInvoice($pdf, $url, $invoice_number, $nb_articles, $prix_articles, $livraison, $tva_bool, $tva, $prix_total, $shipping_adress1, $shipping_adress2, $shipping_adress3) {
        Mail::to(auth()->user()->email)->send(new PostMailInvoice([
            "numero_facture" => $invoice_number,
            "nb_articles" => $nb_articles,
            "pdf" => $pdf,
            "url" => $url,
            "prix_articles" => ($prix_articles / 100) . " €" ,
            "livraison" => ($livraison / 100) . " €",
            "tva_bool" => $tva_bool,
            "tva" => ($tva / 100) . " €",
            "prix_total" => ($prix_total / 100) . " €",
            "shipping_adress1" => $shipping_adress1,
            "shipping_adress2" => $shipping_adress2,
            "shipping_adress3" => $shipping_adress3
        ]));
    }

    public static function sendUpdateCommand($invoice_number, $statut_commande) {
        Mail::to(auth()->user()->email)->send(new PostMailCommand([
            "numero_facture" => $invoice_number,
            "status_commande" => $statut_commande
        ]));
    }

    public static function sendWelcome($email, $firstname, $lastname) {
        Mail::to($email)->send(new PostMailWelcome([
            "firstname" => $firstname,
            "lastname" => $lastname
        ]));
    }

    public static function reactivateAccount($email, $code) {
        $link = "https://srv658782.hstgr.cloud/reactivateAccount?email=" . $email . "&code=" . $code;
        Mail::to($email)->send(new ReactivateAccountMail([
            "link" => $link
        ]));
    }
}
