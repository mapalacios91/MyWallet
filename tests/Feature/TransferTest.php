<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Wallet;
use App\Transfer;

class TransferTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testPostTransfer()
    {
        $this->withoutExceptionHandling();
        $wallet = factory(Wallet::class)->create();
        $transfer = factory(Transfer::class)->create();

        $response = $this->json('POST','/api/transfer',[
            'description' => $transfer->description,
            'amount'=> $transfer->amount,
            'wallet_id'=> $transfer->id
        ]);

        $response->assertJsonStructure([
            'id','description','amount','wallet_id'
        ])->assertStatus(201);

        $this->assertDatabaseHas('transfers',[
            'description' => $transfer->description,
            'amount'=> $transfer->amount,
            'wallet_id'=> $transfer->id
            
        ]);
        
        $this->assertDatabaseHas('wallets',[
            'id' => $wallet->id,
            'money'=> $wallet->money + $transfer->amount 
            
        ]);
 
    }
}
