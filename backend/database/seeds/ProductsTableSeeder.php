<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\ProductType;

class ProductsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker\Factory::create();

        $subscription = ProductType::where('name', 'main')->first();
        $addon = ProductType::where('name', 'addon')->first();
        $oneTime = ProductType::where('name', 'one-time')->first();

        // Example subscriptions

        if($subscription->id > 0) {

            DB::table('products')->insert([
                'name' => 'Power',
                'slug' => 'power',
                'price' => 7490,
                'product_type_id' => $subscription->id,
                'can_be_bought_in_quantities' => false,
                'cycle' => 12,
                'desc' => '',
                'items' => json_encode([
                    'EXPERT +',
                    '5 Landingpages clé en main',
                    'Rédaction et référencement de contenu optimisé',
                    '5 Landingpages (Selfmade)',
                    'Audit complet et analyse des performances (3 fois par ans)',
                    'Gestion Campagne Google Ads et Facebook Ads (10 Mots clés par Landing page)',
                    'Gestion Campagne Retargeting Google Ads et Facebook Ads',
                    'Formations avancées en Marketing'
                ]),
                'images' => json_encode([$faker->imageUrl(), $faker->imageUrl(), $faker->imageUrl()]),
                'primary' => true,
                'status' => true
            ]);

            DB::table('products')->insert([
                'name' => 'Expert',
                'slug' => 'expert',
                'price' => 2490,
                'product_type_id' => $subscription->id,
                'can_be_bought_in_quantities' => false,
                'cycle' => 12,
                'desc' => '',
                'items' => json_encode([
                    'PRO +',
                    '5 Landingpage 1 clé en main (contenu à fournir) + 4 Self-made',
                    'Contrairement au package « PRO », le package « EXPERT » contient une page d’atterrissage clé en main. Autrement dit, nous nous chargeons de tout le design ainsi que de l’intégration du texte et des photos que vous allez nous fournir.',
                    'Formations Marketing (sessions individuelles)'
                ]),
                'images' => json_encode([$faker->imageUrl(), $faker->imageUrl(), $faker->imageUrl()]),
                'primary' => true,
                'status' => true
            ]);

            DB::table('products')->insert([
                'name' => 'VISIBILITY',
                'slug' => 'visibility',
                'price' => 1000,
                'product_type_id' => $addon->id,
                'can_be_bought_in_quantities' => true,
                'cycle' => 1,
                'desc' => '',
                'items' => json_encode([
                    'Audit complet et analyse des performances de votre site internet',
                    'Création et Gestion de votre Profil Google My Business',
                    'Gestion Campagne Google Ads (20 Mots clés, hors budget publicitaire)',
                    'Gestion Campagne Retargeting Google Ads',
                    'Création de 10 backlinks / netlinking puissants de Pages Rangs élevés (1 fois par mois)',
                    'Augmentation du trafic',
                    'Rapport détaillé (1 fois par mois)',
                    'Rédaction de 1 article SEO de 500 à 600 mots par mois',
                    'Publication sur Wedo',
                    'Référencement naturel de chaque article',
                    'Ciblage de votre clientèle Facebook',
                    'Création d’une pub Facebook ads attrayante (1 fois par mois)',
                    'Diffusion de votre publicité (hors budget publicitaire)'
                ]),
                'images' => json_encode([$faker->imageUrl(), $faker->imageUrl(), $faker->imageUrl()]),
                'primary' => true,
                'status' => true
            ]);

            DB::table('products')->insert([
                'name' => 'Formule membre associé',
                'slug' => 'formule-membre-associe',
                'price' => 1000,
                'product_type_id' => $addon->id,
                'can_be_bought_in_quantities' => false,
                'cycle' => 12,
                'desc' => '',
                'items' => json_encode([
                    'Enregistrement dans l’annuaire',
                    'Service d’affichage de vos offres d’emploi',
                    '1 Landingpage (Sites internet dédiés p.ex pour un service) (Selfmade)',
                    'Audit site web + plan d’action'
                ]),
                'images' => json_encode([$faker->imageUrl(), $faker->imageUrl(), $faker->imageUrl()]),
                'primary' => false,
                'status' => true
            ]);

            DB::table('products')->insert([
                'name' => 'PRO Webhosting',
                'slug' => 'pro-webhosting',
                'price' => 490,
                'product_type_id' => $addon->id,
                'can_be_bought_in_quantities' => true,
                'cycle' => 12,
                'desc' => '',
                'items' => json_encode([
                    'PRO Webhosting: Ce plan d’hébergement est parfait pour les sites qui ont besoin d’un service économique mais de qualité pour maintenir leur site web en fonction. Vous obtenez des fonctionnalités robustes avec beaucoup d’espace disque (20GB) SSD',
                    '20 GB Storage',
                    '1000 GB Traffic/month',
                    '80 Mailboxes (Webmail)',
                    '20 Domains',
                    '10 MySQL Databases',
                    'Admin Panel',
                    'Spam Protection',
                    'Anti-Virus',
                    'Free Setup',
                    'MySQL databases 10',
                    'PHP 5+',
                    'Python',
                    'FTP Accounts 10',
                    'Webmail',
                    'SSL',
                    'Subdomains per domain 20',
                    'Dedicated SSL once-off setup starting at 40 €',
                    'Dedicated IP address (p/m) 5 € per IP address',
                    'Dedicated IP address limit 6',
                    'Disk space overages per GB 5 €',
                    'WordPress',
                    'Joomla',
                    'Prestashop'
                ]),
                'images' => json_encode([$faker->imageUrl(), $faker->imageUrl(), $faker->imageUrl()]),
                'primary' => false,
                'status' => true
            ]);

            DB::table('products')->insert([
                'name' => 'PRO',
                'slug' => 'pro',
                'price' => 990,
                'product_type_id' => $subscription->id,
                'can_be_bought_in_quantities' => false,
                'cycle' => 12,
                'desc' => '',
                'items' => json_encode([
                    'START +',
                    'Accès aux demandes de devis',
                    '1 Landingpage (sites internet dédiés p.ex pour un nouveau produit, portes ouvertes etc) – Self-made',
                    'PRO Webhosting: Ce plan d’hébergement est parfait pour les sites qui ont besoin d’un service économique mais de qualité pour maintenir leur site web en fonction. Vous obtenez des fonctionnalités robustes avec beaucoup d’espace disque (20GB) SSD.',
                    'Audit site web + plan d’action'
                ]),
                'images' => json_encode([
                    $faker->imageUrl(900, 600),
                    $faker->imageUrl(900, 600),
                    $faker->imageUrl(900, 600)
                ]),
                'primary' => true,
                'status' => true
            ]);

            DB::table('products')->insert([
                'name' => 'START',
                'slug' => 'start',
                'price' => 490,
                'product_type_id' => $subscription->id,
                'can_be_bought_in_quantities' => false,
                'cycle' => 12,
                'desc' => '',
                'items' => json_encode([
                    'FREE +',
                    'Photos / Contact / Horaires / Responsables',
                    'Job Board / Événements / Promotions',
                    'Lien vers les medias sociaux',
                    'Mots clés – SEO'
                ]),
                'images' => json_encode([[
                    $faker->imageUrl(900, 600),
                    $faker->imageUrl(900, 600),
                    $faker->imageUrl(900, 600)
                ]]),
                'primary' => true,
                'status' => true
            ]);

            DB::table('products')->insert([
                'name' => 'FREE',
                'slug' => 'free',
                'price' => 0,
                'product_type_id' => $subscription->id,
                'can_be_bought_in_quantities' => false,
                'cycle' => 12,
                'desc' => '',
                'items' => json_encode([
                    'Enregistrement dans l’annuaire'
                ]),
                'images' => json_encode([
                    $faker->imageUrl(900,600),
                    $faker->imageUrl(900,600),
                    $faker->imageUrl(900,600)
                ]),
                'primary' => true,
                'status' => true
            ]);
        }

        // Example one-time products
        if ($oneTime->id > 0) {
            DB::table('products')->insert([
                'name' => 'Pack: Website, Multilingual & SEO',
                'slug' => 'pack-website-multilingual-seo',
                'price' => 7490,
                'product_type_id' => $oneTime->id,
                'can_be_bought_in_quantities' => true,
                'cycle' => 0,
                'desc' => 'High performance for your website:',
                'items' => json_encode([
                    'Setup of a completely manageable website (maximum 5 subpages)',
                    'Creation of a responsive design – compatible with all browsers (computer, tablet and smartphone)',
                    'Creation of an individual design for your website',
                    'Translation of your website',
                    '3 languages (FR, DE or EN)',
                    '5 page translations (up to 650 words each) into 2 languages',
                    'Each additional page will be charged (500€ net)',
                    'Integration of the WPML module for the use of complete multilingual websites in WordPress',
                    'Adding of search engine optimized content'
                ]),
                'images' => json_encode([[
                    $faker->imageUrl(900,600),
                    $faker->imageUrl(900,600),
                    $faker->imageUrl(900,600)
                ]]),
                'primary' => false,
                'status' => true
            ]);

            DB::table('products')->insert([
                'name' => 'Pack: Landing page & SEO',
                'slug' => 'pack-landing-page-seo',
                'price' => 2490,
                'product_type_id' => $oneTime->id,
                'can_be_bought_in_quantities' => true,
                'cycle' => 0,
                'desc' => 'High performance for your landing page:',
                'items' => json_encode([
                    'Implementation of a fully manageable Landing page (maximum 1 page)',
                    'Creating an individual design for your Landingpage',
                    'Creating a responsive design – compatible with all browsers (computer, tablet and smartphone)',
                    'Shutterstock images (maximum 15 images)',
                    'Optimizing your content for Google',
                    'Google Indexation'
                ]),
                'images' => json_encode([[
                    $faker->imageUrl(900,600),
                    $faker->imageUrl(900,600),
                    $faker->imageUrl(900,600)
                ]]),
                'primary' => false,
                'status' => true
            ]);

            DB::table('products')->insert([
                'name' => 'Pack: Maintenance per minute',
                'slug' => 'pack-maintenance-per-minute',
                'price' => 2,
                'product_type_id' => $oneTime->id,
                'can_be_bought_in_quantities' => true,
                'cycle' => 0,
                'desc' => '',
                'items' => json_encode([
                    'Insertion of texts',
                    'Picture upload and picture research',
                    'Adding of additional pages',
                    'Modification of business cards',
                    'Layout consulting and recommendation',
                    'SEO consulting and recommendation',
                    '2€ / MINUTE'
                ]),
                'images' => json_encode([[
                    $faker->imageUrl(900,600),
                    $faker->imageUrl(900,600),
                    $faker->imageUrl(900,600)
                ]]),
                'primary' => false,
                'status' => true
            ]);
        }

    }
}
