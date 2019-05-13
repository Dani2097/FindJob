<?php
/**
 * Created by PhpStorm.
 * User: Danilo
 * Date: 01/06/2018
 * Time: 10:48
 */

class DBRichiedente
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

    //Funzionante visualizza lavoro per id (Errico)
    public function visualizzaLavoroID($id)
    {
        $tabella = $this->tabelleDB[3];
        $campi = $this->campiTabelleDB[$tabella];
        //query: "SELECT nome, cognome, email FROM docente WHERE matricola = ?"
        $query = (
            "SELECT " .
            $campi[1] . ", " .
            $campi[2] . ", " .
            $campi[3] . ", " .
            $campi[4] . ", " .
            $campi[5] . " " .
            "FROM " .
            $tabella .
            " WHERE " .
            $campi[0] . " = ? "
        );
        $stmt = $this->connection->prepare($query);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $stmt->store_result();
        if ($stmt->num_rows > 0) {
            $stmt->bind_result($categoria, $nome, $datore, $descrizione, $link);
            $lavori = array();
            while ($stmt->fetch()) { //Scansiono la risposta della query
                $temp = array();
                //Indicizzo con key i dati nell'array
                $temp[$campi[1]] = $categoria;
                $temp[$campi[2]] = $nome;
                $temp[$campi[3]] = $datore;
                $temp[$campi[4]] = $descrizione;
                $temp[$campi[5]] = $link;

                array_push($lavori, $temp); //Inserisco l'array $temp all'ultimo posto dell'array $profilo
            }
            return $lavori;
        } else {
            return null;
        }
    }

    //Funzione visualizza libro per codice docente (Danilo)

    //Funzione rimuovi documento (Domenico e Jonathan)
    public function rimuoviCurriculum($idCurriculum)
    {
        $tabella = $this->tabelleDB[1]; //Tabella per la query
        $campi = $this->campiTabelleDB[$tabella];
        //query:  " DELETE FROM DOCUMENTO WHERE ID = $idDocumento"
        $query = (
            "DELETE FROM " .
            $tabella . " WHERE " .
            $campi[0] . " = ? "
        );
        $stmt = $this->connection->prepare($query);
        $stmt->bind_param("i", $idCurriculum);
        $result = $stmt->execute();
        $stmt->store_result();

        return $result;
    }
    public function caricaCurriculum($idrichiedente, $link)
    {
        $tabella = $this->tabelleDB[1]; //Tabella per la query
        $campi = $this->campiTabelleDB[$tabella];
        //query: "INSERT INTO curriculum (idrichiedente ,link) VALUES (?,?,?,?,?)"
        $query = (
            "INSERT INTO  " .
            $tabella . " ( " .

            $campi[1] . ", " .
            $campi[2] . " ) " .

            "VALUES (?,?)"
        );
        $stmt = $this->connection->prepare($query);
        $stmt->bind_param("is", $idrichiedente,$link);
        return $stmt->execute();
    }




}
