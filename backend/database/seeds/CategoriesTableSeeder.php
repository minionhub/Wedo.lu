<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategoriesTableSeeder extends Seeder
{
    protected $slugs = [];
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $categories = [
            [
                'name' => 'Construction',
                'icon' => '/icons/construction.svg',
                'children' => [
                    [ 'name' => 'Entrepreneur de construction et de génie civil', 'icon' => '' ],
                    [ 'name' => 'Électricien', 'icon' => '' ],
                    [ 'name' => 'Marbrier', 'icon' => '' ],
                    [ 'name' => 'Entrepreneur de terrassement', 'icon' => '' ],
                    [ 'name' => 'Entrepreneur d’asphaltage', 'icon' => '' ],
                    [ 'name' => 'Restaurateur d’élements préfabriqués & parquets', 'icon' => '' ],
                    [ 'name' => 'Monteur d’échafaudages', 'icon' => '' ],
                    [ 'name' => 'Confectionneur de chapes', 'icon' => '' ],
                    [ 'name' => 'Ramoneur – nettoyeur de toitures', 'icon' => '' ],
                    [ 'name' => 'Entrepreneur de forage et d’ancrage', 'icon' => '' ],
                    [ 'name' => 'Vitrier – miroitier', 'icon' => '' ],
                    [ 'name' => 'Fabricant – poseur de volets et de jalousies', 'icon' => '' ],
                    [ 'name' => 'Monte-charges', 'icon' => '' ],
                    [ 'name' => 'Mesures de sécurité en altitude', 'icon' => '' ],
                    [ 'name' => 'Entrepreneur de traitement de surfaces métalliques', 'icon' => '' ],
                    [ 'name' => 'Transformation', 'icon' => '' ],
                    [ 'name' => 'Installateur Chauffage, Sanitaire et Frigoriste', 'icon' => '' ],
                    [ 'name' => 'Installateur d’équipements électroniques', 'icon' => '' ],
                    [ 'name' => 'Réalisateur de décors de théâtre', 'icon' => '' ],
                    [ 'name' => 'de portes et de meubles préfabriqués', 'icon' => '' ],
                    [ 'name' => 'Marbrerie', 'icon' => '' ],
                    [ 'name' => 'Façadier', 'icon' => '' ],
                    [ 'name' => 'Charpentier – couvreur – ferblantier', 'icon' => '' ],
                    [ 'name' => 'Entrepreneur de constructions métalliques', 'icon' => '' ],
                    [ 'name' => 'Canalisation', 'icon' => '' ],
                    [ 'name' => 'Excavation', 'icon' => '' ],
                    [ 'name' => 'Monteur de fenêtres', 'icon' => '' ],
                    [ 'name' => 'Entrepreneur paysagiste', 'icon' => '' ],
                    [ 'name' => 'Acoustiques et d’étanchéité', 'icon' => '' ],
                    [ 'name' => 'Fumiste', 'icon' => '' ],
                    [ 'name' => 'Mécanicien de machines industriels et de la construction', 'icon' => '' ],
                    [ 'name' => 'Carreleur', 'icon' => '' ],
                    [ 'name' => 'Installateur de systèmes d’alarme et de sécuritéposeu', 'icon' => '' ],
                    [ 'name' => 'Chaudronnier – constructeur de réservoirs et de pièces en tôle', 'icon' => '' ],
                    [ 'name' => 'Constructeur – poseur de cheminées et de poêles en faïences', 'icon' => '' ],
                    [ 'name' => 'Construction', 'icon' => '' ],
                    [ 'name' => 'Maçonnerie', 'icon' => '' ],
                    [ 'name' => 'Panneaux de signalisation', 'icon' => '' ],
                    [ 'name' => 'Forgeron', 'icon' => '' ],
                    [ 'name' => 'poseur – monteur de fenêtres', 'icon' => '' ],
                    [ 'name' => 'Affûteur d’outils', 'icon' => '' ],
                    [ 'name' => 'Encadreur', 'icon' => '' ],
                    [ 'name' => 'Installateur Chauffage, Sanitaire et Frigoriste', 'icon' => '' ],
                    [ 'name' => 'Menuisier-ébéniste', 'icon' => '' ],
                    [ 'name' => 'Décorateur d’intérieur', 'icon' => '' ],
                    [ 'name' => 'Bitumage', 'icon' => '' ],
                    [ 'name' => 'Ferrailleur pour béton armé', 'icon' => '' ],
                    [ 'name' => 'Monteur de fenêtre, de portes et de meubles préfabriqués', 'icon' => '' ],
                    [ 'name' => 'Entrepreneur d’isolations thermiques, acoustiques et d’étanchéité', 'icon' => '' ],
                    [ 'name' => 'Peintre', 'icon' => '' ],
                    [ 'name' => 'Systèmes de protection solaire', 'icon' => '' ],
                    [ 'name' => 'Rénovations', 'icon' => '' ],
                    [ 'name' => 'Construction générale', 'icon' => '' ],
                    [ 'name' => 'Installateur d’ascenseurs', 'icon' => '' ],
                    [ 'name' => 'Construction traditionnelle', 'icon' => '' ],
                    [ 'name' => 'Plafonneur', 'icon' => '' ],
                    [ 'name' => 'Gros-oeuvre', 'icon' => '' ],
                    [ 'name' => 'Entretien et réparation de chauffage central', 'icon' => '' ],
                    [ 'name' => 'Installateur d’enseignes lumineuses', 'icon' => '' ],
                    [ 'name' => 'Recycleur d’équipements électriques et électroniques', 'icon' => '' ],
                    [ 'name' => 'Promotion immobilière', 'icon' => '' ],
                    [ 'name' => 'Sculpteur de pierres', 'icon' => '' ],
                    [ 'name' => 'Poseur de jointements', 'icon' => '' ]
                ]
            ],
            [
                'name' => 'Santé-Hygiène',
                'icon' => '/icons/mode.svg',
                'children' => [
                    [ 'name' => 'Coiffeur', 'icon' => '' ],
                    [ 'name' => 'Pédicure', 'icon' => '' ],
                    [ 'name' => 'Prothésiste – dentaire', 'icon' => '' ],
                    [ 'name' => 'Opticien-optométriste.audio – prothésiste', 'icon' => '' ],
                    [ 'name' => 'Esthéticienne', 'icon' => '' ],
                    [ 'name' => 'Opticien', 'icon' => '' ],
                    [ 'name' => 'Orthopédiste-cordonnier-bandagiste', 'icon' => '' ],
                    [ 'name' => 'Manucure – maquilleur', 'icon' => '' ],
                    [ 'name' => 'Audio – prothésiste', 'icon' => '' ],
                    [ 'name' => 'Soins de beauté', 'icon' => '' ]
                ]
            ],
            [
                'name' => 'Garagistes-Mécanique',
                'icon' => '/icons/garagistes.svg',
                'children' => [
                    [ 'name' => 'Garage', 'icon' => '' ],
                    [ 'name' => 'D’escaliers mécaniques et de matériel de manutention', 'icon' => '' ],
                    [ 'name' => 'Concessionnaire automobile', 'icon' => '' ],
                    [ 'name' => 'Mécanique', 'icon' => '' ],
                    [ 'name' => 'Constructeur – réparateur de bateaux', 'icon' => '' ],
                    [ 'name' => 'Mécanicien en mécanique générale', 'icon' => '' ],
                    [ 'name' => 'Mécanicien de machines agricoles', 'icon' => '' ],
                    [ 'name' => 'Constructeur – réparateur de carrosseries', 'icon' => '' ],
                    [ 'name' => 'Expert en automobiles', 'icon' => '' ],
                    [ 'name' => 'Machines agricoles', 'icon' => '' ],
                    [ 'name' => 'Débosseleur – peintre de véhicules', 'icon' => '' ],
                    [ 'name' => 'Garagiste', 'icon' => '' ],
                    [ 'name' => 'Réparateur de machines domestiques', 'icon' => '' ],
                    [ 'name' => 'Vulcanisateur', 'icon' => '' ]
                ]
            ],
            [
                'name' => 'Services',
                'icon' => '/icons/services.svg',
                'children' => [
                    [ 'name' => 'Nettoyeur de bâtiments', 'icon' => '' ],
                    [ 'name' => 'Loueur d’ambulances', 'icon' => '' ],
                    [ 'name' => 'Maréchal ferrant', 'icon' => '' ],
                    [ 'name' => 'Pompes funèbres', 'icon' => '' ],
                    [ 'name' => 'Jeux et automates', 'icon' => '' ],
                    [ 'name' => 'Création artistique', 'icon' => '' ],
                    [ 'name' => 'Station service', 'icon' => '' ],
                    [ 'name' => 'Loueur de taxis', 'icon' => '' ],
                    [ 'name' => 'Auto-école', 'icon' => '' ],
                    [ 'name' => 'Cordonnier réparateur', 'icon' => '' ],
                    [ 'name' => 'Ingénierie et études techniques', 'icon' => '' ],
                    [ 'name' => 'Service d’assistance', 'icon' => '' ],
                    [ 'name' => 'Intérim', 'icon' => '' ],
                    [ 'name' => 'Commerce de détail de meubles et d’appareils d’éclairage en magasin spécialisé', 'icon' => '' ],
                    [ 'name' => 'Exploitant d’une station de services pour véhicules', 'icon' => '' ],
                    [ 'name' => 'Entrepreneur de pompes funèbres', 'icon' => '' ],
                    [ 'name' => 'Alimentation de cinéma et de télévision', 'icon' => '' ],
                    [ 'name' => 'Commerce de gros de matériaux de construction et d’appareils sanitaires', 'icon' => '' ],
                    [ 'name' => 'Taxis', 'icon' => '' ],
                    [ 'name' => 'Promoteur immobilier', 'icon' => '' ],
                    [ 'name' => 'Location et vente de matériaux', 'icon' => '' ]
                ]
            ],
            [
                'name' => 'Alimentation',
                'icon' => '/icons/alim.svg',
                'children' => [
                    [ 'name' => 'Boulanger-pâtissier', 'icon' => '' ],
                    [ 'name' => 'Fabricant de glaces', 'icon' => '' ],
                    [ 'name' => 'chevillard-abatteur de bestiaux', 'icon' => '' ],
                    [ 'name' => 'Grossiste alimentaire', 'icon' => '' ],
                    [ 'name' => 'Traiteur', 'icon' => '' ],
                    [ 'name' => 'Alimentation de gaufres et de crêpes', 'icon' => '' ],
                    [ 'name' => 'Pâtissier-Confiseur', 'icon' => '' ],
                    [ 'name' => 'Boucher', 'icon' => '' ],
                    [ 'name' => 'Charcutier', 'icon' => '' ],
                    [ 'name' => 'Fabricant de salaisons et de tripes', 'icon' => '' ]
                ]
            ],
            [
                'name' => 'Activités artisanales diverses',
                'icon' => '/icons/activites_artisanales.svg',
                'children' => [
                    [ 'name' => 'Retoucheur de vêtements', 'icon' => '' ],
                    [ 'name' => 'Entrepreneur transformation', 'icon' => '' ],
                    [ 'name' => 'Armurier', 'icon' => '' ],
                    [ 'name' => 'Conseiller et certificateur énergétique', 'icon' => '' ],
                    [ 'name' => 'Métallurgie', 'icon' => '' ],
                    [ 'name' => 'Meunier', 'icon' => '' ],
                    [ 'name' => 'Mécanicien de matériel-médico-chirurgical', 'icon' => '' ],
                    [ 'name' => 'Fondeur d’art', 'icon' => '' ],
                    [ 'name' => 'Fabrication de matériel de levage et de manutention', 'icon' => '' ],
                    [ 'name' => 'Fabricant de jouets et d’objets de souvenirs', 'icon' => '' ],
                    [ 'name' => 'Nettoyeur à sec – blanchisseur', 'icon' => '' ],
                    [ 'name' => 'Tatoueur', 'icon' => '' ],
                    [ 'name' => 'Graveur', 'icon' => '' ],
                    [ 'name' => 'Peintre laqueur sur bois', 'icon' => '' ],
                    [ 'name' => 'Mosaïste', 'icon' => '' ],
                    [ 'name' => 'Galvaniseur', 'icon' => '' ],
                    [ 'name' => 'd’unités périphériques et de logiciels en magasin spécialisé', 'icon' => '' ],
                    [ 'name' => 'Repousseur sur métaux', 'icon' => '' ],
                    [ 'name' => 'fabricant – réparateur d’instruments de musique', 'icon' => '' ],
                    [ 'name' => 'Ferronnier d’art', 'icon' => '' ],
                    [ 'name' => 'prévention incendie', 'icon' => '' ],
                    [ 'name' => 'Constructeur de fours de production', 'icon' => '' ],
                    [ 'name' => 'Matériel informatique', 'icon' => '' ],
                    [ 'name' => 'Fleuriste', 'icon' => '' ],
                    [ 'name' => 'Fabricant d’ornements d’église', 'icon' => '' ],
                    [ 'name' => 'Sculpteur-tourneur sur bois', 'icon' => '' ],
                    [ 'name' => 'Etameur', 'icon' => '' ],
                    [ 'name' => 'Potier-céramiste', 'icon' => '' ]

                ]
            ],
            [
                'name' => 'Communication – Services',
                'icon' => '/icons/communication.svg',
                'children' => [
                    [ 'name' => 'Imprimeur', 'icon' => '' ],
                    [ 'name' => 'Atelier graphique', 'icon' => '' ],
                    [ 'name' => 'Cartonnier', 'icon' => '' ],
                    [ 'name' => 'Photographe', 'icon' => '' ],
                    [ 'name' => 'Maquettiste', 'icon' => '' ],
                    [ 'name' => 'Relieur', 'icon' => '' ],
                    [ 'name' => 'Opérateur de lumière et d’éclairage', 'icon' => '' ],
                    [ 'name' => 'Opérateur de son', 'icon' => '' ]
                ]
            ],
            [
                'name' => 'Les Partenaires de l’artisanat',
                'icon' => '/icons/partenaires_artisanat.svg',
                'children' => [
                    [ 'name' => 'Fiduciaires', 'icon' => '' ],
                    [ 'name' => 'Organisations', 'icon' => '' ],
                    [ 'name' => 'Ressources Humaines', 'icon' => '' ],
                    [ 'name' => 'Devenir partenaire', 'icon' => '' ],
                    [ 'name' => 'Informatique', 'icon' => '' ],
                    [ 'name' => 'Banques', 'icon' => '' ],
                    [ 'name' => 'Formation', 'icon' => '' ],
                    [ 'name' => 'Fournisseurs', 'icon' => '' ],
                    [ 'name' => 'Assurances', 'icon' => '' ],
                    [ 'name' => 'Communication', 'icon' => '' ]
                ]
            ],
            [
                'name' => 'Mode',
                'icon' => '/icons/mode_2.svg',
                'children' => [
                    [ 'name' => 'Styliste', 'icon' => '' ],
                    [ 'name' => 'Brodeur', 'icon' => '' ],
                    [ 'name' => 'Bijoutier-orfèvre', 'icon' => '' ],
                    [ 'name' => 'Tisserand', 'icon' => '' ],
                    [ 'name' => 'Horloger', 'icon' => '' ],
                    [ 'name' => 'Graveur', 'icon' => '' ],
                    [ 'name' => 'aaaaa', 'icon' => '' ]
                ]
            ],
        ];

        $slugs = [];

        foreach ($categories as $category) {
            $slug = $this->generateSlug($category['name']);

            $parentId = DB::table('categories')->insertGetId([
                'name' => $category['name'],
                'icon' => $category['icon'],
                'slug' => $slug,
                'parent' => 0
            ]);

            if(isset($category['children'])) {
                foreach ($category['children'] as $subCat) {
                    $slug = $this->generateSlug($subCat['name']);

                    DB::table('categories')->insert([
                        'name' => $subCat['name'],
                        'icon' => $subCat['icon'],
                        'slug' => $slug,
                        'parent' => $parentId
                    ]);
                }
            }
        }
    }

    public function generateSlug($string) {
        $slug = str_slug($string, '-');
        $surfix = '';
        $index = 1;
        while(count($this->slugs) > 0 && in_array($slug . $surfix, $this->slugs)) {
            $surfix = '-' . $index;
            $index++;
        }
        $this->slugs[] = $slug . $surfix;
        return $slug . $surfix;
    }
}
