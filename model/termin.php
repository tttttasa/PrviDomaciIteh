<?php 

class Termin{
    public $id;
    public $trener;
    public $lokacija;
    public $datum;

    public function __construct($id=null, $trener=null, $lokacija=null,  $datum=null){
        $this->id=$id;
        $this->trner=$trener;
        $this->lokacija=$lokacija;
        $this->datum=$datum;
    }

    public static function getAll(mysqli $conn){
        $query = "SELECT * FROM termin";
        return $conn->query($query);
    }

    public static function getById($id,mysqli $conn){
        $query = "SELECT * FROM termin WHERE id=$id";
        $myArray = array();
        $rezultat = $conn->query($query);
        if($rezultat){
            while($red = $rezultat->fetch_array()){
                $myArray[] = $red;
            }
        }

        return $myArray;
    }

    public static function deleteById($id, mysqli $conn){
        $query = "DELETE FROM termin WHERE id=$id";
        return $conn->query($query);
    }

    public static function add( $trener,$lokacija, $datum, mysqli $conn){
        $query = "INSERT INTO termin(trener,lokacija,datum) VALUES('$trener','$lokacija','$datum')";
        return $conn->query($query);
    }

    public static function update($id, $trener,$lokacija, $datum, mysqli $conn){
        $query = "UPDATE termin SET trener='$trener', lokacija='$lokacija', datum='$datum' WHERE id=$id";
        return $conn->query($query);
    }

    public static function getLast(mysqli $conn)
    {
        $q = "SELECT * FROM termin ORDER BY id DESC LIMIT 1";
        return $conn->query($q);
    }
}
?>