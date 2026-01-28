<?php

namespace Database\Seeders;

use App\Models\Contact;
use Illuminate\Database\Seeder;

class ContactSeeder extends Seeder
{
    public function run(): void
    {
        $contacts = [
            [
                'first_name' => 'Sophie',
                'last_name' => 'Martin',
                'email' => 'sophie.martin@example.com',
                'phone' => '0612345678',
                'messages' => 'Bonjour, je suis intéressée par vos services de développement web. Pourriez-vous me contacter pour discuter d\'un projet de site e-commerce ?',
                'created_at' => now()->subDays(5),
            ],
            [
                'first_name' => 'Thomas',
                'last_name' => 'Bernard',
                'email' => 'thomas.bernard@example.com',
                'phone' => '0698765432',
                'messages' => 'J\'ai vu votre portfolio et je suis impressionné par votre travail sur les applications React. J\'aimerais discuter d\'une collaboration.',
                'created_at' => now()->subDays(3),
            ],
            [
                'first_name' => 'Pierre',
                'last_name' => 'Leroy',
                'email' => 'pierre.leroy@example.com',
                'phone' => '0687654321',
                'messages' => 'Super portfolio ! J\'aimerais en savoir plus sur votre expérience avec Vue.js et TailwindCSS.',
                'created_at' => now()->subDays(1),
            ],
            [
                'first_name' => 'Emma',
                'last_name' => 'Moreau',
                'email' => 'emma.moreau@example.com',
                'phone' => '0645678901',
                'messages' => 'Nous recherchons un développeur Full Stack pour rejoindre notre équipe. Votre profil correspond parfaitement à ce que nous cherchons.',
                'created_at' => now()->subHours(6),
            ],
        ];

        foreach ($contacts as $contact) {
            Contact::create($contact);
        }
    }
}