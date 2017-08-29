<?php
/**
 * Created by PhpStorm.
 * User: Amor
 * Date: 2017/8/28
 * Time: 11:57
 */

include "vendor/autoload.php";



//$test = new testFunctionCleanDir();

//$test->testFuncCleanDirWhenNotDeleteNotNeedleNotAll();
//$test->testFuncCleanDirWhenDeleteNotNeedleNotAll();
//$test->testInitTestData();
//$test->testFuncCleanDirWhenNotDeleteNeedleNotAll();
//$test->testFuncCleanDirWhenDeleteNotNeedleNotAll();
//$test->testFuncCleanDirWhenNotDeleteNeedleAll();
//$test->testFuncCleanDirWhenDeleteNeedleAll();


use PHPUnit\Framework\TestCase;

class cleanDirTest extends TestCase{

    private $testDirName = "testDir";

    function testFuncCleanDirWhenNotDeleteNotNeedleNotAll():void
    {
        cleanDir($this->getTestDir(),false,'',false);
        $this->assertStringMatchesFormatFile($this->getTestDir().DIRECTORY_SEPARATOR."1hello.log","");

    }

    function testFuncCleanDirWhenDeleteNotNeedleNotAll():void
    {
        cleanDir($this->getTestDir(),true,'',false);
        $this->assertFileNotExists($this->getTestDir().DIRECTORY_SEPARATOR."1hello.log");
    }

    function testFuncCleanDirWhenNotDeleteNeedleNotAll():void
    {
        cleanDir($this->getTestDir(),false,'2hello',false);
        $this->assertStringMatchesFormatFile($this->getTestDir().DIRECTORY_SEPARATOR."2hello.log","");
    }

    function testFuncCleanDirWhenDeleteNeedleNotAll():void
    {
        cleanDir($this->getTestDir(),true,'3hello',false);
        $this->assertFileNotExists($this->getTestDir().DIRECTORY_SEPARATOR."3hello.log");
    }

    function testFuncCleanDirWhenNotDeleteNeedleAll()
    {
        cleanDir($this->getTestDir(),false,'4hello',true);
        $this->assertStringNotMatchesFormatFile($this->getTestDir().DIRECTORY_SEPARATOR."1hello.log","");
        $this->assertStringNotMatchesFormatFile($this->getTestDir().DIRECTORY_SEPARATOR."2hello.log","");
        $this->assertStringNotMatchesFormatFile($this->getTestDir().DIRECTORY_SEPARATOR."3hello.log","");
        $this->assertStringMatchesFormatFile($this->getTestDir().DIRECTORY_SEPARATOR."4hello.log","");
        $this->assertStringMatchesFormatFile($this->getTestDir().DIRECTORY_SEPARATOR."4hello4.log","");
    }

    function testFuncCleanDirWhenDeleteNeedleAll()
    {
        cleanDir($this->getTestDir(),true,'4hello',true);
        $this->assertFileNotExists($this->getTestDir().DIRECTORY_SEPARATOR."4hello.log");
        $this->assertFileNotExists($this->getTestDir().DIRECTORY_SEPARATOR."4hello4.log");
        $this->assertFileExists($this->getTestDir().DIRECTORY_SEPARATOR."1hello.log");
        $this->assertFileExists($this->getTestDir().DIRECTORY_SEPARATOR."2hello.log");
        $this->assertFileExists($this->getTestDir().DIRECTORY_SEPARATOR."3hello.log");
    }


    /**
     * 测试初始化数据是否成功
     *
     */
    function testInitTestData():void
    {
        $this->assertDirectoryExists($this->getTestDir());
        $this->assertFileExists($this->getTestDir().DIRECTORY_SEPARATOR."1hello.log");
        $this->assertFileExists($this->getTestDir().DIRECTORY_SEPARATOR."2hello.log");
        $this->assertFileExists($this->getTestDir().DIRECTORY_SEPARATOR."3hello.log");
        $this->assertFileExists($this->getTestDir().DIRECTORY_SEPARATOR."4hello.log");
        $this->assertFileExists($this->getTestDir().DIRECTORY_SEPARATOR."4hello4.log");

    }


    protected function setUp():void
    {
        mkdir($this->getTestDir());

        file_put_contents($this->getTestDir().DIRECTORY_SEPARATOR."1hello.log","hello_word".mt_rand(1,10));
        file_put_contents($this->getTestDir().DIRECTORY_SEPARATOR."2hello.log","hello_word".mt_rand(1,10));
        file_put_contents($this->getTestDir().DIRECTORY_SEPARATOR."3hello.log","hello_word".mt_rand(1,10));
        file_put_contents($this->getTestDir().DIRECTORY_SEPARATOR."4hello.log","hello_word".mt_rand(1,10));
        file_put_contents($this->getTestDir().DIRECTORY_SEPARATOR."4hello4.log","hello_word".mt_rand(1,10));

    }

    protected function tearDown()
    {
        $dir = $this->getTestDir();
        if (is_dir($dir)) system("rm -rf ".escapeshellarg($dir));
    }


    private function getTestDir():string
    {
        return dirname(__FILE__).DIRECTORY_SEPARATOR.$this->testDirName;
    }

}


