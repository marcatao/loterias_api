<?php

namespace App\Http\Controllers;

use Laravel\Lumen\Routing\Controller as BaseController;

use ZipArchive;
use domDocument;
use App\results_lotofacil;

use Illuminate\Http\Request;

class LotofacilController extends BaseController
{

    public function index_get(Request $request){
        $sorteio="";
        if($request->sorteio) $sorteio = "/".$request->sorteio;
        $token =  $request->token;
        $client = new \GuzzleHttp\Client();
        $headers = [
            'Authorization' => 'Bearer ' . $token,        
            'Accept'        => 'application/json',
        ];
        $response = $client->request('POST', env('PATH_API').'/lotofacil/concurso'.$sorteio, ['headers' => $headers]);
        $response->getHeaderLine('content-type');
        return  $response->getBody(); 

    }
    public function index($id = null){
        if(!$id) $id = results_lotofacil::max('concurso');
        $r = results_lotofacil::find($id);
        if($r) return response()->json($r,201);
        return response()->json(['message' => 'numero de concurso indisponivel'],404);
    }


    public function create(){
        //Aply user agente for more confidence request
        $name ='';
        if( !isset( $_SERVER['HTTP_USER_AGENT'])){
             $name = "Mozilla/5.0 (Macintosh; Intel Mac OS X 10.7; rv:7.0.1) Gecko/20100101 Firefox/7.0.1";
        }

        $url="http://www1.caixa.gov.br/loterias/_arquivos/loterias/D_lotfac.zip";
            // Use basename() function to return the base name of file  
            $file_name = basename($url); 
            if (file_exists($file_name)) unlink($file_name); 
            $VContext = stream_context_create(["http" => ['method' => 'GET', 'header' => ['Cookie: security=true'."\r\n", 'User-Agent' => $name]]]);
            // Use file_get_contents() function to get the file 
            // from url and use file_put_contents() function to 
            // save the file by using base name 
            if(file_put_contents($file_name,file_get_contents($url, false, $VContext))) { 
                  $zip = new ZipArchive();
                  if( $zip->open( $file_name )  === true){
                    $file_html = $zip->getFromName('d_lotfac.htm');
                    $conteudo_php = $zip->getFromIndex(0);
                    $html = $this->html_to_table($conteudo_php);
                  }
            }else { 
                echo "File downloading failed."; 
            } 
    }

public function html_to_table($file){
//$contents = file_get_contents($file);
$DOM = new DOMDocument;
    $internalErrors = libxml_use_internal_errors(true);
		$DOM->loadHTML($file);
		$items = $DOM->getElementsByTagName('tr');
        $ultimo = (int) results_lotofacil::max('concurso');
        $i=0;
		foreach ($items as $node) {
            $concurso = (int) (trim(substr(trim($node->textContent),0,4)));

            if(($concurso <> '') and (is_numeric($concurso)) and ($concurso > $ultimo)){
               //If concurso not exists save into database to serv on API 
               //var_dump(self::tdrows($node->childNodes));

                $r = new results_lotofacil;
                $r->concurso                 = isset(self::tdrows($node->childNodes)[0])  ? self::tdrows($node->childNodes)[0] : 0 ;
                $r->dt_sorteio               = isset(self::tdrows($node->childNodes)[2])  ? self::tdrows($node->childNodes)[2] : '11/11/2011' ;
                $r->bola_1                   = isset(self::tdrows($node->childNodes)[4])  ? self::tdrows($node->childNodes)[4] : 0 ;
                $r->bola_2                   = isset(self::tdrows($node->childNodes)[6])  ? self::tdrows($node->childNodes)[6] : 0 ;
                $r->bola_3                   = isset(self::tdrows($node->childNodes)[8])  ? self::tdrows($node->childNodes)[8] : 0 ;
                $r->bola_4                   = isset(self::tdrows($node->childNodes)[10]) ? self::tdrows($node->childNodes)[10] : 0 ;
                $r->bola_5                   = isset(self::tdrows($node->childNodes)[12]) ? self::tdrows($node->childNodes)[12] : 0 ;
                $r->bola_6                   = isset(self::tdrows($node->childNodes)[14]) ? self::tdrows($node->childNodes)[14] : 0 ;
                $r->bola_7                   = isset(self::tdrows($node->childNodes)[16]) ? self::tdrows($node->childNodes)[16] : 0 ;
                $r->bola_8                   = isset(self::tdrows($node->childNodes)[18]) ? self::tdrows($node->childNodes)[18] : 0 ;
                $r->bola_9                   = isset(self::tdrows($node->childNodes)[20]) ? self::tdrows($node->childNodes)[20] : 0 ;
                $r->bola_10                  = isset(self::tdrows($node->childNodes)[22]) ? self::tdrows($node->childNodes)[22] : 0 ;
                $r->bola_11                  = isset(self::tdrows($node->childNodes)[24]) ? self::tdrows($node->childNodes)[24] : 0 ;
                $r->bola_12                  = isset(self::tdrows($node->childNodes)[26]) ? self::tdrows($node->childNodes)[26] : 0 ;
                $r->bola_13                  = isset(self::tdrows($node->childNodes)[28]) ? self::tdrows($node->childNodes)[28] : 0 ;
                $r->bola_14                  = isset(self::tdrows($node->childNodes)[30]) ? self::tdrows($node->childNodes)[30] : 0 ;
                $r->bola_15                  = isset(self::tdrows($node->childNodes)[32]) ? self::tdrows($node->childNodes)[32] : 0 ;
                $r->arrecadacao_total        = isset(self::tdrows($node->childNodes)[34]) ? self::tdrows($node->childNodes)[34] : 0 ;
                $r->ganhadores_15_numeros    = isset(self::tdrows($node->childNodes)[36]) ? self::tdrows($node->childNodes)[36] : 0 ;
                $r->ganhadores_14_numeros    = isset(self::tdrows($node->childNodes)[42]) ? self::tdrows($node->childNodes)[42] : 0 ;
                $r->ganhadores_13_numeros    = isset(self::tdrows($node->childNodes)[44]) ? self::tdrows($node->childNodes)[44] : 0 ;
                $r->ganhadores_12_numeros    = isset(self::tdrows($node->childNodes)[46]) ? self::tdrows($node->childNodes)[46] : 0 ;
                $r->ganhadores_11_numeros    = isset(self::tdrows($node->childNodes)[48]) ? self::tdrows($node->childNodes)[48] : 0 ;
                $r->valor_rateio_15_numeros  = isset(self::tdrows($node->childNodes)[50]) ? self::tdrows($node->childNodes)[50] : 0 ;
                $r->valor_rateio_14_numeros  = isset(self::tdrows($node->childNodes)[52]) ? self::tdrows($node->childNodes)[52] : 0 ;
                $r->valor_rateio_13_numeros  = isset(self::tdrows($node->childNodes)[54]) ? self::tdrows($node->childNodes)[54] : 0 ;
                $r->valor_rateio_12_numeros  = isset(self::tdrows($node->childNodes)[56]) ? self::tdrows($node->childNodes)[56] : 0 ;
                $r->valor_rateio_11_numeros  = isset(self::tdrows($node->childNodes)[58]) ? self::tdrows($node->childNodes)[58] : 0 ;
                $r->acumulado_15_numeros     = isset(self::tdrows($node->childNodes)[60]) ? self::tdrows($node->childNodes)[60] : 0 ;
                $r->estimativa_premio        = isset(self::tdrows($node->childNodes)[62]) ? self::tdrows($node->childNodes)[62] : 0 ;
                $r->valor_acumulado_especial = isset(self::tdrows($node->childNodes)[64]) ? self::tdrows($node->childNodes)[64] : 0 ;
                try {
                    $r->save();
                    echo "adicionado concurso:".$r->concurso.", ";
                } catch (Exception $e) {
                    echo 'Linha ignorada: ',  $e->getMessage(), "\n";
                }

                if (++$i == 50) break;//Try 2 times save new concurses
            }
		}
        libxml_use_internal_errors($internalErrors);
}

//Get row and transform in row-array to explode data
static function tdrows($elements){
		$str = array();
		foreach ($elements as $element) {
			$str[] = $element->nodeValue;          
		}
		return $str;
	}

    
}
