<?php
    $data     = json_decode(file_get_contents("../config.json"), true);
    $host     = $data['host'];
    $password = $data['password'];
    $dbname   = $data['dbname'];
    $username = $data['username'];
    try {
    $conn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    // comando SQL  
    $query = "  SELECT
                    Concessionaria_modelli.id_modello,
                    Concessionaria_modelli.nome AS nome_modello, 
                    Concessionaria_case_automobilistiche.nome AS casa_produttrice,
                    Concessionaria_cilindrate.valore,
                    Concessionaria_alimentazioni.nome AS alimentazione,
                    Concessionaria_categorie.descrizione,
                    Concessionaria_veicoli.prezzo, Concessionaria_veicoli.riferimento, Concessionaria_veicoli.id_veicolo
                FROM
                    Concessionaria_modelli
                JOIN
                    Concessionaria_veicoli
                        ON Concessionaria_veicoli.id_modello = Concessionaria_modelli.id_modello
                JOIN
                    Concessionaria_case_automobilistiche
                        ON Concessionaria_modelli.id_casa = Concessionaria_case_automobilistiche.id_casa
                JOIN
                    Concessionaria_cilindrate
                        ON Concessionaria_modelli.id_cilindrata = Concessionaria_cilindrate.id_cilindrata
                JOIN 
                    Concessionaria_alimentazioni
                        ON Concessionaria_modelli.id_alimentazione = Concessionaria_alimentazioni.id_alimentazione
                JOIN
                    Concessionaria_categorie
                        ON Concessionaria_modelli.id_categoria = Concessionaria_categorie.id_categoria";
    
    $price_condition_min     = isset($_GET["min_prezzo"]) ? $_GET["min_prezzo"] : false;
    $price_condition_max     = isset($_GET["max_prezzo"]) ? $_GET["max_prezzo"] : false;
    $marca_condition         = isset($_GET["marca_condition"]) ? $_GET["marca_condition"] : false;
    $alimentazione_condition = isset($_GET["alimentazione_condition"]) ? $_GET["alimentazione_condition"] : false;
    $displacement_condition  = isset($_GET["displacement_condition"]) ? $_GET["displacement_condition"] : false;
    $category_condition      = isset($_GET["category_condition"]) ? $_GET["category_condition"] : false;
    $order_condition         = isset($_GET["order_condition"]) ? $_GET["order_condition"] : false;
    
    $conditions = [];    
    $order_conditions = false;  
    if ($marca_condition) 
    {
        $conditions[] = " Concessionaria_case_automobilistiche.id_casa = :id_casa";
    }
    if ($alimentazione_condition) 
    {
        $conditions[] = " Concessionaria_alimentazioni.id_alimentazione = :id_alimentazione";
    }
    
    if ($displacement_condition) 
    {
        $conditions[] = " Concessionaria_cilindrate.id_cilindrata = :id_cilindrata";
    }
    
    if ($category_condition) 
    {
        $conditions[] = " Concessionaria_categorie.id_categoria = :id_categoria";
    }
    
    if ($price_condition_min && !$price_condition_max) {
        $conditions[] = " Concessionaria_veicoli.prezzo >= :min_prezzo";
    } else if(!$price_condition_min && $price_condition_max)
    {
        $conditions[] = " Concessionaria_veicoli.prezzo <= :max_prezzo";
    } else if($price_condition_min && $price_condition_max)
    {
        $conditions[] = " Concessionaria_veicoli.prezzo BETWEEN :min_prezzo AND :max_prezzo";
    }
    
    if($order_condition === "crescente")
    {
        $order_conditions = " ORDER BY Concessionaria_veicoli.prezzo";
    } else if($order_condition === "desc")
    {
        $order_conditions = " ORDER BY Concessionaria_veicoli.prezzo DESC";
    }
    
    if ($conditions) 
    {
        $query .= " WHERE " . implode(" AND ", $conditions);
    }

    if ($order_conditions) 
    {
        $query .=  $order_conditions;
    }
    $stmt = $conn->prepare($query);
    
    if($marca_condition)
        $stmt->bindParam(":id_casa", $marca_condition, PDO::PARAM_INT);

    if($alimentazione_condition)
        $stmt->bindParam(":id_alimentazione", $alimentazione_condition, PDO::PARAM_INT);

    if($displacement_condition)
        $stmt->bindParam(":id_cilindrata", $displacement_condition, PDO::PARAM_INT);

    if($category_condition)
        $stmt->bindParam(":id_categoria", $category_condition, PDO::PARAM_INT);

    if($price_condition_min && !$price_condition_max)
        $stmt->bindParam(":min_prezzo", $price_condition_min, PDO::PARAM_INT);

    if(!$price_condition_min && $price_condition_max)
        $stmt->bindParam(":max_prezzo", $price_condition_max, PDO::PARAM_INT);

    if($price_condition_min && $price_condition_max)
    {
        $stmt->bindParam(":min_prezzo", $price_condition_min, PDO::PARAM_INT);
        $stmt->bindParam(":max_prezzo", $price_condition_max, PDO::PARAM_INT);
    }
    
    $stmt->execute();
    $data = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if (count($data) > 0) {
        foreach ($data as $row) {
        $risp["veicoli_filtrati"][] = $row;
        }
        echo (json_encode($risp));
    } else {
        $risp["veicoli_filtrati"][] = array(
            "id_modello" => null,
            "nome_modello" => "Nessun modello del veicolo trovato",
            "casa_produttrice" => "Nessuna casa automobilistica del modello trovata",
            "valore" => "Nessuna cilindrata del modello trovata",
            "alimentazione" => "Nessuna alimentazione del modello trovata",
            "descrizione" => "Nessuna categoria del veicolo trovata",
            "prezzo" => "Nessun prezzo del veicolo trovato",
            "riferimento" => "Nessuna foto del veicolo trovata",
            "id_veicolo" => null
        );
        echo json_encode($risp);

    }

    $conn = null;
    $result = null;
    $stmt = null;
    } catch (PDOException $e) {
        die("Errore: " . $e->getMessage());
    }