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
        echo "La data di oggi è " . date("d-m-Y") . " e sono le ore " . date("H:i:s");
    @endphp
    <h3>Info Food</h3>
    @dump($croccantini)

    @php
        $utente->setPosition(4562.6, 46587112.0010);
    @endphp
    @dump($utente)

    @php
        function testExcep($test){
            if(is_numeric($test)){
                throw new Exception ("Il valore inserito è un numero");
            } else {
                echo "Valore corretto, hai inserito una stringa.";
            }
        }
    @endphp

    <p>
        @php
            // Testare eccezione su valore errato inserito
            try{
                echo testExcep(456);
            } catch (Exception $e){
                echo "Eccezione 00000000x25: " . $e->getMessage();
            }
        @endphp
    </p>

    <p>
        @php
            // Testare else su valore corretto inserito come argomento della funzione
            try{
                echo testExcep("prova");
            } catch (Exception $e){
                echo "Eccezione: " . $e->getMessage();
            }
        @endphp
    </p>
</body>
</html>