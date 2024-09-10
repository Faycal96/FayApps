<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Reçu de Paiement</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            font-size: 10px;
            color: #333;
            margin: 0;
            padding: 0;
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
            page-break-inside: avoid;
        }

        /* Header avec tableau */
        .header {
            border-bottom: 1px solid #ddd;
            padding-bottom: 10px;
            margin-bottom: 15px;
        }
        .header table {
            width: 100%;
            border-collapse: collapse;
        }
        .header img {
            max-width: 70px;
            vertical-align: middle;
        }
        .header td {
            padding: 0 10px;
            vertical-align: middle;
        }
        .header .details {
            text-align: left;
        }
        .header .details h1 {
            margin: 0;
            font-size: 16px; /* Taille plus grande pour le nom de l'agence */
            font-weight: bold;
            color: #000;
        }
        .header .details p {
            margin: 2px 0;
            font-size: 10px;
            line-height: 1.2;
        }
        .header .details p.phone-email {
            margin: 0;
            font-size: 9px; /* Taille légèrement plus petite pour le téléphone et l'email */
        }

        /* Titre Reçu de Paiement */
        .title {
            font-weight: bold;
            font-size: 12px;
            text-align: center;
            margin: 20px 0;
            color: #000;
        }

        /* Tableaux d'information */
        .info-table, .amount-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 10px;
        }
        .info-table th, .info-table td, .amount-table th, .amount-table td {
            padding: 8px;
            text-align: left;
        }
        .info-table th, .amount-table th {
            background-color: #f2f2f2;
            color: #000;
            font-weight: bold;
        }
        .info-table td, .amount-table td {
            border-bottom: 1px solid #ddd;
        }

        /* Tableaux de montants */
        .amount-table td.red {
            color: red;
        }
        .amount-table, .info-table {
            border: 1px solid #ddd;
        }
        .amount-table th, .amount-table td {
            border: 1px solid #ddd;
        }

        /* Signature sans bordure */
        .signature-section {
            margin: 20px 0;
        }
        .signature-table {
            width: 100%;
        }
        .signature-table td {
            width: 50%;
            vertical-align: bottom;
            padding: 5px;
        }
        .signature-table .label {
            font-weight: bold;
            text-align: center;
        }

        .footer {
            margin-top: 10px;
            text-align: center;
            font-size: 10px;
            color: #666;
        }

        /* Ligne de séparation pour découpe */
        .separator {
            border-top: 2px dashed #333;
            margin: 20px 0;
            text-align: center;
            position: relative;
        }
        .separator span {
            position: absolute;
            top: -12px;
            background-color: #fff;
            padding: 0 10px;
            color: #333;
        }

        /* Duplication du reçu */
        .duplicate-receipt {
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Première section - Reçu pour le client -->
        <div class="header">
            <table>
                <tr>
                    <td style="width: 80px;">
                        <img src="{{ $logo }}" alt="Logo de l'agence">
                    </td>
                    <td class="details">
                        <h1>{{ $agence->name }}</h1>
                        <p>{{ $agence->address }}</p>
                        <p class="phone-email">Tél : {{ $agence->phone_number }} / Email : {{ $agence->email }}</p>
                    </td>
                </tr>
            </table>
        </div>

        <!-- Titre Reçu de Paiement -->
        <div class="title">Reçu de Paiement N° {{ str_pad($paiement->id, 6, '0', STR_PAD_LEFT) }}</div>

        <!-- Informations générales du pèlerin -->
        <table class="info-table">
            <tr>
                <th>Nom</th>
                <td>{{ strtoupper($paiement->pelerin->nom) }}</td>
                <th>Prénom</th>
                <td>{{ ucfirst($paiement->pelerin->prenom) }}</td>
            </tr>
            <tr>
                <th>N° Passeport/CNIB</th>
                <td>{{ $paiement->pelerin->passeport }}</td>
                <th>Facilitateur/SC</th>
                <td>{{ $paiement->pelerin->facilitateur }}</td>
            </tr>
        </table>

        <!-- Montant du paiement -->
        <table class="amount-table">
            <thead>
                <tr>
                    <th>Type Versement</th>
                    <th>Motif</th>
                    <th>Date Versement</th>
                    <th>Montant Versé</th>
                    <th>Reste à payer</th>
                    <th>Total Versé</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>{{ $paiement->mode_paiement }}</td>
                    <td>{{ $paiement->pelerin->motifCandidat->nom }}</td>
                    <td>{{ \Carbon\Carbon::parse($paiement->date_versement)->format('d/m/Y') }}</td>
                    <td>{{ number_format($paiement->montant, 0, ',', ' ') }} FCFA</td>
                    <td class="red">{{ number_format($resteAPayer, 0, ',', ' ') }} FCFA</td>
                    <td>{{ number_format($totalVerse, 0, ',', ' ') }} FCFA</td>
                </tr>
            </tbody>
        </table>

        <!-- Signature -->
        <div class="signature-section">
            <table class="signature-table">
                <tr>
                    <td class="label">Signature du pèlerin</td>
                    <td class="label">Signature du caissier(e) {{ $name }}</td>
                </tr>
            </table>
        </div>

        <div class="footer">
            <p>Merci de bien vouloir vérifier le montant de vos versements sur le reçu devant notre caissier(e).</p>
        </div>

        <!-- Ligne de séparation -->
        <div class="separator"><span></span></div>

        <!-- Deuxième section - Reçu pour l'agence -->
        <div class="duplicate-receipt">
            <div class="header">
                <table>
                    <tr>
                        <td style="width: 80px;">
                            <img src="{{ $logo }}" alt="Logo de l'agence">
                        </td>
                        <td class="details">
                            <h1>{{ $agence->name }}</h1>
                            <p>{{ $agence->address }}</p>
                            <p class="phone-email">Tél : {{ $agence->phone_number }} / Email : {{ $agence->email }}</p>
                        </td>
                    </tr>
                </table>
            </div>

            <!-- Titre Reçu de Paiement -->
            <div class="title">Reçu de Paiement N° {{ str_pad($paiement->id, 6, '0', STR_PAD_LEFT) }}</div>

            <!-- Informations générales du pèlerin -->
            <table class="info-table">
                <tr>
                    <th>Nom</th>
                    <td>{{ strtoupper($paiement->pelerin->nom) }}</td>
                    <th>Prénom</th>
                    <td>{{ ucfirst($paiement->pelerin->prenom) }}</td>
                </tr>
                <tr>
                    <th>N° Passeport/CNIB</th>
                    <td>{{ $paiement->pelerin->passeport }}</td>
                    <th>Facilitateur/SC</th>
                    <td>{{ $paiement->pelerin->facilitateur }}</td>
                </tr>
            </table>

            <!-- Montant du paiement -->
            <table class="amount-table">
                <thead>
                    <tr>
                        <th>Type Versement</th>
                        <th>Motif</th>
                        <th>Date Versement</th>
                        <th>Montant Versé</th>
                        <th>Reste à payer</th>
                        <th>Total Versé</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>{{ $paiement->mode_paiement }}</td>
                        <td>{{ $paiement->pelerin->motifCandidat->nom }}</td>
                        <td>{{ \Carbon\Carbon::parse($paiement->date_versement)->format('d/m/Y') }}</td>
                        <td>{{ number_format($paiement->montant, 0, ',', ' ') }} FCFA</td>
                        <td class="red">{{ number_format($resteAPayer, 0, ',', ' ') }} FCFA</td>
                        <td>{{ number_format($totalVerse, 0, ',', ' ') }} FCFA</td>
                    </tr>
                </tbody>
            </table>

            <!-- Signature -->
            <div class="signature-section">
                <table class="signature-table">
                    <tr>
                        <td class="label">Signature du pèlerin</td>
                        <td class="label">Signature du caissier(e) {{ $name }}</td>
                    </tr>
                </table>
            </div>

            <div class="footer">
                <p>Merci de bien vouloir vérifier le montant de vos versements sur le reçu devant notre caissier(e).</p>
            </div>
        </div>
    </div>
</body>
</html>
