<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Carbon\Carbon;
use App\Http\Requests\CreateTask;

class TaskTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    // テストケースごとにDBをリフレッシュする
    use RefreshDatabase;

    // 各テストメソッド実行前に呼ばれる
    public function setUp() :void
    {
        parent::setup();
        // そもそものテストデータは必要なのでシーダーで生成．
        $this->seed('FolderTableSeeder');
    }
    /**
     * 期限日が日付でない場合
     * @test
     */
    public function due_date_shold_be_date()
    {
        $response = $this->post('/folders/1/tasks/create', [
            'title' => 'Sample task',
            'due_date' => 123,//不正データ
        ]);
        $response->assertSessionHasErrors([
            'due_date' => '期限日 には日付を入力してください．',
        ]);
    }
    /**
     * 期限が過去
     * @test
     */
    public function due_date_shold_be_not_past()
    {
        $response = $this->post('/folders/1/tasks/create', [
            'title' => 'Sample task',
            'due_date' => Carbon::yesterday()->format('Y/m/d'),
        ]);
        $response->assertSessionHasErrors([
            'due_date' => '期限日 には今日以降の日付を入力してください．',
        ]);
    }
    /**
     * 状態が定義されてない場合
     * @test
     */
    public function status_shold_be_within_defined_numbers()
    {
        $this->seed('TaskTableSeeder');

        $response = $this->post('/folders/1/tasks/1/edit', [
            'title' => 'Sample task',
            'due_date' => Carbon::today()->format('Y/m/d'),
            'status' => 999,
        ]);

        $response->assertSessionHasErrors([
            'status' => '状態 には 未着手，着手中，完了 のいずれかを指定してください．'
        ]);
    }
}
