<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class QrCodeController extends Controller
{
    /**
     * Display the QR Code that links to the intern registration form
     */
    public function display()
    {
        // URL that the QR code should point to (qr.blade.php form)
        $url = route('qr');

        // Generate styled QR code
        $qrCode = QrCode::size(250)
                        ->backgroundColor(255, 255, 255)
                        ->color(52, 144, 220)
                        ->margin(2)
                        ->generate($url);

        return view('show-qr', compact('qrCode', 'url'));
    }
}
