<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta http-equiv="Content-Type" content="text/html" charset="utf-8" />
        <title>Quittance</title>
        <link href="{{ public_path('css/quittance/modern-normalize.css') }}" rel="stylesheet">
        <link href="{{ public_path('css/quittance/web-base.css') }}" rel="stylesheet">
        <link href="{{ public_path('css/quittance/invoice.css') }}" rel="stylesheet">

        <link href="{{ public_path('css/quittance/custom.css') }}" rel="stylesheet">
    </head>
    <body>
        <div class="web-container">

            <div class="pdf-header">
              <div class="pdf-header-left">
                <div>Ministère de l'Economie  des Finances et Prospectives</div>
                <div style="margin-left: 100px">-------------</div>
                <div style="margin-left: 80px">Secrétariat Général</div>
                <div style="margin-left: 100px">-------------</div>
                <div>Direction Générale des Études et des Statistiques Sectorielles</div><br />
              </div>

              <div class="pdf-header-right">
                <div style="margin-left: 10">BURKINA FASO</div>
                <div style="margin-left: 30"></div>
                <div>Unité-Progrès-Justice</div>
                <img style="width: 90px; height:90px; margin-top: 60px; margin-left: 50px"
                  src="data:image/png;base64, {!! $qrCode !!}"/>
              </div>
            </div>

            <!-- <div class="logo-container">

              <img
                style="height: 18px"
                src="https://app.useanvil.com/img/email-logo-black.png"
              />
            </div> -->
            <div class="center">
              <strong><u>Quittance de paiement</u></strong> <br><br/>
            </div><br><br><br>
            <div>
            Quittance N° {{$offre->code_demande}} du {{ \Carbon\Carbon::parse($offre->created_at)->format('d/m/y') }} <br><br>
              délivrée à <strong>{{ $offre->agence->nomAgence }}</strong>
            </div>
            <table class="line-items-container">
              <thead>
                <tr>
                  <th class="heading-description">Désignation</th>
                  <th class="heading-description">Prix</th>
                  <th class="heading-description">Quantité</th>
                  <th class="heading-price">Montant</th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td class="bold">Billet</td>
                  <td class="bold">{{$prixBillet}} F CFA</td>
                  <td class="bold">{{$nbrePassager}} </td>
                  <td class="bold">{{$totalBillet}} F CFA</td>
                </tr>
                <tr>
                  <td class="bold">Assurance</td>
                  <td class="bold">{{$prixAssurance}} F CFA</td>
                  <td class="bold">{{$nbrePassager}} </td>
                  <td class="bold">{{$totalAssurance}} F CFA</td>
                </tr>
              </tbody>
            </table>

            <table class="line-items-container has-bottom-border">
              <thead>
                <tr>
                  <!-- <th>Payment Info</th>
                  <th>Due By</th>-->
                  <th>Prix Total</th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td class="large total"><b>{{$prixTotal}} F CFA</b></td>
                </tr>
              </tbody>
            </table><br>
            <span>Arreté la présente quittance à la somme de <b>{{$montantEnLettre}} F CFA</b></span>
            {{-- <div class="footer">
              <div class="footer-info">
                <span>Arreté la présente quiittance a la somme de {{$montant}} F CFA</span>
              </div>

              <div class="footer-thanks">

              </div>
            </div> --}}
          </div>
    </body>
</html>
