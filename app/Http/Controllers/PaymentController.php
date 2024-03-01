<?php

namespace App\Http\Controllers;

use App\Models\Application;
use App\Models\Payment;
use App\Models\Procedure;
use Carbon\Carbon;
use Illuminate\Http\Request;

class PaymentController extends Controller


{
    public function create($procedure, $application)
    {
        // Assurez-vous d'avoir accès au modèle Procedure et Application
        // pour récupérer les instances spécifiques par leurs IDs
        $procedureInstance = Procedure::findOrFail($procedure);
        $applicationInstance = Application::findOrFail($application);
    
        // Passez les instances à la vue
        return view('admin.payments.create', compact('procedureInstance', 'applicationInstance'));
    }

    public function showVerifyForm($procedure, $application, $payment)
    {
        // Récupération des instances par leurs IDs
        $procedureInstance = Procedure::findOrFail($procedure);
        $applicationInstance = Application::findOrFail($application);
        $paymentInstance = Payment::findOrFail($payment);
    
       
        return view('admin.payments.verify', compact('procedureInstance', 'applicationInstance', 'paymentInstance'));
    }
    
    
    
    public function createPayment(Request $request, $procedure, Application $application) {
        $otp = rand(100000, 999999); // Générer un OTP aléatoire

        $payment = Payment::create([
            'application_id' => $application->id,
            'phone' => $request->phone,
            'amount' => $request->amount,
            'otp' => $otp,
        ]);

        // Ici, simulez l'envoi de l'OTP au numéro de téléphone
        // Dans un cas réel, vous enverriez l'OTP via un service de SMS

        return redirect()->route('admin.payments.verify', ['procedure' => $procedure, 'application' => $application, 'payment' => $payment->id])->with('success', 'OTP envoyé. Veuillez vérifier votre téléphone pour le code de vérification.');
    }

public function verifyPayment(Request $request, $procedure, $applicationId, $paymentId)
{
    // Assurez-vous de récupérer l'instance de modèle Application correcte
    $application = Application::findOrFail($applicationId);
    $payment = Payment::findOrFail($paymentId);

    if ($payment->otp === $request->otp) {
        $payment->otp_verified_at = now();
        $payment->save();

        // Mettre à jour le statut de paiement de l'application à 'payé'
        $application->payment_status = 'payé';
        $application->save();

        return redirect()->route('procedures.applications.index',$procedure)->with('success', 'OTP envoyé. Veuillez vérifier votre téléphone pour le code de vérification.');
    }

    return back()->with('error', 'OTP invalide.');
}



}
