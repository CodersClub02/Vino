<?php

namespace App\Http\Controllers;

use App\Models\Bouteille;
use App\Models\Type;
use App\Models\Pays;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class ScraperController extends Controller
{

     /**
     * @author Saddek
     * Enregistrer les bouteilles recuperée du saq
     */
	public function store(Request $request) {
	
        set_time_limit(6000);
        $nombreResultat = 0;
        $page=1;
        $_webpage = Http::get('https://www.saq.com/fr/produits/vin', [
            'p' => $page,
            'product_list_limit' => 96,
        ]);

        while($page == 1 or str_contains($_webpage, '<span class="toolbar-number">1</span>') == false ){

            unset($doc);
            $doc = new \DOMDocument();
            $doc->recover = true;
            $doc->strictErrorChecking = false;
            libxml_use_internal_errors(true);
            $doc->loadHTML($_webpage);
            libxml_use_internal_errors(false);

            $elements = $doc->getElementsByTagName("li");
            
            foreach ($elements as $noeud) {

                if (str_contains($noeud->getAttribute('class'), "product-item") ) {

                    $request->merge($this->recupereInfo($noeud));

                    $retour = $this->insererBouteille($request);
                    if ($retour) $nombreResultat++;
                }
            }

            unset($_webpage);
            $_webpage = Http::get('https://www.saq.com/fr/produits/vin', [
                'p' => ++$page,
                'product_list_limit' => 96,
            ]);

        }

        return response()->json(['status' => 'ok', 'message'=>'inventaire à jour (' . $nombreResultat .') bouteilles ajoutées']);

	}

    /**
     * @author Saddek
     * enleve les espace dans les chaines de characteres
    */
	private function nettoyerEspace($chaine)
	{
		return preg_replace('/\s+/', ' ',$chaine);
	}


    /**
     * @author Saddek
     * retrouve l'infos dans le document HTML recuperé du saq
     */
	private function recupereInfo($noeud) {
    
        $lesImages = $noeud->getElementsByTagName("img");
        $img = null;
        for ($i = 0; $i < $lesImages->length; $i++) {
            $img = $lesImages->item($i);
            if (str_contains($img->getAttribute('class'), 'product-image-photo')) {
                    break;
                }
        }
        $info['img'] = explode('?', $img->getAttribute('src') )[0]; 

        $a_titre = $noeud->getElementsByTagName("a")->item(0);
		$info['url'] = $a_titre->getAttribute('href');
		
        $nom = $noeud->getElementsByTagName("a")->item(1)->textContent;

		$info['nom'] = $this->nettoyerEspace(trim($nom));

		$aElements = $noeud->getElementsByTagName("strong");
		foreach ($aElements as $node) {
			if ($node->getAttribute('class') == 'product product-item-identity-format') {
				$info['description'] = $this->nettoyerEspace($node->textContent);
				$tableauDescription = explode("|", $info['description']); // Type, Format, Pays
				if (count ($tableauDescription) == 3) {
					
					$info['type'] = trim($tableauDescription[0]);
					$info['format'] = trim($tableauDescription[1]);
					$info['pays'] = trim($tableauDescription[2]);

				}
				
				$info['description'] = trim($info['description']);
			}
		}

		//Code SAQ
		$aElements = $noeud->getElementsByTagName("div");
		foreach ($aElements as $node) {
			if ($node->getAttribute('class') == 'saq-code') {
				if(preg_match("/\d+/", $node->textContent, $aRes))
				{
					$info['code_SAQ'] = trim($aRes[0]);
				}
				
			}
		}

		$aElements = $noeud->getElementsByTagName("span");
		foreach ($aElements as $node) {
			if ($node->getAttribute('class') == 'price') {
				$info['prix'] = preg_replace("/[^0-9\,]/u", "", $node->textContent);
                $info['prix'] = str_replace(',', '.', $info['prix']);
			}
            
		}

		return $info;
	}

    /**
     * @author Saddek
     * Sauvegarder les données de bouteille dans la base des données
     */
    private function insererBouteille(Request $request){

        $type = Type::firstOrCreate([
            'nom' => $request->type
        ]);

        $pays = Pays::firstOrCreate([
            'nom' => $request->pays
        ]);

        $nouvelleBouteille = Bouteille::Create([
            'code_saq' => $request->code_SAQ,
            'nom' => $request->nom,
            'type_id' => $type->id,
            'pays_id' => $pays->id,
            'format' => $request->format,
            'description_saq' => $request->description,
            'prix_saq' => $request->prix,
            'url_saq' => $request->url,
            'url_image_saq' => $request->img
        ]);

        return $nouvelleBouteille->id;
    }
    
}
