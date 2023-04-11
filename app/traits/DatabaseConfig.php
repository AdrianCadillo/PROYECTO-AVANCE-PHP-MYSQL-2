<?php 
namespace traits;

use ZipArchive;

trait DatabaseConfig 
{
  
    private array $AccepTypeArchive = ["application/octet-stream"];
    /** COPIA DE SEGURIDAD */

    public function getCopia()
    {
               
     /// OBTENEMOS EL NOMBRE DE LA COPIA DE SEGURIDAD  
     
     $NameCopia = date("YmdHis")."_".str_replace(" ","_",$this->post("name_copia"));

     $ArchivoSql = $NameCopia.".sql";
       
     $ComandoCopia = "mysqldump --routines -h".SERVIDOR." -u".USERNAME." -p".PASSWORD." ".BASEDATOS." > $ArchivoSql";

     system($ComandoCopia,$output);

     switch($output)
     {
        case 0:
            /// zipear la copia de seguridad

            $Zipeado = new ZipArchive;

            /// creamos el nombre del archivo zip

            $NameZip = $NameCopia.".zip";

            /*==================================
         madamos a descarga automática
         ===================================*/

         header("Cache-Control: public");
         header("Content-Description: File Transfer");
         header("Content-Disposition: attachment; filename=".basename($NameZip));
         header("Content-Type: application/zip");
         header("Content-Transfer-Encoding: binary");

         if($Zipeado->open($NameZip,ZipArchive::CREATE))
         {
            /// AGREGAMOS LA COPIA DE SEGURIDAD AL ZIP

            $Zipeado->addFile($ArchivoSql);

            $Zipeado->close();

            unlink($ArchivoSql);

             /// eliminamos el bufffer generado
           ob_clean();

           flush(); 

           // leemos el archivo zip
  
           readfile(($NameZip));

           unlink($NameZip);/// eliminamos lo que se crea en la raiz del proyecto
         }
        break;    
     }

    }

  /** Realiza la restauración del sistema */
  
  public function restore()
  {
     $TipoArchivo = $this->getTypeFile("file_copia");

     if(in_array($TipoArchivo,$this->AccepTypeArchive)):
        $ComandoRestore = "mysql -h".SERVIDOR." -u".USERNAME." -p".PASSWORD." ".BASEDATOS." < ".$this-> getArchivo("file_copia");

        system($ComandoRestore,$output);

        switch($output)
        {
            case 0:
                $this->assignValueSession("mensaje_",1);    
            break;
            default:
            $this->assignValueSession("mensaje_",0);
            break;
        }

    else:
        $this->assignValueSession("mensaje_",2);
     endif;

     $this->Redirect("database");
  }

}