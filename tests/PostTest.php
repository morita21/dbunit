<?php
require_once 'Generic_Tests_DatabaseTestCase.php';
require_once 'src/post.php';

/**
 * https://phpunit.de/manual/current/ja/database.html
 * http://qiita.com/takatama/items/63c7c82108af48b7bbdb
 *
 * データベースとテーブルはあらかじめ作成しておく
 * モデルクラスもテスト用DBに接続するようにしておく（実行環境によるDB設定の切り替えが必要）
 *
 * 実行コマンド
 * /var/www/html$ vendor/bin/phpunit -c tests/ tests/
 *
 */
class PostTest extends Generic_Tests_DatabaseTestCase
{
    protected function getDataSet()
    {
        return new PHPUnit_Extensions_Database_DataSet_YamlDataSet(
            dirname(__FILE__) . "/fixtures/posts.yml"
        );
    }

    protected function getExpectedDataSet()
    {
        return new PHPUnit_Extensions_Database_DataSet_YamlDataSet(
            dirname(__FILE__) . "/fixtures/expects/posts.yml"
        );
    }

    public function testGuestbook()
    {
//        $dataSet = $this->getConnection()->createDataSet();
        $this->assertEquals(2, $this->getConnection()->getRowCount('posts'));

        $post = new Post();
        $post->add('aa', 'bb');

        $this->assertEquals(3, $this->getConnection()->getRowCount('posts'));

        // クエリ結果をあらかじめ用意したyamlと確認する
        $queryTable = $this->getConnection()->createQueryTable(
            'posts', 'SELECT id, title, content FROM posts'
        );
        $expectedTable = $this->getExpectedDataSet()->getTable('posts');
        $this->assertTablesEqual($expectedTable, $queryTable);
    }
}
