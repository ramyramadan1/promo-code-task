<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class PromoCodeTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_example(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }
    
    
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_generate_token()
    {
        $response = $this->json('POST','/oauth/token',[
            'grant_type'=>'password',
            'password'=>'@User1_$$',
            'client_id'=>'01976e3b-bcb5-7305-9ef5-908ef797584f',
            'client_secret'=>'1VLE5i9a5uIohnCOvGMm8cM3MAV7qXkPERB9ZVfc',
            'username'=>'user@example.com',
            'scope'=>'*'
        ]);
        $response->assertJsonStructure([
            'token_type',
            'expires_in',
            'access_token',
        ]);
        $response->assertStatus(200);
    }
    
    /**
     * Test Create promo code by admin user
     */
    public function test_create_promo_code_by_admin(){
        //get admin token 
        
        $response = $this->authAdmin();
        $response= json_decode($response->getContent(),true);
        $result = $this->json('POST','/api/v1/promo-code/generate',[
                'promo_type'=>'percentage',
                'value'=>'10',
                'user_ids[]'=>'2',
                'max_usage'=>'10',
                'max_usage_per_user'=>'2',
                'usage_time_per_user'=>'2'
        ],[
            'Accept'=>'application/json',
            'Authorization'=>'Bearer '.$response['access_token']
        ]);
        $result->assertJsonStructure(['message','promo_code']);
        $result->assertStatus(200);
    }
    
    public function test_create_promo_code_by_user(){
        //get admin token 
        $response = $this->authUser();
        $response= json_decode($response->getContent(),true);
        $result = $this->json('POST','/api/v1/promo-code/generate',[
                'promo_type'=>'percentage',
                'value'=>'10',
                'user_ids[]'=>'2',
                'max_usage'=>'10',
                'max_usage_per_user'=>'2',
                'usage_time_per_user'=>'2'
        ],[
            'Accept'=>'application/json',
            'Authorization'=>'Bearer '.$response['access_token']
        ]);
        $result->assertJsonStructure(['message']);
        $result->assertStatus(400);
    }
    
    
    public function test_redeem_code(){
        //get admin token 
        $user = $this->authAdmin();
        $promoCodeResult = $this->json('POST','/api/v1/promo-code/generate',[
                'promo_type'=>'percentage',
                'value'=>'20',
                'user_ids[]'=>'2',
                'max_usage'=>'10',
                'max_usage_per_user'=>'2',
                'usage_time_per_user'=>'2'
        ],[
            'Accept'=>'application/json',
            'Authorization'=>'Bearer '.$user['access_token']
        ]);
        $promoCodeResult= json_decode($promoCodeResult->getContent(),true);
        $redeemCodeResult  = $this->json('POST','/api/v1/promo-code/redeem',[
                'code'=>$promoCodeResult['promo_code'],
                'price'=>'100'
        ],[
            'Accept'=>'application/json',
            'Authorization'=>'Bearer '.$user['access_token']
        ]);

        $redeemCodeResult->assertJsonStructure(['message','result'=>[
            'price','promocode_discounted_amount','price_after_discount'
        ]]);
        
        $redeemCodeResult->assertJsonFragment([
            'price' => 100,
            'promocode_discounted_amount' => 20,
            'price_after_discount' => 80,
        ]);

        $redeemCodeResult->assertStatus(200);
    }
    
    private function authUser(){
        $response = $this->json('POST','/oauth/token',[
            'grant_type'=>'password',
            'password'=>'@User1_$$',
            'client_id'=>'01976e3b-bcb5-7305-9ef5-908ef797584f',
            'client_secret'=>'1VLE5i9a5uIohnCOvGMm8cM3MAV7qXkPERB9ZVfc',
            'username'=>'user@example.com',
            'scope'=>'*'
        ]);
        return $response;
    }
    
    private function authAdmin(){
        $response = $this->json('POST','/oauth/token',[
            'grant_type'=>'password',
            'password'=>'@Admin1_$$',
            'client_id'=>'01976e3b-bcb5-7305-9ef5-908ef797584f',
            'client_secret'=>'1VLE5i9a5uIohnCOvGMm8cM3MAV7qXkPERB9ZVfc',
            'username'=>'admin@example.com',
            'scope'=>'*'
        ]);
        return $response;
    }
    
    
}
