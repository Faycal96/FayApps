<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Récépissé d'Inscription</title>
    <style>
        body {
            font-family: 'DejaVu Sans', sans-serif;
            margin: 40px;
            color: #333;
            background-color: #f9f9f9;
            line-height: 1.6;
        }
        header {
            text-align: center;
            border-bottom: 3px solid #0044cc;
            padding-bottom: 15px;
            margin-bottom: 25px;
            background-color: #ffffff;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        .header-logo img {
            max-width: 80px;
            border-radius: 8px;
            margin-bottom: 10px;
        }
        .header-info {
            display: inline-block;
            text-align: center;
        }
        .header-info h1 {
            margin: 0;
            font-size: 24px;
            color: #0044cc;
        }
        .header-info p {
            margin: 2px 0;
            font-size: 12px;
        }
        .title {
            text-align: center;
            text-transform: uppercase;
            font-size: 18px;
            margin-bottom: 20px;
            color: #0044cc;
        }
        .info-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 30px;
            background-color: #ffffff;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        .info-table th, .info-table td {
            border: 1px solid #ddd;
            padding: 15px;
            font-size: 12px;
            text-align: left;
        }
        .info-table th {
            background-color: #0044cc;
            color: #ffffff;
            font-weight: bold;
        }
        .info-table tr:nth-child(even) {
            background-color: #f4f4f4;
        }
        .info-table tr:hover {
            background-color: #e0e0e0;
        }
        .info-table td {
            border-left: 3px solid #0044cc; /* Ajoute une bordure de gauche colorée */
        }
        .info-table th:first-child, .info-table td:first-child {
            border-left: none; /* Supprime la bordure de gauche pour la première colonne */
        }
        .footer {
            text-align: center;
            font-size: 12px;
            color: #666;
            border-top: 1px solid #ddd;
            padding-top: 10px;
        }
    </style>
</head>
<body>
    <header>
        <div class="header-logo">
            <img src="{{ $logo }}" alt="Logo de l'agence">
        </div>
        <div class="header-info">
            <h1>{{ $agence->name }}</h1>
            <p>Adresse: {{ $agence->address }}</p>
            <p>Téléphone: {{ $agence->phone_number }}</p>
            <p>Email: {{ $agence->email }}</p>
        </div>
    </header>

    <div class="title">
        <strong>Récépissé d'Inscription N° {{ str_pad($pelerin->id, 6, '0', STR_PAD_LEFT) }}</strong>
    </div>

    <table class="info-table">
        <tr>
            <th>Nom Complet</th>
            <td>{{ strtoupper($pelerin->nom) }} {{ ucfirst($pelerin->prenom) }}</td>
        </tr>
        <tr>
            <th>Passeport/CNIB</th>
            <td>{{ $pelerin->passeport }}</td>
        </tr>
        <tr>
            <th>Date de Naissance</th>
            <td>{{ \Carbon\Carbon::parse($pelerin->date_naissance)->format('d/m/Y') }}</td>
        </tr>
        <tr>
            <th>Nationalité</th>
            <td>{{ $pelerin->nationalite }}</td>
        </tr>
        <tr>
            <th>Téléphone</th>
            <td>{{ $pelerin->telephone }}</td>
        </tr>
        <tr>
            <th>Edition Hadj</th>
            <td>{{ $pelerin->motifCandidat->nom }}</td>
        </tr>
        <tr>
            <th>Facilitateur/SC</th>
            <td>{{ $pelerin->facilitateur }}</td>
        </tr>
    </table>

    <div class="footer">
        <p>Document généré automatiquement le {{ \Carbon\Carbon::now()->format('d/m/Y') }}. Aucune signature requise.</p>
    </div>
</body>
</html>
