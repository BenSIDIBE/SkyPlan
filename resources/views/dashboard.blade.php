@extends('layouts.app')

@section('content')
    <style>
        * {
            box-sizing: border-box;
            padding: 0;
            margin: 0;
        }

        body {
            font-family: "Raleway", sans-serif;
        }

        :root {
            --bleue: #00bbfe;
            --gris: #ecf0f1;
            --withe: #fff;
            --grey: #f1f0f6;
            --dark-grey: #8D8D8D;
            --dark: #000;
            --green: #04af51;
            --light-bleue: #1775F1;
            --dark-bleu: #0C5FCD;
        }

        .principal section {
            margin-top: 40px;
            display: flex;
            justify-content: center;
            max-width: 1550px;
        }

        .principal .info-data {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            grid-gap: 20px;
        }

        .principal .info-data .card {
            padding: 20px;
            height: 100px;
            width: 280px;
            border-radius: 10px;
            background: var(--withe);
            box-shadow: 0 4px 6px -1px rgb(0 0 0 / 0.1), 0 2px 4px -2px rgb(0 0 0 / 0.1);
            cursor: pointer;
            border-left: 5px solid var(--light-bleue);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .principal .card .head {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
        }


        /***/

        .principal .info-data .card.i h2 {
            font-size: 30px;
            font-weight: 600;
            color: var(--bleue);
        }

        .principal .info-data .card.i h2 {
            font-size: 30px;
            font-weight: 600;
            color: var(--bleue);
        }


        .principal .info-data .card p {
            font-size: 18px;
        }


    </style>

    <div class="principal">
        <section>
            <div class="info-data">
                <div class="card i">
                    <div class="head">
                        <div>
                            <h2></h2>
                            <p>Salles</p>
                        </div>
                        <i class='fa fa-school icon'></i>
                    </div>
                </div>

                <div class="card u">
                    <div class="head">
                        <div>
                            <h2></h2>
                            <p>Niveau</p>
                        </div>
                        <i class="fa-solid fa-building-columns icon"></i>
                    </div>
                </div>

                <div class="card i">
                    <div class="head">
                        <div>
                            <h2></h2>
                            <p>Professeurs</p>
                        </div>
                        <i class="fa-solid fa-users-between-lines icon "></i>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
