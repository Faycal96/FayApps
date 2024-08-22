<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Récépissé d'Inscription</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            margin: 40px;
            color: #333;
            background-color: #f4f4f4;
            line-height: 1.6;
        }
        header {
            text-align: center;
            border-bottom: 4px solid #0056b3;
            padding-bottom: 20px;
            margin-bottom: 30px;
            background-color: #ffffff;
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
        }
        .header-logo img {
            max-width: 100px;
            border-radius: 8px;
        }
        .header-info {
            display: inline-block;
            text-align: center;
            margin-top: 10px;
        }
        .header-info h1 {
            margin: 0;
            font-size: 28px;
            color: #0056b3;
        }
        .header-info p {
            margin: 4px 0;
            font-size: 14px;
            color: #555;
        }
        .title {
            text-align: center;
            text-transform: uppercase;
            font-size: 20px;
            margin-bottom: 30px;
            color: #0056b3;
            font-weight: bold;
        }
        .info-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 30px;
            background-color: #ffffff;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.1);
        }
        .info-table th, .info-table td {
            border: 1px solid #ddd;
            padding: 20px;
            font-size: 14px;
            text-align: left;
        }
        .info-table th {
            background-color: #0056b3;
            color: #ffffff;
            font-weight: bold;
        }
        .info-table tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        .info-table tr:hover {
            background-color: #e0e0e0;
        }
        .info-table td {
            border-left: 4px solid #0056b3; /* Bordure de gauche colorée */
        }
        .info-table th:first-child, .info-table td:first-child {
            border-left: none; /* Supprime la bordure de gauche pour la première colonne */
        }
        .footer {
            text-align: center;
            font-size: 12px;
            color: #666;
            border-top: 1px solid #ddd;
            padding-top: 15px;
            margin-top: 30px;
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
        Récépissé d'Inscription N° {{ str_pad($pelerin->id, 6, '0', STR_PAD_LEFT) }}
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
