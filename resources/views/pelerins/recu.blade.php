<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Reçu de Paiement</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 14px;
            color: #333;
            margin: 0;
            padding: 20px;
            background: #f9f9f9;
        }
        .container {
            max-width: 800px;
            margin: 0 auto;
            background: #fff;
            padding: 20px;
            border: 1px solid #ddd;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
        }
        .header img {
            max-width: 120px;
            margin-bottom: 10px;
        }
        .header h1 {
            margin: 5px 0;
            font-size: 24px;
            color: #007bff;
        }
        .header h2 {
            margin: 0;
            font-size: 18px;
            color: #333;
        }
        .info {
            margin-bottom: 20px;
            border-bottom: 1px solid #ddd;
            padding-bottom: 10px;
        }
        .info p {
            margin: 5px 0;
        }
        .table-paiement {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        .table-paiement th, .table-paiement td {
            border: 1px solid #ddd;
            padding: 12px;
            text-align: left;
        }
        .table-paiement th {
            background-color: #007bff;
            color: #fff;
        }
        .table-paiement tbody tr:nth-child(even) {
            background-color: #f2f2f2;
        }
        .footer {
            margin-top: 30px;
            text-align: center;
            font-size: 12px;
            color: #666;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <img src="{{ $logo }}" alt="Logo de l'agence">
            <h1>{{ $agence->name }}</h1>
            <h2>Reçu de Paiement</h2>
            <p>Adresse: {{ $agence->address }}</p>
            <p>Téléphone: {{ $agence->phone_number }} | Email: {{ $agence->email }}</p>
        </div>

        <div class="info">
            <p><strong>ID INSCRIT:</strong> {{ str_pad($paiement->pelerin->id, 6, '0', STR_PAD_LEFT) }}</p>
            <p><strong>Nom:</strong>{{ strtoupper($paiement->pelerin->nom) }} </p>
            <p><strong>Prénom:</strong> {{ucfirst($paiement->pelerin->prenom)  }}</p>
            <p><strong>N° Passeport/CNIB:</strong> {{ $paiement->pelerin->passeport }}</p>
            <p><strong>Facilitateur/SC:</strong> {{ $paiement->pelerin->facilitateur }}</p>
            <p><strong>Date d'inscription:</strong> {{ $paiement->pelerin->created_at->format('d/m/Y à H:i:s') }}</p>
        </div>

        <table class="table-paiement">
            <thead>
                <tr>
                    <th>N° Versement</th>
                    <th>Type Versement</th>
                    <th>Motif</th>
                    <th>Date Versement</th>
                    <th>Montant du Versement</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>{{ str_pad($paiement->id, 6, '0', STR_PAD_LEFT) }}</td>
                    <td>{{ $paiement->mode_paiement }}</td>
                    <td>{{ $paiement->pelerin->motifCandidat->nom }}</td>
                    <td>{{ \Carbon\Carbon::parse($paiement->date_versement)->format('d/m/Y') }}</td>
                    <td>{{ number_format($paiement->montant, 0, ',', ' ') }} FCFA</td>
                </tr>
            </tbody>
        </table>

        <div class="info">
            <p><strong>Montant payé :</strong> {{ number_format($paiement->montant, 0, ',', ' ') }} FCFA</p>
            <p><strong>Total versé :</strong> {{ number_format($totalVerse, 0, ',', ' ') }} FCFA</p>
            <p><strong>Reste à payer :</strong> {{ number_format($resteAPayer, 0, ',', ' ') }} FCFA</p>
            <p><strong>La caisse :</strong> {{$name}}</p>
        </div>

        <div class="footer">
            <p>Merci de bien vouloir vérifier le montant de vos versements sur le reçu devant notre caissier(e).</p>
        </div>
    </div>
</body>
</html>
