<?php
//require '../DB/DBUtenti.php';
class DBDatore
{
    //Variabili di classe
    private $connection;
    private $tabelleDB = [ //Array di tabelle del db
        "categoria",//0
        "curriculum",//1
        "datore",//2
        "lavoro",//3
        "richiedente"//4
    ];
    private $campiTabelleDB = [ //Campi delle tabelle (array bidimensionale indicizzato con key)
        "categoria" => [
            "id",
            "nome"

        ],
        "curriculum" => [
            "id",
            "richiedente",
            "link"
        ],
        "datore" => [
            "id",
            "nome",
            "cognome",
            "email",
            "password",
            "attivo",
            "contatto"
        ],
        "lavoro" => [
            "id",
            "categoria",
            "nome",
            "datore",
            "descrizione",
            "link"
        ],
        "richiedente" => [
            "id",
            "nome",
            "cognome",
            "email",
            "password",
            "attivo"

        ]
    ];


    //Costruttore
    public function __construct()
    {
        //Setup della connessione col DB
        $db = new DBConnectionManager();
        $this->connection = $db->runConnection();
    }

    //Funzione visualizza profilo studente ()
    public function VisualizzaProfiloRichiedente($id)
    {
        $tabella = $this->tabelleDB[4]; //Tabella per la query
        $campi = $this->campiTabelleDB[$tabella];
        //query: "SELECT nome, cognome, email FROM richiedente WHERE id = ?"
        $query = (
            "SELECT " .
            $campi[1] . ", " .
            $campi[2] . ", " .
            $campi[3] . " " .
            "FROM " .
            $tabella . " " .
            "WHERE " .
            $campi[0] . " = ? "
        );
        $stmt = $this->connection->prepare($query);
        $stmt->bind_param("s", $id);
        $stmt->execute();
        $stmt->store_result();
        if ($stmt->num_rows > 0) {
            $stmt->bind_result($nome, $cognome, $email);
            $profilo = array();
            while ($stmt->fetch()) { //Scansiono la risposta della query
                $temp = array();
                //Indicizzo con key i dati nell'array
                $temp[$campi[1]] = $nome;
                $temp[$campi[2]] = $cognome;
                $temp[$campi[3]] = $email;
                array_push($profilo, $temp); //Inserisco l'array $temp all'ultimo posto dell'array $profilo
            }
            return $profilo;
        } else {
            return null;
        }
    }

    //Funzione rimuovi annuncio (Domenico e Jonathan)
    public function rimuoviLavoro($idLavoro)
    {
        $tabella = $this->tabelleDB[3]; //Tabella per la query
        $campi = $this->campiTabelleDB[$tabella];
        //query:  " DELETE FROM ANNUNCIO WHERE ID = $idAnnuncio"
        $query = (
            "DELETE FROM " .
            $tabella . " WHERE " .
            $campi[0] . " = ? "
        );

        $stmt = $this->connection->prepare($query);
        $stmt->bind_param("i", $idLavoro);
        $result = $stmt->execute();
        $stmt->store_result();
        return $result;
    }

    //funzione visualizza documento per nome materia(Danilo)

    //Funzione contatta venditore (Domenico)
    public function contattaVenditore($idAnnuncio)
    {
        $annunciTab = $this->tabelleDB[0]; //Tabella per la query (annuncio)
        $studentiTab = $this->tabelleDB[6]; //Tabella per la query (studente): per ricavare l'email
        $campiAnnuncio = $this->campiTabelleDB[$annunciTab];
        $campiStudente = $this->campiTabelleDB[$studentiTab];
        /*  query: "SELECT annuncio.contatto, studente.email
                    FROM studente, annuncio
                    WHERE annuncio.id = ? AND annuncio.cod_stud = studente.matricola*/
        $query = (
            "SELECT " .
            $annunciTab . "." . $campiAnnuncio[2] . ", " . $studentiTab . "." . $campiStudente[3] . " " .
            "FROM " .
            $annunciTab . ", " . $studentiTab . " " .
            "WHERE " .
            $annunciTab . "." . $campiAnnuncio[0] . " = ? " .
            "AND " . $annunciTab . "." . $campiAnnuncio[6] . " = " . $studentiTab . "." . $campiStudente[0]
        );
        $stmt = $this->connection->prepare($query);
        $stmt->bind_param("i", $idAnnuncio);
        $stmt->execute();
        $stmt->store_result();
        if ($stmt->num_rows > 0) {
            $stmt->bind_result($contatto, $email);
            $venditore = array();
            while ($stmt->fetch()) { // Scansiono la risposta della query
                $temp = array();
                $temp[$campiAnnuncio[2]] = $contatto;
                $temp[$campiStudente[3]] = $email;
                array_push($venditore, $temp); //Inserisco l'array $temp all'ultimo posto dell'array $profilo
            }
            return $venditore; //ritorno array Documento riempito con i risultati della query effettuata.
        } else{
            return null;
        }
    }

    //Funzione valutazione documenti (Andrea)
    public function valutazioneDocumento($valutazione, $cod_documento, $cod_studente)
    {
        $tabella = $this->tabelleDB[7]; //Tabella per la query
        $campi = $this->campiTabelleDB[$tabella];
        //query: "INSERT INTO valutazione (valutazione, cod_documento) VALUES (?,?)"
        $query = (
            "INSERT INTO  " .
            $tabella . " ( " .
            $campi[1] . ", " .
            $campi[2] . ", " .
            $campi[3] . " ) " .
            "VALUES (?,?,?)"
        );
        $stmt = $this->connection->prepare($query);
        $stmt->bind_param("iis", $valutazione, $cod_documento, $cod_studente);
        return $stmt->execute();
    }


    //Funzione valutazione documenti (Andrea)
    public function mediaValutazione($cod_documento)
    {
        $tabella = $this->tabelleDB[7]; //Tabella per la query
        $campi = $this->campiTabelleDB[$tabella];
        //query: SELECT AVG(valutazione) AS temp FROM valutazione WHERE cod_documento = ?
        $query = (
            "SELECT AVG(" .
            $campi[1] . ") AS temp FROM " .
            $tabella . " WHERE " .
            $campi[2] . " = ?"
        );
        $stmt = $this->connection->prepare($query);
        $stmt->bind_param("i", $cod_documento);
        $stmt->execute();//Esegue la query
        $stmt->store_result();
        if ($stmt->num_rows > 0) {
            $stmt->bind_result($media);
            $risultato = array();
            while ($stmt->fetch()) { //Scansiono la risposta della query
                $temp = array(); //Array temporaneo per l'acquisizione dei dati
                //Indicizzo con key i dati nell'array
                $temp["media"] = $media;

                array_push($risultato, $temp); //Inserisco l'array $temp all'ultimo posto dell'array $utenti
            }
            return $risultato;
        } else {
            return null;
        }
    }

    //Funzione per ricercare tra documenti, libri e annunci (Andrea)

    //Funzione visualizza documenti studenti(danilo)
    public function visualizzaDocumentistudenti()
    {
        $documenti = array();

        $table = $this->tabelleDB[3]; //Tabella per la query
        $campi = $this->campiTabelleDB[$table];
        $table2 = $this->tabelleDB[6];
        $campi2 = $this->campiTabelleDB[$table2];
        $query = //"SELECT titolo,link FROM documenti INNER JOIN studenti ON cod_stud=matricola"
            "SELECT " .
            $campi[1] . ", " .
            $campi[5] . " " .
            "FROM " .
            $table . " " .

            "INNER JOIN " .
            $table2 . ' ON '.
            $campi[3] ." = ". $campi2[0] ;


        $stmt = $this->connection->prepare($query);
        $stmt->execute();
        $stmt->store_result();

        //Salvo il risultato della query in alcune variabili che andranno a comporre l'array temp
        $stmt->bind_result($titolo,$link);

        while ($stmt->fetch()) { //Scansiono la risposta della query
            $temp = array(); //Array temporaneo per l'acquisizione dei dati
            //Indicizzo con key i dati nell'array
            $temp[$campi[1]] = $titolo;
            $temp[$campi[5]] = $link;
            array_push($documenti, $temp); //Inserisco l'array $temp all'ultimo posto dell'array $annunci
        }
        return $documenti; //ritorno array libri riempito con i risultati della query effettuata.

    }

    //Funzione visualizza documento per id (Danilo)

    //Funzione per scaricare un documento (Andrea)
    public function downloadDocumento($id)
    {
        $tabella = $this->tabelleDB[3]; //Tabella per la query
        $campi = $this->campiTabelleDB[$tabella];
        /*  query: "SELECT link FROM documento WHERE id = ?" */
        $query = (
            "SELECT " .
            $campi[5] . " " .
            "FROM " .
            $tabella . " " .
            "WHERE " .
            $campi[0] . " = ?"
        );
        $stmt = $this->connection->prepare($query);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $stmt->store_result();
        if ($stmt->num_rows > 0) {
            $stmt->bind_result($link);
            $url = array();
            while ($stmt->fetch()) { //Scansiono la risposta della query
                $temp = array();
                //Indicizzo con key i dati nell'array
                $temp[$campi[0]] = $link;
                array_push($url, $temp); //Inserisco l'array $temp all'ultimo posto dell'array $profilo
            }
            return $url;
        } else {
            return null;
        }
    }


    public function caricaLavoro($categoria,$nome,$descrizione,$link,$datore)
    {
        $tabella = $this->tabelleDB[3];
        $campi = $this->campiTabelleDB[$tabella];
        //query: "INSERT INTO annuncio (id, titolo, contatto, prezzo, edizione, casa_editrice, cod_studente, autori, cod_materia, link) VALUES (?,?,?,?,?,?,?,?)"
        $query =/*"INSERT INTO libro ( titolo, autore, casa_editrice, edizione, cod_docente, cod_materia, link ) VALUES (?,?,'".$prezzo."',?,?,?,?,?)";*/
            ("INSERT INTO  " .
                $tabella . " ( " .
                $campi[1] . ", " .
                $campi[2] . ", " .
                $campi[3] . ", " .
                $campi[4] . ", " .
                $campi[5] . " ) " .
                "VALUES (?,?,?,?,?)"
            );
        $stmt = $this->connection->prepare($query);
        $stmt->bind_param("isiss", $categoria, $nome,$datore, $descrizione, $link);

        return $stmt->execute();
    }
    public function modificaLavoroPerId($id, $nome, $categoria, $descrizione, $link)
    {   $table=$this->tabelleDB[3];
        $campi = $this->campiTabelleDB[$table];
        //query:  "UPDATE TABLE SET nome = ?, cognome = ?, password = ? WHERE matricola = ?"
        $query = (
            "UPDATE " .
            $table. " " .
            "SET " .
            $campi[1] . " = ?, " .
            $campi[2] . " = ?, " .
            $campi[4] . " = ?, " .
            $campi[5] . " = ? " .
            "WHERE " .
            $campi[0] . " = ?"
        );
        //Invio la query
        $stmt = $this->connection->prepare($query);
        $stmt->bind_param("isssi", $categoria, $nome, $descrizione, $link,$id); //ss se sono 2 stringhe, ssi 2 string e un int (sostituisce ? della query)

        $result = $stmt->execute();

        //Controllo se ha trovato matching tra dati inseriti e campi del db
        return $result;
    }

}
