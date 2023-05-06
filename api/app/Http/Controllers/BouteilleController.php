<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Bouteille;
use App\Models\Type;
use App\Models\Pays;

class BouteilleController extends Controller
{
    /**
     * @author Saddek
     * @param Request $request
     * Retourne une liste (max, 10) des bouteilles qui ont le nom ou le code saq contenant ce que l'usager cherche..
     */
    public function index(Request $request)
    {
        return response()->json(
            Bouteille::where('nom', 'like', $request->requete . '%')
            ->orWhere('code_saq', 'LIKE', $request->requete . '%')
            ->take(10)
            ->get()
        );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        set_time_limit(6000);
        $nombreResultat = 0;
        // Le nombre de pages à vérifier
        for ($page=1; $page < 86 ; $page++) { 
            $nombreResultat += $this->retrouverProduitsSaq($page, $request);
        }
        return response()->json(['status' => 'ok', 'message'=>'inventaire à jour (' . $nombreResultat .') bouteilles ajoutées']);
    }


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
    
    /**
     * Display the specified resource.
     */
    public function show(Bouteille $bouteille)
    {
        return response()->json($bouteille);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Bouteille $bouteille)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Bouteille $bouteille)
    {
        //
    }

    /**
	 * getProduits
	 * @param int $nombre
	 * @param int $debut
	 */
	public function retrouverProduitsSaq($page, Request $request) {
		$s = curl_init();
		$url = "https://www.saq.com/fr/produits/vin?p=".$page."&product_list_limit=96";

        // Se prendre pour un navigateur pour berner le serveur de la saq...
        curl_setopt_array($s,array(
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_USERAGENT=>'Mozilla/5.0 (Windows NT 6.1; Win64; x64; rv:60.0) Gecko/20100101 Firefox/60.0',
            CURLOPT_ENCODING=>'gzip, deflate',
            CURLOPT_HTTPHEADER=>array(
                    'Accept: text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8',
                    'Accept-Language: en-US,en;q=0.5',
                    'Accept-Encoding: gzip, deflate',
                    'Connection: keep-alive',
                    'Upgrade-Insecure-Requests: 1',
            ),
    ));

		$_webpage = curl_exec($s);
		$_status = curl_getinfo($s, CURLINFO_HTTP_CODE);
		curl_close($s);
		$doc = new \DOMDocument();
		$doc->recover = true;
		$doc->strictErrorChecking = false;
        libxml_use_internal_errors(true);
		$doc->loadHTML($_webpage);
        libxml_use_internal_errors(false);

		$elements = $doc->getElementsByTagName("li");
		
        $i = 0;
		foreach ($elements as $noeud) {

			if (str_contains($noeud->getAttribute('class'), "product-item") ) {

                $request->merge($this->recupereInfo($noeud));

				$retour = $this->insererBouteille($request);
				if ($retour) $i++;
			}

		}
        return $i;

	}

	private function nettoyerEspace($chaine)
	{
		return preg_replace('/\s+/', ' ',$chaine);
	}

	private function recupereInfo($noeud) {
        
        $images = $noeud->getElementsByTagName("img");
        foreach ($images as $noeud) {

			if (str_contains($noeud->getAttribute('class'), "product-image-photo") ) {
                $info['img'] = explode('?', $noeud->getAttribute('src'))[0];
                break;
			}

		}
		
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

}
