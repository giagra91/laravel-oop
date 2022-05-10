<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Main</title>
</head>
<body>

    <h3>Info Utente</h3>
    @dump($utente)
    @php
        echo $utente->getName() . "<br>";
        echo $utente->getEmail() . "<br>";
        date_default_timezone_set("Europe/Rome");
        echo date("i")       
    @endphp
    <h3>Info Food</h3>
    @dump($croccantini)
</body>
</html>