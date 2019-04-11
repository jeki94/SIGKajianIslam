<?php
require_once("Connection.php");
class JsonDisplayMarker {
    function getMarkers(){
        //buat koneksinya
        $connection = new Connection();
        $conn = $connection->getConnection();

        //buat responsenya
        $response = array();

        $id = isset($_GET['id']);

        $code = "code";
        $message = "message";

        try{
            //tampilkan semua data dari mysql
            $queryMarker = "SELECT * FROM bencana WHERE id_bencana=$id";
            $getData = $conn->prepare($queryMarker);
            $getData->execute();

            $result = $getData->fetchAll(PDO::FETCH_ASSOC);

            foreach($result as $data){
                array_push($response,
                    array(
                        'nama'=>$data['nama_bencana'],
                        'latitude'=>$data['lat'],
                        'longitude'=>$data['lng'],
                    	'date'=>$data['tgl'],
                    	'ket'=>$data['keterangan'])
                    );
            }
        }catch (PDOException $e){
            echo "Failed displaying data".$e->getMessage();
        }

        //buatkan kondisi jika berhasil atau tidaknya
        if($queryMarker){
            echo json_encode(
                array("data"=>$response,$code=>1,$message=>"Success")
            );
        }else{
            echo json_encode(
                array("data"=>$response,$code=>0,$message=>"Failed displaying data")
            );
        }


    }
}

$location = new JsonDisplayMarker();
$location->getMarkers();