<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ServicesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $services = [
            'Construction',
            'Rénovation',
            'Entrepreneur',
            'Entrepreneur construction traditionnelle',
            'Entreprise générale de bâtiment',
            'Transformation',
            'Salle de bains',
            'Travaux de peinture',
            'Fenêtre',
            'Travaux de rénovation',
            'Entrepreneur transformation',
            'Alentours',
            'Travaux de couverture et toiture',
            'Restauration de meuble',
            'Travaux de restauration',
            'Marbres',
            'Granits et pierres naturelles',
            'Antiquité',
            'Fenêtre marbres granits et pierres naturelles',
            'Meuble de salle de bains',
            'Portes rénovations',
            'Restaurations de bâtiments et de monuments historiques',
            'Conservation',
            'Mise en valeur de votre patrimoine',
            'Création',
            'Rénovation d\'espaces intérieurs et extérieurs',
            'Immobilière - Achat - Vente - Location',
            'Construction générale',
            'Rénovation extérieure',
            'Rénovation complète',
            'Rénovation intérieure',
            'Peinture',
            'Tapisserie',
            'Travaux',
            'Façade',
            'Carrelage',
            'Travaux de ravalement de façade',
            'Pavage',
            'Maison clé en main',
            'Marbrerie',
            'Aménagement de terrasse',
            'Sol et pose',
            'Dallage',
            'Voirie',
            'granits',
            'Pavé',
            'Rampe d\'accès',
            'Revêtement de sol extérieur',
            'pavés en pierres naturelles',
            'pavés de réemploi',
            'entrée de garage'
        ];

        foreach ($services as $service) {
            DB::table('services')->insert([
                'name' => $service,
                'slug' => str_slug($service, '-')
            ]);
        }
    }
}
