<?php session_start();
include('fpdf.php');
if(isset($_SESSION["id"])&& isset($_SESSION["username"])){
    $id=$_SESSION["id"];
    $nombre=$_SESSION["username"];
    $servername = "localhost";
    $username = "id2418571_juanjo";
    $password = "34963006";
    $dbname = "id2418571_jjdtb";
        try {
        $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
        // set the PDO error mode to exception
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $stmt = $conn->prepare("SELECT coment, fecha FROM tabla_coment WHERE id_user=$id"); 
        $stmt->execute();
            // set the resulting array to associative
        $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
        $miscomenpdf=$stmt->fetchAll();
        }catch(PDOException $e) {
                
                echo "Error: " . $e->getMessage();
            }
            $conn = null;       
}
/**
 * Clase que fabrica la estructura del pdf
 * @author JJ<jjkoyote1980@gmail.com>
 */
class PDF extends FPDF {
        // Cabecera de página
    /**
     * funcion que construye la cabecera del pdf
     * @return void
     */
        function Header() {
            // Logo
            $this->Image('koyotelogo.jpg',10,8,33);
            // Arial bold 15
            $this->SetFont('Arial','B',15);
            // Movernos a la derecha
            $this->Cell(80);
            // Título
            $this->Cell(0,10,'Mensajes del libro de visitas',0,0,'L');
            // Salto de línea
            $this->Ln(20);
        }

        // Pie de página
        /**
         * funcion que fabrica el footer del pdf
         * @return void
         */
        function Footer() {
            // Posición: a 1,5 cm del final
            $this->SetY(-15);
            // Arial italic 8
            $this->SetFont('Arial','I',8);
            // Número de página
            $this->Cell(0,10,'Page '.$this->PageNo().'/{nb}',0,0,'C');
        }
    }

     $border=0;

    $pdf = new PDF();
    $pdf->AliasNbPages();
    $pdf->AddPage();
    $pdf->SetFont('Arial','B',16);
    $pdf->Cell(0,40,utf8_decode('Lectura Nº 30145'),$border,1,'L');
    $pdf->Cell(105,10,utf8_decode('Mensajes de ' . $nombre),$border,0,'L');
    $pdf->Cell(30,10,'Fecha y Hora',$border,1,'L');
    


    for ($contador=0;$contador<count($miscomenpdf);$contador++){
        $pdf->Cell(105,10,utf8_decode($miscomenpdf[$contador]["coment"]),$border,0,'L');
        $pdf->Cell(30,10,utf8_decode($miscomenpdf[$contador]["fecha"]),$border,1,'L');          
    }

    $pdf->Output();
?>    	