<?php

    include_once 'classes.php';
    // check that you are logged in otherwise reroute to login page

    /*if(!isset($_COOKIE['user'])) {
                echo '<meta HTTP-EQUIV=REFRESH CONTENT="1; \'login.php\'">';
    }*/ //enable when tables are complete

?>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Page Title</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" media="screen" href="main.css">
    <script src="main.js"></script>
</head>

<body>
<div class="centering">
    <div class="checkoutTable">
        <h1>Kassa</h1>
        <table class="checkoutDetails">
            <thead>
                <tr>
                    <th>&nbsp;
                    </th>
                    <th>&nbsp;
                    </th>
                    <th>Pris
                    </th>
                    <th>Mängd
                    </th>
                    <th>Totalt
                    </th>
                    <th>&nbsp;
                    </th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td class="detailPic">&nbsp;
                    </td>
                    <td class="detailDesciption">&nbsp;
                    </td>
                    <td class="detailPrice">&nbsp;
                    </td>
                    <td class="detailAmount"><button>-</button><input type="text" value="1" id="amount1" name="amount1"><button>+</button>
                    </td>
                    <td class="detailTotal">&nbsp;
                    </td>
                    <td class="detailDelete"><button>X</button>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
<div class="deliveryChoice">
    <ul>
        <form method="post" action="checkout.php">
        <li><input id="postnord" type="radio" value="Postnord">Postnord
        </li>
        <li><input id="ups" type="radio" value="UPS">UPS
        </li>
        <li><input id="schenker" type="radio" value="Schenker">Schenker
        </li>
        </form>
    </ul>
</div>
<div>
    <form method="post" action="confirmationOrder">
        <input type="text">
    </form>
</div>
</body>