<?php

namespace App\Http\Controllers;

use App\Models\Bouteille;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

use Symfony\Component\HttpClient\HttpClient;
use Symfony\Component\BrowserKit\HttpBrowser;

class ScraperController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $client = HttpClient::create();
        $browser = new HttpBrowser($client);

        $url = "https://www.saq.com/fr/produits/vin?product_list_limit=96";
        $crawler = $browser->request('GET', $url);

        // Extraire le nombre total d'items
        $totalItemsNode = $crawler->filter('.toolbar-number:nth-child(3)')->text();
        dd($totalItemsNode);
        preg_match('/(\d+)$/', $totalItemsNode, $matches);
        $totalItems = isset($matches[1]) ? intval($matches[1]) : 0;

        // Calculer le nombre total de pages
        // $totalPage = ceil($totalItems / 96);
        $totalPage = 5;


        // $_webpage = Http::get('https://www.saq.com/fr/produits/vin', [
        //     'p' => 1,
        //     'product_list_limit' => 96,
        // ]);

        // dd($_webpage->body()->filter('.toolbar-amount'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Bouteille $bouteille)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Bouteille $bouteille)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Bouteille $bouteille)
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
		$_webpage = Http::get('https://www.saq.com/fr/produits/vin', [
            'p' => 1,
            'product_list_limit' => 96,
        ]);

        
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
		
		$info['img'] = explode('?', $noeud->getElementsByTagName("img")->item(0)->getAttribute('src'))[0]; 
		
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
