<!DOCTYPE html>
<html>

<head>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
            font-family: Arial;
            font-size: 13px;
            margin-left: -80px;
            /* Déplace le tableau légèrement vers la gauche */
            margin-top: 30px;
            /* Ajoute un espace au-dessus du tableau */
        }

        thead {
            background-color: #f4f4f4;
        }

        th,
        td {
            border: 1px solid black;
            padding: 4px;
            text-align: center;
            vertical-align: middle;
        }

        .header-section {
            margin-left: -80px;
            margin-top: -85px;
        }

        .totaux {
            font-weight: bold;
        }

        body {
            font-family: Arial, sans-serif;
            margin: 40px;
            font-size: 12px;
        }



        .header-left {
            float: left;
            width: 50%;
        }

        .header-right {
            float: right;
            width: 50%;
            text-align: center;
            margin-right: -280px;
            margin-bottom: 10px
                /* Pousse davantage vers la droite */
        }

        .header-center {
            margin-top: 10px;
            margin-left: -20px;
            text-align: center;
            /* Centre le texte horizontalement */
            clear: both;
            /* Assure que la div est positionnée après les div left et right */
        }

        .header-section h4 {
            font-size: 14px;
            font-weight: bold;
            margin-bottom: 10px;
        }

        .header-section h2 {
            font-size: 16px;
            margin-top: 5px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
            
        }

        th,
        td {
            border: 1px solid black;
            padding: 4px;
            text-align: center;
            vertical-align: middle;


        }

        .totaux {
            font-weight: bold;
        }

        .clickable {
            cursor: pointer;
        }

        .yellow-cell {
            background-color: yellow;
        }

        .signature {
            margin-top: 10px;
        }

        .signature p {
            font-size: 14px;
        }

        /* Positionnement du texte en bas à droite */
        .footer-right {
            float: right;
            margin-top: 5px;
            text-align: right;
            font-size: 12px;
            top: 0;
        }

        /* Positionnement du texte en bas à gauche */
        .footer-left {
            float: left;
            margin-top: 10px;
            text-align: left;
            font-size: 12px;
            top: 0;
        }

        /* Positionnement de la dernière ligne de footer */
        .footer-last {
            clear: both;
            margin-top: 40px;
            text-align: center;
            font-size: 12px;
        }
    </style>
</head>

<body>
    <div class="header-section">
        <!-- En-tête à gauche -->
        <div class="header-left">
            <h4>ASECNA<br>BURKINA FASO<br>DEXR/BF/02 <br>AERODROME DE: BOBO Dioulasso</h4>
        </div>

        <!-- En-tête à droite -->
        <div class="header-right">
            <h4>STRUCTURE<br>MRG</h4>
        </div>

        <!-- En-tête centré -->
        <div class="header-center">
            <h2> TABLEAU DE SERVICE<br>DU 24 MARS AU 30 MARS 2025</h2>
        </div>
    </div>

    <table>
        <thead>
            <tr>
                <th rowspan="1">JOUR et Date</th>
                <th colspan="4">LUNDI<br> {{ $variables['jours']['Lundi'] }}</th>
                <th colspan="4">MARDI<br>{{ $variables['jours']['Mardi'] }}</th>
                <th colspan="4">MERCREDI<br>{{ $variables['jours']['Mercredi'] }}</th>
                <th colspan="4">JEUDI<br>{{ $variables['jours']['Jeudi'] }}</th>
                <th colspan="4">VENDREDI<br>{{ $variables['jours']['Vendredi'] }}</th>
                <th colspan="4">SAMEDI<br>{{ $variables['jours']['Samedi'] }}</th>
                <th colspan="4">DIMANCHE<br>{{ $variables['jours']['Dimanche'] }}</th>
                <th colspan="4", rowspan="2">Décomptes <br> des Heures</th>
            </tr>


            <tr>
                <th rowspan="1">Heure de Debut</th>
                @for ($i = 0; $i < 7; $i++)
                <th>00H</th>
                <th>06H</th>
                <th>13H</th>
                <th>20H</th>
                @endfor

            </tr>
            <tr>
                <th rowspan="1">Heure de Fin</th >
                @for ($i = 0; $i < 7; $i++)
                <th>06H</th>
                <th>13H</th>
                <th>20H</th>
                <th>24H</th>
                @endfor
                
                 

                <th>HTE</th>
                <th>HNN</th>
                <th>HJF</th>
                <th>HNF</th>
            </tr>

        </thead>

        <tbody>
            <!-- Exemple avec les données de BAYALA S. Noël -->
            @foreach($variables['surveillants'] as $surveillant)
            <tr class="border-b hover:bg-gray-50 transition">
            

                <td class="font-bold px-1 py-1 ">{{  $surveillant->name }}</td>
                @for ($i = 0; $i < 7; $i++)
                    <!-- 7 jours -->
                    <td id="nuit" class="clickable"></td>
                    <td id="matin" class="clickable"></td>
                    <td id="matin" class="clickable"></td>
                    <td id="nuit" class="clickable"></td>
                @endfor
                <td>56</td>
                <td>21</td>
                <td>0</td>
                <td>0</td>
            </tr>
            @endforeach

            



            <!-- Ajouter les autres employés avec le même pattern -->
        </tbody>
    </table>
    <div style="margin-top: 20px;" class="signature">
        <div class="footer-left">
            <p>HS = Heures travaillées - (173,33H+HNJF+HNNF)</p>
            <p>Permanence Tech</p>
            <p>{{  App\Models\User::findOrFail($variables['permanence_tech'])->name  }}</p>
            <p>70 17 92 94 / 65 17 82 82</p>
        </div>

        <!-- Footer à droite -->
        <div class="footer-right">
            <p>Bobo-Dioulasso, le 20/03/2025</p>
            <p>Le commandant d'aérodrome</p>
            <br><br><br> <br>
            <p>KONKISRE Jean-Marie</p>
        </div>
        <div class="footer-last" style="margin-top: 40px;">
            <p><span style="color: red;">* </span> Responsable SLA <strong>DÉLÉGUÉ DE PERMANENCE DE COMMANDEMENT: <span
                        style="color: red;">{{  App\Models\User::findOrFail($variables['commandant_permanence'])->name  }}: 70 11 67 19 / 78 01 74 52</span> </strong></p>
            <p style="text-align: center;"><strong> Diffusion: U ENM, USLI, U MRG, Archives, BOY, DGRP/BF</strong></p>
        </div>
    </div>
    </div>
</body>

</html>
