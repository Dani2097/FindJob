<?php
$app->post('/visualizzamateriapercdl', function (Request $request, Response $response) {

    $db = new DBRichiedente();

    $requestData = $request->getParsedBody();//Dati richiesti dal servizio REST
    $cod_cdl = $requestData['cod_cdl'];

    //Controllo la risposta dal DB e compilo i campi della risposta
    $responseData = $db->visualizzaMateriaPerCdl($cod_cdl);
    $contatore = (count($responseData));
    if ($responseData != null) {
        $responseData['error'] = false; //Campo errore = false
        $responseData['message'] = 'Elemento visualizzato con successo'; //Messaggio di esiso positivo
        $responseData['contatore'] = $contatore;
        $response->getBody()->write(json_encode(array("nomi_materie" => $responseData)));
        //Definisco il Content-type come json, i dati sono strutturati e lo dichiaro al browser
        $newResponse = $response->withHeader('Content-type', 'application/json');
        return $newResponse; //Invio la risposta del servizio REST al client
    } else {
        $responseData['error'] = true; //Campo errore = false
        $responseData['message'] = 'Errore imprevisto';
        return $response->withJson($responseData);
    }
    //Invio la risposta del servizio REST al client
});

//endpoint /visualizzamateriapercdl (danilo)ok
$app->post('/visualizzamateriapermatricola', function (Request $request, Response $response) {

    $db = new DBRichiedente();

    $requestData = $request->getParsedBody();//Dati richiesti dal servizio REST
    $matricola = $requestData['matricola'];

    //Controllo la risposta dal DB e compilo i campi della risposta
    $responseData = $db->visualizzaMateriaPerMatricola($matricola);
    $contatore = (count($responseData));
    if ($responseData != null) {
        $responseData['error'] = false; //Campo errore = false
        $responseData['message'] = 'Elemento visualizzato con successo'; //Messaggio di esiso positivo
        $responseData['contatore'] = $contatore;
        $response->getBody()->write(json_encode(array("nomi_materie" => $responseData)));
        //Definisco il Content-type come json, i dati sono strutturati e lo dichiaro al browser
        $newResponse = $response->withHeader('Content-type', 'application/json');
        return $newResponse; //Invio la risposta del servizio REST al client
    } else {
        $responseData['error'] = true; //Campo errore = false
        $responseData['message'] = 'Errore imprevisto';
        return $response->withJson($responseData);
    }
    //Invio la risposta del servizio REST al client
});

//endpoint /visualizzamateriapercdl (danilo)ok
$app->post('/visualizzamateriedisponibili', function (Request $request, Response $response) {

    $db = new DBRichiedente();

    $requestData = $request->getParsedBody();//Dati richiesti dal servizio REST
    $cod_docente = $requestData['matricola'];

    //Controllo la risposta dal DB e compilo i campi della risposta
    $responseData = $db->visualizzaMaterieDisponibili($cod_docente);
    $contatore = (count($responseData));
    if ($responseData != null) {
        $responseData['error'] = false; //Campo errore = false
        $responseData['message'] = 'Elemento visualizzato con successo'; //Messaggio di esiso positivo
        $responseData['contatore'] = $contatore;
        $response->getBody()->write(json_encode(array("nomi_materie" => $responseData)));
        //Definisco il Content-type come json, i dati sono strutturati e lo dichiaro al browser
        $newResponse = $response->withHeader('Content-type', 'application/json');
        return $newResponse; //Invio la risposta del servizio REST al client
    } else {
        $responseData['error'] = true; //Campo errore = false
        $responseData['message'] = 'Errore imprevisto';
        return $response->withJson($responseData);
    }
    //Invio la risposta del servizio REST al client
});

$app->post('/assegnadocentemateria', function (Request $request, Response $response) {
    $db = new DBRichiedente();

    $requestData = $request->getParsedBody();//Dati richiesti dal servizio REST
    $docente = $requestData['cod_docente'];
    $materia = $requestData['cod_materia'];

    //Risposta del servizio REST
    $responseData = array(); //La risposta e' un array di informazioni da compilare

    //Controllo la risposta dal DB e compilo i campi della risposta
    if ($db->assegnaDocenteAmateria($docente, $materia)) {
        $responseData['error'] = false; //Campo errore = false
        $responseData['message'] = 'Materia assegnata'; //Messaggio di esiso positivo
    } else { //Se c'è stato un errore imprevisto
        $responseData['error'] = true; //Campo errore = true
        $responseData['message'] = "Impossibile assegnare la materia"; //Messaggio di esito negativo
    }
    return $response->withJson($responseData); //Invio la risposta del servizio REST al client
});

//endpoint /visualizzadocumentopermateria (Danilo)ok
$app->post('/visualizzadocumentopermateria', function (Request $request, Response $response) {

    $db = new DBDatore();

    $requestData = $request->getParsedBody();//Dati richiesti dal servizio REST
    $materia = $requestData['materia'];

//Controllo la risposta dal DB e compilo i campi della risposta
    $responseData = $db->visualizzaDocumentoPerMateria($materia);
    $contatore = (count($responseData));
    if ($responseData != null) {
        $responseData['contatore'] = $contatore;
        $responseData['error'] = false; //Campo errore = false
        $responseData['message'] = 'Elemento visualizzato con successo'; //Messaggio di esiso positivo
        $response->getBody()->write(json_encode(array("documenti" => $responseData)));
        //Definisco il Content-type come json, i dati sono strutturati e lo dichiaro al browser
        $newResponse = $response->withHeader('Content-type', 'application/json');
        return $newResponse; //Invio la risposta del servizio REST al client
    } else {
        $responseData['error'] = true; //Campo errore = false
        $responseData['message'] = 'Non ci sono documenti per la materia selezionata';
        return $response->withJson($responseData);
    }

});

$app->post('/visualizzadocumentoperid', function (Request $request, Response $response) {

    $db = new DBUtenti();

    $requestData = $request->getParsedBody();//Dati richiesti dal servizio REST
    $matricola = $requestData['matricola'];

//Controllo la risposta dal DB e compilo i campi della risposta
    $responseData = $db->visualizzaDocumentoPerId($matricola);
    $contatore = (count($responseData));

    if ($responseData != null) {
        $responseData['error'] = false; //Campo errore = false
        $responseData['message'] = 'Elemento visualizzato con successo';//Messaggio di esiso positivo

        $responseData['contatore'] = $contatore;
        $response->getBody()->write(json_encode(array("documenti" => $responseData)));
        //Definisco il Content-type come json, i dati sono strutturati e lo dichiaro al browser
        $newResponse = $response->withHeader('Content-type', 'application/json');
        return $newResponse; //Invio la risposta del servizio REST al client
    } else {
        $responseData['error'] = true; //Campo errore = false
        $responseData['message'] = 'Errore imprevisto';
        return $response->withJson($responseData);
    }

});

$app->post('/visualizzacdlperiddocente', function (Request $request, Response $response) {

    $db = new DBRichiedente();

    $requestData = $request->getParsedBody();
    $iddoc = $requestData['iddoc'];
//Controllo la risposta dal DB e compilo i campi della risposta
    $responseData = $db->visualizzaCdlPerCodDoc($iddoc);
    $contatore = (count($responseData));
    if ($responseData != null) {
        $responseData['error'] = false; //Campo errore = false
        $responseData['contatore'] = $contatore;
        $responseData['message'] = 'Elemento visualizzato con successo'; //Messaggio di esiso positivo
        $response->getBody()->write(json_encode(array("CDL" => $responseData)));
        //metto in un json e lo inserisco nella risposta del servizio REST
        //Definisco il Content-type come json, i dati sono strutturati e lo dichiaro al browser
        $newResponse = $response->withHeader('Content-type', 'application/json');
        return $newResponse; //Invio la risposta del servizio REST al client
    } else {
        $responseData['error'] = true; //Campo errore = false
        $responseData['message'] = 'Errore imprevisto';
        return $response->withJson($responseData);
    }

});


$app->post('/checkmateriaperiddocente', function (Request $request, Response $response) {

    $db = new DBRichiedente();

    $requestData = $request->getParsedBody();
    $id_materia = $requestData['id'];
    $matricola = $requestData['codice_docente'];
//Controllo la risposta dal DB e compilo i campi della risposta
    $responseData = $db->checkMateriaPerCodDoc($id_materia, $matricola);
    if ($responseData != null) {
        $responseData['error'] = false; //Campo errore = false
        $responseData['message'] = 'Elemento visualizzato con successo'; //Messaggio di esiso positivo
        $response->getBody()->write(json_encode(array("Check" => $responseData)));
        //metto in un json e lo inserisco nella risposta del servizio REST
        //Definisco il Content-type come json, i dati sono strutturati e lo dichiaro al browser
        $newResponse = $response->withHeader('Content-type', 'application/json');
        return $newResponse; //Invio la risposta del servizio REST al client
    } else {
        $responseData['error'] = true; //Campo errore = false
        $responseData['message'] = 'Errore imprevisto';
        return $response->withJson($responseData);
    }

});

$app->post('/checkcdlperiddocente', function (Request $request, Response $response) {

    $db = new DBRichiedente();

    $requestData = $request->getParsedBody();
    $cdl = $requestData['id'];
    $matricola = $requestData['matricola'];
//Controllo la risposta dal DB e compilo i campi della risposta
    $responseData = $db->checkCdlPerCodDoc($cdl, $matricola);
    if ($responseData != null) {
        $responseData['error'] = false; //Campo errore = false
        $responseData['message'] = 'Elemento visualizzato con successo'; //Messaggio di esiso positivo
        $response->getBody()->write(json_encode(array("Check" => $responseData)));
        //metto in un json e lo inserisco nella risposta del servizio REST
        //Definisco il Content-type come json, i dati sono strutturati e lo dichiaro al browser
        $newResponse = $response->withHeader('Content-type', 'application/json');
        return $newResponse; //Invio la risposta del servizio REST al client
    } else {
        $responseData['error'] = true; //Campo errore = false
        $responseData['message'] = 'Errore imprevisto';
        return $response->withJson($responseData);
    }

});


$app->post('/visualizzanomecdlperid', function (Request $request, Response $response) {

    $db = new DBRichiedente();

    $requestData = $request->getParsedBody();
    $id = $requestData['id'];
//Controllo la risposta dal DB e compilo i campi della risposta
    $responseData = $db->visualizzaNomeCdl($id);
    $contatore = (count($responseData));
    if ($responseData != null) {
        $responseData['error'] = false; //Campo errore = false
        $responseData['contatore'] = $contatore;
        $responseData['message'] = 'Elemento visualizzato con successo'; //Messaggio di esiso positivo
        $response->getBody()->write(json_encode(array("CDL" => $responseData)));
        //metto in un json e lo inserisco nella risposta del servizio REST
        //Definisco il Content-type come json, i dati sono strutturati e lo dichiaro al browser
        $newResponse = $response->withHeader('Content-type', 'application/json');
        return $newResponse; //Invio la risposta del servizio REST al client
    } else {
        $responseData['error'] = true; //Campo errore = false
        $responseData['message'] = 'Errore imprevisto';
        return $response->withJson($responseData);
    }

});

$app->post('/visualizzacdlperidstudente', function (Request $request, Response $response) {

    $db = new DBDatore();

    $requestData = $request->getParsedBody();
    $matricola = $requestData['matricola'];
//Controllo la risposta dal DB e compilo i campi della risposta
    $responseData = $db->visualizzaCdlStudente($matricola);

    $contatore = (count($responseData));
    if ($responseData != null) {
        $responseData['error'] = false; //Campo errore = false
        $responseData['contatore'] = $contatore;
        $responseData['message'] = 'Elemento visualizzato con successo'; //Messaggio di esiso positivo
        $response->getBody()->write(json_encode(array("CDL" => $responseData)));
        //metto in un json e lo inserisco nella risposta del servizio REST
        //Definisco il Content-type come json, i dati sono strutturati e lo dichiaro al browser
        $newResponse = $response->withHeader('Content-type', 'application/json');
        return $newResponse; //Invio la risposta del servizio REST al client
    } else {
        $responseData['error'] = true; //Campo errore = false
        $responseData['message'] = 'Errore imprevisto';
        return $response->withJson($responseData);
    }

});

//endpoint /VisualizzaCDL (Danilo)
$app->post('/visualizzacdlperid', function (Request $request, Response $response) {

    $db = new DBUtenti();

    $requestData = $request->getParsedBody();
    $idcdl = $requestData['idcdl'];
//Controllo la risposta dal DB e compilo i campi della risposta
    $responseData = $db->visualizzaCdlPerid($idcdl);
    $contatore = (count($responseData));
    if ($responseData != null) {
        $responseData['error'] = false; //Campo errore = false
        $responseData['contatore'] = $contatore;
        $responseData['message'] = 'Elemento visualizzato con successo'; //Messaggio di esiso positivo
        $response->getBody()->write(json_encode(array("CDL" => $responseData)));
        //metto in un json e lo inserisco nella risposta del servizio REST
        //Definisco il Content-type come json, i dati sono strutturati e lo dichiaro al browser
        $newResponse = $response->withHeader('Content-type', 'application/json');
        return $newResponse; //Invio la risposta del servizio REST al client
    } else {
        $responseData['error'] = true; //Campo errore = false
        $responseData['message'] = 'Errore imprevisto';
        return $response->withJson($responseData);
    }

});

$app->post('/visualizzacdl', function (Request $request, Response $response) {

    $db = new DBUtenti();

    $requestData = $request->getParsedBody();
//Controllo la risposta dal DB e compilo i campi della risposta
    $responseData = $db->visualizzaCdl();
    $contatore = (count($responseData));
    if ($responseData != null) {
        $responseData['error'] = false; //Campo errore = false
        $responseData['contatore'] = $contatore;
        $responseData['message'] = 'Elemento visualizzato con successo'; //Messaggio di esiso positivo
        $response->getBody()->write(json_encode(array("CDL" => $responseData)));
        //metto in un json e lo inserisco nella risposta del servizio REST
        //Definisco il Content-type come json, i dati sono strutturati e lo dichiaro al browser
        $newResponse = $response->withHeader('Content-type', 'application/json');
        return $newResponse; //Invio la risposta del servizio REST al client
    } else {
        $responseData['error'] = true; //Campo errore = false
        $responseData['message'] = 'Errore imprevisto';
        return $response->withJson($responseData);
    }

});


//endpoint /visualizzaannunciopermateria (danilo)ok
$app->post('/visualizzaannunciopermateria', function (Request $request, Response $response) {

    $db = new DBDatore();

    $requestData = $request->getParsedBody();//Dati richiesti dal servizio REST
    $materia = $requestData['materia'];

//Controllo la risposta dal DB e compilo i campi della risposta
    $responseData = $db->visualizzaAnnuncioPerMateria($materia);
    $contatore = (count($responseData));
    if ($responseData != null) {
        $responseData['error'] = false; //Campo errore = false
        $responseData['message'] = 'Elemento visualizzato con successo'; //Messaggio di esiso positivo
        $responseData['contatore'] = $contatore;
        $response->getBody()->write(json_encode(array("libri" => $responseData)));
        //Definisco il Content-type come json, i dati sono strutturati e lo dichiaro al browser
        $newResponse = $response->withHeader('Content-type', 'application/json');
        return $newResponse; //Invio la risposta del servizio REST al client
    } else {
        $responseData['error'] = true; //Campo errore = false
        $responseData['message'] = 'Errore imprevisto';
        return $response->withJson($responseData);
    }

});

$app->post('/visualizzaannuncioperid', function (Request $request, Response $response) {

    $db = new DBDatore();

    $requestData = $request->getParsedBody();//Dati richiesti dal servizio REST
    $matricola = $requestData['matricola'];

//Controllo la risposta dal DB e compilo i campi della risposta
    $responseData = $db->visualizzaAnnuncioPerId($matricola);
    $contatore = (count($responseData));
    if ($responseData != null) {
        $responseData['error'] = false; //Campo errore = false
        $responseData['message'] = 'Elemento visualizzato con successo'; //Messaggio di esiso positivo
        $responseData['contatore'] = $contatore;
        $response->getBody()->write(json_encode(array("annunci" => $responseData)));
        //Definisco il Content-type come json, i dati sono strutturati e lo dichiaro al browser
        $newResponse = $response->withHeader('Content-type', 'application/json');
        return $newResponse; //Invio la risposta del servizio REST al client
    } else {
        $responseData['error'] = true; //Campo errore = false
        $responseData['message'] = 'Errore imprevisto';
        return $response->withJson($responseData);
    }

});

$app->post('/visualizzalibropermateria', function (Request $request, Response $response) {

    $db = new DBDatore();

    $requestData = $request->getParsedBody();//Dati richiesti dal servizio REST
    $materia = $requestData['materia'];

//Controllo la risposta dal DB e compilo i campi della risposta
    $responseData = $db->visualizzaLibroPerMateria($materia);
    $contatore = (count($responseData));
    if ($responseData != null) {
        $responseData['error'] = false; //Campo errore = false
        $responseData['message'] = 'Elemento visualizzato con successo'; //Messaggio di esiso positivo
        $responseData['contatore'] = $contatore;
        $response->getBody()->write(json_encode(array("libri" => $responseData)));
        //Definisco il Content-type come json, i dati sono strutturati e lo dichiaro al browser
        $newResponse = $response->withHeader('Content-type', 'application/json');
        return $newResponse; //Invio la risposta del servizio REST al client
    } else {
        $responseData['error'] = true; //Campo errore = false
        $responseData['message'] = 'Errore imprevisto';
        return $response->withJson($responseData);
    }

});

$app->post('/visualizzalibropercognomedocente', function (Request $request, Response $response) {

    $db = new DBDatore();

    $requestData = $request->getParsedBody();//Dati richiesti dal servizio REST
    $cognome = $requestData['cognome'];

//Controllo la risposta dal DB e compilo i campi della risposta
    $responseData = $db->visualizzaLibroPerCognomeDocente($cognome);
    $contatore = (count($responseData));
    if ($responseData != null) {
        $responseData['error'] = false; //Campo errore = false
        $responseData['message'] = 'Elemento visualizzato con successo'; //Messaggio di esiso positivo
        $responseData['contatore'] = $contatore;
        $response->getBody()->write(json_encode(array("libri" => $responseData)));
        //Definisco il Content-type come json, i dati sono strutturati e lo dichiaro al browser
        $newResponse = $response->withHeader('Content-type', 'application/json');
        return $newResponse; //Invio la risposta del servizio REST al client
    } else {
        $responseData['error'] = true; //Campo errore = false
        $responseData['message'] = 'Errore imprevisto';
        return $response->withJson($responseData);
    }

});
$app->post('/ricerca', function (Request $request, Response $response) {
    $db = new DBDatore();

    $requestData = $request->getParsedBody();//Dati richiesti dal servizio REST
    $key = $requestData['key'];

    $responseData = $db->ricerca($key);//Risposta del DB
    $contatore = (count($responseData));
    //metto in un json e lo inserisco nella risposta del servizio REST
    $responseData['contatore'] = $contatore;
    $response->getBody()->write(json_encode(array("lista" => $responseData)));
    //Definisco il Content-type come json, i dati sono strutturati e lo dichiaro al browser
    $newResponse = $response->withHeader('Content-type', 'application/json');
    return $newResponse; //Invio la risposta del servizio REST al client
});
$app->post('/visualizzaidmateriapernome', function (Request $request, Response $response) {

    $db = new DBUtenti();

    $requestData = $request->getParsedBody();//Dati richiesti dal servizio REST
    $nome = $requestData['materia'];

    //Controllo la risposta dal DB e compilo i campi della risposta
    $responseData = $db->visualizzaIDMateriaPerNome($nome);
    $contatore = (count($responseData));
    if ($responseData != null) {
        $responseData['error'] = false; //Campo errore = false
        $responseData['message'] = 'Elemento visualizzato con successo'; //Messaggio di esiso positivo
        $responseData['contatore'] = $contatore;
        $response->getBody()->write(json_encode(array("id" => $responseData)));
        //Definisco il Content-type come json, i dati sono strutturati e lo dichiaro al browser
        $newResponse = $response->withHeader('Content-type', 'application/json');
        return $newResponse; //Invio la risposta del servizio REST al client
    } else {
        $responseData['error'] = true; //Campo errore = false
        $responseData['message'] = 'Errore imprevisto';
        return $response->withJson($responseData);
    }
    //Invio la risposta del servizio REST al client
});
$app->post('/visualizzanomemateriaperid', function (Request $request, Response $response) {

    $db = new DBUtenti();

    $requestData = $request->getParsedBody();//Dati richiesti dal servizio REST
    $id = $requestData['id'];

    //Controllo la risposta dal DB e compilo i campi della risposta
    $responseData = $db->visualizzaNomeMateriaPerID($id);
    $contatore = (count($responseData));
    if ($responseData != null) {
        $responseData['error'] = false; //Campo errore = false
        $responseData['message'] = 'Elemento visualizzato con successo'; //Messaggio di esiso positivo
        $responseData['contatore'] = $contatore;
        $response->getBody()->write(json_encode(array("nomi" => $responseData)));
        //Definisco il Content-type come json, i dati sono strutturati e lo dichiaro al browser
        $newResponse = $response->withHeader('Content-type', 'application/json');
        return $newResponse; //Invio la risposta del servizio REST al client
    } else {
        $responseData['error'] = true; //Campo errore = false
        $responseData['message'] = 'Errore imprevisto';
        return $response->withJson($responseData);
    }
    //Invio la risposta del servizio REST al client
});
$app->post('/visualizzanomelibropermatricola', function (Request $request, Response $response) {

    $db = new DBRichiedente();

    $requestData = $request->getParsedBody();//Dati richiesti dal servizio REST
    $matricola = $requestData['matricola'];

    //Controllo la risposta dal DB e compilo i campi della risposta
    $responseData = $db->visualizzaLibroPerCodiceDocente($matricola);
    $contatore = (count($responseData));
    if ($responseData != null) {
        $responseData['error'] = false; //Campo errore = false
        $responseData['message'] = 'Elemento visualizzato con successo'; //Messaggio di esiso positivo
        $responseData['contatore'] = $contatore;
        $response->getBody()->write(json_encode(array("libri" => $responseData)));
        //Definisco il Content-type come json, i dati sono strutturati e lo dichiaro al browser
        $newResponse = $response->withHeader('Content-type', 'application/json');
        return $newResponse; //Invio la risposta del servizio REST al client
    } else {
        $responseData['error'] = true; //Campo errore = false
        $responseData['message'] = 'Errore imprevisto';
        return $response->withJson($responseData);
    }
    //Invio la risposta del servizio REST al client
});
/*---------------------------------------------------------*/
//endpoint /visualizzaprofilodocente (Michela) ok
$app->post('/visualizzaprofilodocente', function (Request $request, Response $response) {

    $db = new DBRichiedente();

    $requestData = $request->getParsedBody();//Dati richiesti dal servizio REST
    $matricola = $requestData['matricola'];

//Controllo la risposta dal DB e compilo i campi della risposta
    $responseData = $db->visualizzaProfiloDocente($matricola);
    if ($responseData != null) {
        $responseData['error'] = false; //Campo errore = false
        $responseData['message'] = 'Elemento visualizzato con successo';//Messaggio di esiso positivo

        $response->getBody()->write(json_encode(array("profilo" => $responseData)));
        //Definisco il Content-type come json, i dati sono strutturati e lo dichiaro al browser
        $newResponse = $response->withHeader('Content-type', 'application/json');
        return $newResponse; //Invio la risposta del servizio REST al client
    } else {
        $responseData['error'] = true; //Campo errore = true
        $responseData['message'] = 'Errore imprevisto'; //Messaggio di esiso negativo
    }
    return $response->withJson($responseData); //Invio la risposta del servizio REST al client
});
public function caricaMateria($id,$matricola)
{
    $tabella = $this->tabelleDB[8];
    $campi = $this->campiTabelleDB[$tabella];
    //query: "INSERT INTO annuncio (id, titolo, contatto, prezzo, edizione, casa_editrice, cod_studente, autori, cod_materia, link) VALUES (?,?,?,?,?,?,?,?)"
    $query =/*"INSERT INTO annuncio ( titolo, contatto, prezzo, edizione, casa_editrice, cod_stud, autore, cod_materia) VALUES (?,?,'".$prezzo."',?,?,?,?,?)";*/
        ("INSERT INTO  " .
            $tabella . " ( " .
            $campi[0] . ", " .
            $campi[1] . " " .
            " ) " .
            "VALUES (?,?)"
        );
    $stmt = $this->connection->prepare($query);
    $stmt->bind_param("is", $id,$matricola);

    return $stmt->execute();
};
public function visualizzaLibroPerCodiceDocente($matricola)
{
    $tabella = $this->tabelleDB[4]; //Tabella per la query
    $campi = $this->campiTabelleDB[$tabella];
    //query: "SELECT id,titolo,autore,casaeditrice,edizione,link FROM libri WHERE cod_docente = $matricola "
    $query = (
        "SELECT " .
        $campi[0] . ", " .
        $campi[1] . ", " .
        $campi[2] . ", " .
        $campi[3] . ", " .
        $campi[4] . ", " .
        $campi[6] . ", " .
        $campi[7] . " " .

        "FROM " .
        $tabella . " " .
        "WHERE " .
        $campi[5] . " = ? "
    );
    $stmt = $this->connection->prepare($query);
    $stmt->bind_param("s", $matricola);
    $stmt->execute();
    $stmt->store_result();
    if ($stmt->num_rows > 0) {
        $stmt->bind_result($id, $titolo, $autore, $casaeditrice, $edizione, $cod_materia, $link);
        $libri = array();
        while ($stmt->fetch()) { //Scansiono la risposta della query
            $temp = array();
            //Indicizzo con key i dati nell'array
            $temp[$campi[0]] = $id;
            $temp[$campi[1]] = $titolo;
            $temp[$campi[2]] = $autore;
            $temp[$campi[3]] = $casaeditrice;
            $temp[$campi[4]] = $edizione;
            $temp[$campi[6]] = $cod_materia;
            $temp[$campi[7]] = $link;
            array_push($libri, $temp); //Inserisco l'array $temp all'ultimo posto dell'array $annunci
        }
        return $libri; //ritorno array libri riempito con i risultati della query effettuata.
    } else {
        return null;
    }
}

//Funzione visualizza materia per cdl (Danilo)
public function visualizzaMateriaPerCdl($cdlid)
{
    $tabella = $this->tabelleDB[5]; //Tabella per la query
    $campi = $this->campiTabelleDB[$tabella];
    $query = //query: "SELECT nome, FROM materia WHERE cod_cdl = ? "
        "SELECT " .
        $campi[0] . ", " .
        $campi[1] . " " .
        "FROM " .
        $tabella . " " .
        "WHERE " .
        $campi[3] . ' = ? ';
    $stmt = $this->connection->prepare($query);
    $stmt->bind_param("i", $cdlid);
    $stmt->execute();
    $stmt->store_result();
    if ($stmt->num_rows > 0) {
        $stmt->bind_result($id_materia, $nome_materia);
        $materie = array();
        while ($stmt->fetch()) { //Scansiono la risposta della query
            $temp = array();
            //Indicizzo con key i dati nell'array
            $temp[$campi[0]] = $id_materia;
            $temp[$campi[1]] = $nome_materia;
            array_push($materie, $temp); //Inserisco l'array $temp all'ultimo posto dell'array $materie
        }
        return $materie; //ritorno array $materie riempito con i risultati della query effettuata.
    } else {
        return null;
    }
}

//Funzione visualizza materia per cdl (Danilo)
public function visualizzaMateriaPerMatricola($matricola)
{
    $tabella = $this->tabelleDB[5]; //Tabella per la query
    $campi = $this->campiTabelleDB[$tabella];
    $query = //query: "SELECT id, nome FROM materia WHERE cod_docente = ? "
        "SELECT " .
        $campi[0] . ", " .
        $campi[1] . " " .
        "FROM " .
        $tabella . " " .
        "WHERE " .
        $campi[2] . ' = ? ';
    $stmt = $this->connection->prepare($query);
    $stmt->bind_param("s", $matricola);
    $stmt->execute();
    $stmt->store_result();
    if ($stmt->num_rows > 0) {
        $stmt->bind_result($id_materia, $nome_materia);
        $materie = array();
        while ($stmt->fetch()) { //Scansiono la risposta della query
            $temp = array();
            //Indicizzo con key i dati nell'array
            $temp[$campi[0]] = $id_materia;
            $temp[$campi[1]] = $nome_materia;
            array_push($materie, $temp); //Inserisco l'array $temp all'ultimo posto dell'array $materie
        }
        return $materie; //ritorno array $materie riempito con i risultati della query effettuata.
    } else {
        return null;
    }
}

//Funzione visualizza materia per cdl (Danilo)
public function visualizzaMaterieDisponibili($cod_docente)
{
    $tabella = $this->tabelleDB[5]; //Tabella per la query
    $campi = $this->campiTabelleDB[$tabella];
    $query = //query: "SELECT id, nome, cod_docente, cod_cdl FROM materia WHERE cod_docente = ? OR cod_docente IS NULL "
        "SELECT " .
        $campi[0] . ", " .
        $campi[1] . ", " .
        $campi[2] . ", " .
        $campi[3] . " " .
        "FROM " .
        $tabella . " " .
        "WHERE " .
        $campi[2] . ' = ? OR ' .
        $campi[2] . ' IS NULL ' .
        'ORDER BY ' . $campi[3] ;
    $stmt = $this->connection->prepare($query);
    $stmt->bind_param("s", $cod_docente);
    $stmt->execute();
    $stmt->store_result();
    if ($stmt->num_rows > 0) {
        $stmt->bind_result($id_materia, $nome_materia, $cod_doc, $cdl);
        $materie = array();
        while ($stmt->fetch()) { //Scansiono la risposta della query
            $temp = array();
            //Indicizzo con key i dati nell'array
            $temp[$campi[0]] = $id_materia;
            $temp[$campi[1]] = $nome_materia;
            $temp[$campi[2]] = $cod_doc;
            $temp[$campi[3]] = $cdl;
            array_push($materie, $temp); //Inserisco l'array $temp all'ultimo posto dell'array $materie
        }
        return $materie; //ritorno array $materie riempito con i risultati della query effettuata.
    } else {
        return null;
    }
}


// Funzione conferma Profilo (Andrea)
public function assegnaDocenteAmateria($cod_docente, $cod_materia)
{
    $tabella = $this->tabelleDB[5]; //Tabella per la query
    $campi = $this->campiTabelleDB[$tabella];
    //query:  "UPDATE docente/studente SET attivo = true WHERE matricola = ?"
    $query = (
        "UPDATE " .
        $tabella . " " .
        "SET " .
        $campi[2] . " = ? " .
        "WHERE " .
        $campi[0] . " = ?"
    );
    //Invio la query
    $stmt = $this->connection->prepare($query);
    $stmt->bind_param("si", $cod_docente, $cod_materia); //ss se sono 2 stringhe, ssi 2 string e un int (sostituisce ? della query)
    return $stmt->execute();
}

public function visualizzaCdlPerCodDoc($matricola)
{
    $tabella = $this->tabelleDB[8]; //Tabella per la query
    $campi = $this->campiTabelleDB[$tabella];
    $query = //query: "SELECT nome, FROM materia WHERE cod_cdl = ? "
        "SELECT " .
        $campi[0] . " " .
        "FROM " .
        $tabella . " " .
        "WHERE " .
        $campi[1] . ' = ? ';
    $stmt = $this->connection->prepare($query);
    $stmt->bind_param("s", $matricola);
    $stmt->execute();
    $stmt->store_result();
    if ($stmt->num_rows > 0) {
        $stmt->bind_result($id_cdl);
        $CDL = array();
        while ($stmt->fetch()) { //Scansiono la risposta della query
            $temp = array();
            //Indicizzo con key i dati nell'array
            $temp[$campi[0]] = $id_cdl;
            $temp["nome_cdl"] = $this->visualizzaNomeCdl($id_cdl)["0"]["nome"];
            $temp['matricola'] = $matricola;
            array_push($CDL, $temp); //Inserisco l'array $temp all'ultimo posto dell'array $materie
        }
        return $CDL; //ritorno array $materie riempito con i risultati della query effettuata.
    } else {
        return null;
    }
}

public function checkMateriaPerCodDoc($cod_materia, $matricola)
{
    $tabella = $this->tabelleDB[5]; //Tabella per la query
    $campi = $this->campiTabelleDB[$tabella];
    $query = //query: "SELECT true AS check FROM materia WHERE id = ? AND cod_docente = ?"
        "SELECT 'true' AS `check` " .
        "FROM " .
        $tabella . " " .
        "WHERE " .
        $campi[0] . ' = '.$cod_materia. ' AND ' .
        $campi[2] . ' = '.$matricola;
    $stmt = $this->connection->prepare($query);
    //$stmt->bind_param("is", $cod_materia, $matricola);
    $stmt->execute();
    $stmt->store_result();
    $check = array();
    if ($stmt->num_rows > 0) {
        $stmt->bind_result($checked);
        while ($stmt->fetch()) { //Scansiono la risposta della query
            $temp = array();
            //Indicizzo con key i dati nell'array
            $temp['check'] = $checked;
            array_push($check, $temp); //Inserisco l'array $temp all'ultimo posto dell'array $materie
        }
    } else {
        $temp = array();
        //Indicizzo con key i dati nell'array
        $temp['check'] = false;
        array_push($check, $temp); //Inserisco l'array $temp all'ultimo posto dell'array $materie
    }
    return $check; //ritorno array $materie riempito con i risultati della query effettuata.
}

public function checkCdlPerCodDoc($cdl, $matricola)
{
    $tabella = $this->tabelleDB[8]; //Tabella per la query
    $campi = $this->campiTabelleDB[$tabella];
    $query = //query: "SELECT true AS check FROM materia WHERE id = ? AND cod_docente = ?"
        "SELECT 'true' AS `check` " .
        "FROM " .
        $tabella . " " .
        "WHERE " .
        $campi[0] . ' = '.$cdl. ' AND ' .
        $campi[1] . ' = '.$matricola;
    $stmt = $this->connection->prepare($query);
    //$stmt->bind_param("is", $cod_materia, $matricola);
    $stmt->execute();
    $stmt->store_result();
    $check = array();
    if ($stmt->num_rows > 0) {
        $stmt->bind_result($checked);
        while ($stmt->fetch()) { //Scansiono la risposta della query
            $temp = array();
            //Indicizzo con key i dati nell'array
            $temp['check'] = $checked;
            array_push($check, $temp); //Inserisco l'array $temp all'ultimo posto dell'array $materie
        }
    } else {
        $temp = array();
        //Indicizzo con key i dati nell'array
        $temp['check'] = false;
        array_push($check, $temp); //Inserisco l'array $temp all'ultimo posto dell'array $materie
    }
    return $check; //ritorno array $materie riempito con i risultati della query effettuata.
}


public function visualizzaNomeCdl($idCdl)
{
    $tabella = $this->tabelleDB[1]; //Tabella per la query
    $campi = $this->campiTabelleDB[$tabella];
    $query = //query: "SELECT nome, FROM materia WHERE cod_cdl = ? "
        "SELECT " .
        $campi[1] . " " .
        "FROM " .
        $tabella . " " .
        "WHERE " .
        $campi[0] . ' = ?';
    $stmt = $this->connection->prepare($query);
    $stmt->bind_param("i", $idCdl);
    $stmt->execute();
    $stmt->store_result();
    if ($stmt->num_rows > 0) {
        $stmt->bind_result($nome_cdl);
        $nome = array();
        while ($stmt->fetch()) { //Scansiono la risposta della query
            $temp = array();
            //Indicizzo con key i dati nell'array
            $temp[$campi[1]] = $nome_cdl;
            array_push($nome, $temp); //Inserisco l'array $temp all'ultimo posto dell'array $materie
        }
        return $nome; //ritorno array $materie riempito con i risultati della query effettuata.
    } else {
        return null;
    }
}

public function visualizzLibriPerCoddoc($matricola)
{
    $tabella = $this->tabelleDB[4]; //Tabella per la query
    $campi = $this->campiTabelleDB[$tabella];
    $query = //query: "SELECT nome, FROM materia WHERE cod_cdl = ? "
        "SELECT " .
        $campi[1] . " " .
        "FROM " .
        $tabella . " " .
        "WHERE " .
        $campi[5] . ' = ? ';
    $stmt = $this->connection->prepare($query);
    $stmt->bind_param("s", $matricola);
    $stmt->execute();
    $stmt->store_result();
    if ($stmt->num_rows > 0) {
        $stmt->bind_result($nome_libro);
        $libro = array();
        while ($stmt->fetch()) { //Scansiono la risposta della query
            $temp = array();
            //Indicizzo con key i dati nell'array
            $temp[$campi[1]] = $nome_libro;
            array_push($libro, $temp); //Inserisco l'array $temp all'ultimo posto dell'array $materie
        }
        return $libro; //ritorno array $materie riempito con i risultati della query effettuata.
    } else {
        return null;
    }
}


