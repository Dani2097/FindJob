<?php
/**
 * Created by PhpStorm.
 * User: Andrea
 * Date: 11/05/18
 * Time: 20:01
 */

require '../Helper/StringHelper/StringHelper.php';

class DBUtenti
{
    //Variabili di class
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

    //---- METODI PER GESTIRE LE QUERY ----

    //Funzione di accesso (Andrea)
    public function login($email, $password,$tab)
    {
       $password = hash('sha256', $password);

        $datoritab= $this->tabelleDB[2];
    $richiedentitab= $this->tabelleDB[4];
        $campi = $this->campiTabelleDB[$richiedentitab];
        $attivo = 1;
        /*  query: "SELECT matricola, nome, cognome, email, 'studente' as tabella FROM studente WHERE email = ? AND password = ? AND attivo = 1
                    UNION
                    SELECT matricola, nome, cognome, email, 'docente' as tabella FROM docente WHERE email = ? AND password = ? AND attivo = 1" */
        $query = (
            "SELECT " .
            $campi[0] . ", " .
            $campi[1] . ", " .
            $campi[2] . ", " .
            $campi[3] . ", " .
            "'" . $richiedentitab . "' as tabella " .
            "FROM " .
            $richiedentitab . " " .
            "WHERE " .
            $campi[3] . " = ? AND " .
            $campi[4] . " = ? AND " .
            $campi[5] . " = ? " .
            "UNION " .
            "SELECT " .
            $campi[0] . ", " .
            $campi[1] . ", " .
            $campi[2] . ", " .
            $campi[3] . ", " .
            "'" . $datoritab . "' as tabella " .
            "FROM " .
            $datoritab . " " .
            "WHERE " .
            $campi[3] . " = ? AND " .
            $campi[4] . " = ? AND " .
            $campi[5] . " = ?"

        );

        //Invio la query
        $stmt = $this->connection->prepare($query);
        $stmt->bind_param("ssissi", $email, $password, $attivo, $email, $password, $attivo); //ss se sono 2 stringhe, ssi 2 string e un int (sostituisce ? della query)
        $stmt->execute();
        //Ricevo la risposta del DB
        $stmt->store_result();
        echo($query." ". $password);
        if ($stmt->num_rows > 0) {
            $stmt->bind_result($id, $nome, $cognome, $email, $table);
            $utente = array();

            while ($stmt->fetch()) {
                $temp = array();
                $temp[$campi[0]] = $id;
                $temp[$campi[1]] = $nome;
                $temp[$campi[2]] = $cognome;
                $temp[$campi[3]] = $email;
                $temp["tabella"] = $table;
                array_push($utente, $temp);
            }

            return $utente;
        } else {
            return null;
        }

    }


    //danilo per visualizzare il corso di studio
    public function visualizzaCategoriaperID($id)
    {

        $table = $this->tabelleDB[0]; //Tabella per la query
        $campi = $this->campiTabelleDB[$table];
        $query = //query: "SELECT id, nome FROM cdl"
            "SELECT " .
            $campi[1]." ".

            "FROM " .
            $table." ".
            "WHERE ". $campi[0]." = ?";
        $stmt = $this->connection->prepare($query);
        $stmt->bind_param(i , $id);
        $stmt->execute();
        $stmt->store_result();
        if ($stmt->num_rows > 0) {
            $stmt->bind_result($nome,$cognome,$email);

            $CDL = array();
            while ($stmt->fetch()) { //Scansiono la risposta della query
                $temp = array(); //Array temporaneo per l'acquisizione dei dati
                //Indicizzo con key i dati nell'array
                $temp[$campi[1]] = $nome;
                array_push($Categoria, $temp); //Inserisco l'array $temp all'ultimo posto dell'array $cdl
            }
            return $Categoria;
        }else return null;
    }
    //danilo per visualizzare il corso di studio
    public function visualizzaProfiloPerId($id,$tablenumber)
    {

        $table = $this->tabelleDB[$tablenumber]; //Tabella per la query
        $campi = $this->campiTabelleDB[$table];
        $query = //query: "SELECT id, nome FROM cdl"
            "SELECT " .
            $campi[1].",".
            $campi[2].",".
            $campi[3]." ".
            "FROM " .
            $table." ".
            "WHERE ". $campi[0]." = ?";
        $stmt = $this->connection->prepare($query);
        $stmt->bind_param(i , $id);
        $stmt->execute();
        $stmt->store_result();
        if ($stmt->num_rows > 0) {
            $stmt->bind_result($nome,$cognome,$email);

            $CDL = array();
            while ($stmt->fetch()) { //Scansiono la risposta della query
                $temp = array(); //Array temporaneo per l'acquisizione dei dati
                //Indicizzo con key i dati nell'array
                $temp[$campi[1]] = $nome;
                $temp[$campi[2]] = $cognome;
                $temp[$campi[3]] = $email;
                array_push($utente, $temp); //Inserisco l'array $temp all'ultimo posto dell'array $cdl
            }
            return $utente;
        }else return null;
    }


    //Funzione di recupero (Danilo)
    public function recupero($email)
    {
        $studenteTab = $this->tabelleDB[6]; //Tabella per la query
        $docenteTab = $this->tabelleDB[2]; //Tabella per la query
        $campi = $this->campiTabelleDB[$studenteTab];
        /*  query: "SELECT email FROM studente WHERE email = ?
                    UNION
                    SELECT email FROM docente WHERE email = ?" */
        $query = (
            "SELECT " .
            $campi[3] . " " .
            "FROM " .
            $studenteTab . " " .
            "WHERE " .
            $campi[3] . " = ? " .
            "UNION " .
            "SELECT " .
            $campi[3] . " " .
            "FROM " .
            $docenteTab . " " .
            "WHERE " .
            $campi[3] . " = ?"
        );
        //Invio la query
        $stmt = $this->connection->prepare($query);
        $stmt->bind_param("ss", $email, $email);
        $stmt->execute();
        //Ricevo la risposta del DB
        $stmt->store_result();
        //Controllo se ha trovato matching tra dati inseriti e campi del db
        return $stmt->num_rows > 0;
    }

    // Funzione conferma Profilo (Andrea)
    public function confermaProfilo($email, $matricola)
    {
        $stringHelper = new StringHelper();
        $tabella = $this->tabelleDB[2];

        $campi = $this->campiTabelleDB[$tabella];
        //query:  "UPDATE docente/studente SET attivo = true WHERE matricola = ?"
        $query = (
            "UPDATE " .
            $tabella . " " .
            "SET " .
            $campi[5] . " = 1 " .
            "WHERE " .
            $campi[0] . " = ?"
        );
        //Invio la query
        $stmt = $this->connection->prepare($query);
        $stmt->bind_param("s", $matricola); //ss se sono 2 stringhe, ssi 2 string e un int (sostituisce ? della query)
        return($stmt->execute());
    }

    // Funzione Modifica Profilo (Gigi)// da cambiare il ritotno ok
    public function modificaProfilo($id, $nome, $cognome, $email,$password, $tabella)
    {
        $password = hash('sha256', $password);
        $campi = $this->campiTabelleDB[$tabella];
        //query:  "UPDATE TABLE SET nome = ?, cognome = ?, password = ? WHERE matricola = ?"
        $query = (
            "UPDATE " .
            $tabella. " " .
            "SET " .
            $campi[1] . " = ?, " .
            $campi[2] . " = ?, " .
            $campi[3] . " = ?, " .
            $campi[4] . " = ? " .
            "WHERE " .
            $campi[0] . " = ?"
        );
        //Invio la query
        $stmt = $this->connection->prepare($query);
        $stmt->bind_param("ssssi", $nome, $cognome,$email, $password, $id); //ss se sono 2 stringhe, ssi 2 string e un int (sostituisce ? della query)

        $result = $stmt->execute();

        //Controllo se ha trovato matching tra dati inseriti e campi del db
        return $result;
    }

    // Funzione Modifica Password (Andrea)
    public function modificaPassword($email, $password)
    {
        $password = hash('sha256', $password);
        $stringHelper = new StringHelper();
        $substr = $stringHelper->subString($email);
        $tabella = $this->tabelleDB[6];
        if ($substr == "unimol") {
            $tabella = $this->tabelleDB[2];
        }
        $campi = $this->campiTabelleDB[$tabella];
        //query:  "UPDATE TABLE SET password = ? WHERE email = ?"
        $query = (
            "UPDATE " .
            $tabella . " " .
            "SET " .
            $campi[4] . " = ? " .
            "WHERE " .
            $campi[3] . " = ?"
        );
        //Invio la query
        $stmt = $this->connection->prepare($query);
        $stmt->bind_param("ss", $password, $email); //ss se sono 2 stringhe, ssi 2 string e un int (sostituisce ? della query)
        return $stmt->execute();
    }

    // Funzione registrazione (Francesco)
    public function registrazione( $nome, $cognome, $email, $password, $contatto,$table)
    {
        $password = hash('sha256', $password);

        $tabella = $this->tabelleDB[$table];
        $campi = $this->campiTabelleDB[$tabella];
        $attivo = 0;
echo($password);
            //query: "INSERT INTO TABLE(datore:2,richiedente:4) ( nome, cognome, email, password, attivo, contatto) VALUES (?,?,?,?,?,0,?)"
            $query = (
                "INSERT INTO " .
                $tabella . " (" .

                $campi[1] . ", " .
                $campi[2] . ", " .
                $campi[3] . ", " .
                $campi[4] . ", " .
                $campi[5] . ", " .
                $campi[6] .") " .

                "VALUES (?,?,?,?,?,?)"
            );
            $stmt = $this->connection->prepare($query);
            $stmt->bind_param("ssssis",  $nome, $cognome, $email, $password, $attivo, $contatto); //ss se sono 2 stringhe, ssi 2 string e un int (sostituisce ? della query)
            $result = ($stmt->execute()) ;

        return $result;
    }

    // Funzione visualizza documento (Gigi)
    public function visualizzaDocumento($idDocumento)
    {
        $tabelal = $this->tabelleDB[3]; //Tabella per la query
        $campi = $this->campiTabelleDB[$tabelal];
        //query: "SELECT id, titolo, cod_docente, cod_studente, cod_materia, link FROM documento WHERE id = ?"
        $query = (
            "SELECT " .
            $campi[0] . ", " .
            $campi[1] . ", " .
            $campi[2] . ", " .
            $campi[3] . " " .
            $campi[4] . " " .
            $campi[5] . " " .
            "FROM " .
            $tabelal . " " .
            "WHERE " .
            $campi[0] . " = ?"
        );
        $stmt = $this->connection->prepare($query);
        $stmt->bind_param("i", $idDocumento);
        $stmt->execute();
        $stmt->store_result();
        if ($stmt->num_rows > 0) {
            $stmt->bind_result($idDocumento, $titolo, $cod_docente, $cod_studente, $cod_materia, $link);
            $documento = array();
            while ($stmt->fetch()) { //Scansiono la risposta della query
                $temp = array();
                //Indicizzo con key i dati nell'array
                $temp[$campi[0]] = $idDocumento;
                $temp[$campi[1]] = $titolo;
                $temp[$campi[2]] = $cod_docente;
                $temp[$campi[3]] = $cod_studente;
                $temp[$campi[4]] = $cod_materia;
                $temp[$campi[5]] = $link;
                array_push($documento, $temp); //Inserisco l'array $temp all'ultimo posto dell'array $documento
            }
            return $documento; //ritorno array Documento riempito con i risultati della query effettuata.
        } else {
            return null;
        }
    }

    //Funzione carica documento (Jonathan)



    //Funzione rimuovi documento (Domenico e Jonathan)
    public function rimuoviDocumento($idDocumento)
    {
        $tabella = $this->tabelleDB[3]; //Tabella per la query
        $campi = $this->campiTabelleDB[$tabella];
        //query:  " DELETE FROM DOCUMENTO WHERE ID = $idDocumento"
        $query = (
            "DELETE FROM " .
            $tabella . " WHERE " .
            $campi[0] . " = ? "
        );
        $stmt = $this->connection->prepare($query);
        $stmt->bind_param("i", $idDocumento);
        $result = $stmt->execute();
        $stmt->store_result();

        return $result;
    }

    //Funzione visualizza documento per id (Danilo)
    public function visualizzaDocumentoPerId($Matricola)
    {
        $tabella = $this->tabelleDB[3]; //Tabella per la query
        $campi = $this->campiTabelleDB[$tabella];

            //query= SELECT nome,link FROM documento WHERE cod_studente/cod_docente=$matricols
            $query = (
                "SELECT " .
                $campi[0] . ", " .
                $campi[1] . ", " .
                $campi[4] . ", " .
                $campi[5] . " " .
                "FROM " .
                $tabella . " " .
                "WHERE " .
                $campi[3] . " = ? OR ". $campi[2] . " = ? "
            );

        $stmt = $this->connection->prepare($query);
        $stmt->bind_param("ss", $Matricola,$Matricola);
        $stmt->execute();
        $stmt->store_result();
        if ($stmt->num_rows > 0) {
            //Salvo il risultato della query in alcune variabili che andranno a comporre l'array temp //
            $stmt->bind_result($id, $titolo, $cod_materia,$link);
            $documento= array();
            while ($stmt->fetch()) { //Scansiono la risposta della query
                $temp = array(); //Array temporaneo per l'acquisizione dei dati
                //Indicizzo con key i dati nell'array
                $temp[$campi[0]] = $id;
                $temp[$campi[1]] = $titolo;
                $temp[$campi[4]] = $cod_materia;
                $temp[$campi[5]] = $link;
                array_push($documento, $temp); //Inserisco l'array $temp all'ultimo posto dell'array $annunci
            }
            return $documento; //ritorno array Documento riempito con i risultati della query effettuata.
        } else {
            return null;
        }
    }


}


?>
