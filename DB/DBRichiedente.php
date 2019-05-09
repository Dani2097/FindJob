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

    //Funzionante visualizza profilo docente (Michela)
    public function visualizzaProfiloDocente($matricola)
    {
        $tabella = $this->tabelleDB[2];
        $campi = $this->campiTabelleDB[$tabella];
        //query: "SELECT nome, cognome, email FROM docente WHERE matricola = ?"
        $query = (
            "SELECT " .
            $campi[1] . ", " .
            $campi[2] . ", " .
            $campi[3] . " " .
            "FROM " .
            $tabella .
            " WHERE " .
            $campi[0] . " = ? "
        );
        $stmt = $this->connection->prepare($query);
        $stmt->bind_param("s", $matricola); //ss se sono 2 stringhe, ssi 2 string e un int (sostituisce ? della query)
        $stmt->execute();
        $stmt->store_result();
        if ($stmt->num_rows > 0) {
            $stmt->bind_result($nome, $cognome, $email);
            $profilo = array();
            while ($stmt->fetch()) { //Scansiono la risposta della query
                $temp = array();
                //Indicizzo con key i dati nell'array
                $temp[$campi[1]] = $nome;
                $temp[$campi[2]] = "$cognome";
                $temp[$campi[3]] = $email;

                array_push($profilo, $temp); //Inserisco l'array $temp all'ultimo posto dell'array $profilo
            }
            return $profilo;
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
