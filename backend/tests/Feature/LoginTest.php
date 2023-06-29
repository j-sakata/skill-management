<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Illuminate\Support\Facades\Artisan;
use Inertia\Testing\Assert;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class LoginTest extends TestCase
{

    use DatabaseTransactions;
    private $connectionsToTransact = ['test_db'];

    public function setUp(): void
    {
        parent::setUp();
        Artisan::call('migrate:refresh');
        User::create([ 'user_id' => 'taro_yamada', 'name' => 'ヤマダ タロウ', 'email' => 'mail@example.com', 'password' => Hash::make('taro_yamada')]);
    }

    /**
     * @test
     */
    public function ログインページにアクセスする()
    {
        $response = $this->get('/login');

        $response->assertStatus(200);
    }

    /**
     * @test
     */
    public function ログインする()
    {

        // 異常系: バリデーションエラー
        $this->post('/login/in', array('user_id' => 'taro_yamada', 'password' => ''))
            ->assertInertia(fn (Assert $page) => $page
                ->component('Login')
                ->has('error')
            );
        $this->assertFalse(Auth::check());

        // 異常系: ログインエラー
        $this->post('/login/in', array('user_id' => 'taro_yamada', 'password' => 'taro'))
            ->assertInertia(fn (Assert $page) => $page
                ->component('Login')
                ->where('reply', "ログインに失敗しました")
            );
        $this->assertFalse(Auth::check());

        // 正常系
        $this->post('/login/in', array('user_id' => 'taro_yamada', 'password' => 'taro_yamada'))
            ->assertInertia(fn (Assert $page) => $page
                ->component('Login')
                ->has('data', fn (Assert $page) => $page
                    ->where('user_id', 'taro_yamada')
                    ->where('name', 'ヤマダ タロウ')
                    ->where('init_password', '0')
                )
            );
        $this->assertTrue(Auth::check());
    }

    /**
     * @test
     */
    public function ログアウトする() {
        // 事前検証
        $this->post('/login/in', array('user_id' => 'taro_yamada', 'password' => 'taro_yamada'));
        $this->assertTrue(Auth::check());

        // 正常系
        $this->post('/login/out', array())
            ->assertInertia(fn (Assert $page) => $page
                ->component('Login')
            );

        // 事後検証
        $this->assertFalse(Auth::check());
    }

    /**
     * @test
     */
    public function ログイン状態を確認する() {
        // ログイン前
        $this->assertFalse(Auth::check());
        $this->get('/login/check')->assertExactJson(['logined' => false]);

        // 事後検証
        $this->post('/login/in', array('user_id' => 'taro_yamada', 'password' => 'taro_yamada'));
        $this->assertTrue(Auth::check());
        $this->get('/login/check')->assertExactJson(['logined' => true]);
    }
}
