<?php

use Illuminate\Database\Seeder;

class transactions_data extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    \App\Transaction::create([
            'id'=> 1,
            'description' => 'Depostit of money',
            'action' => 'c',
            'currency' => 'R$'
        ],
    );
    \App\Transaction::create([
        'id'=> 2,
        'description' => 'Buy bitcoin credit',
        'action' => 'c',
        'currency' => '₿'
    ],
    );
    \App\Transaction::create([
        'id'=> 3,
        'description' => 'Buy bitcoin debit',
        'action' => 'd',
        'currency' => 'R$'
    ],
    );    
    \App\Transaction::create([
        'id'=> 4,
        'description' => 'Sell bitcoin debit',
        'action' => 'd',
        'currency' => '₿'
    ],
    ); 
    \App\Transaction::create([
        'id'=> 5,
        'description' => 'Sell bitcoin credit',
        'action' => 'c',
        'currency' => 'R$'
    ],
    );      
    }
}
