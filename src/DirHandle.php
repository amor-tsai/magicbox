<?php declare(strict_types=1);
/**
 * Created by PhpStorm.
 * User: Amor
 * Date: 2017/8/28
 * Time: 11:24
 * Test
 */
namespace amortsai\magicbox;


class DirHandle
{
    /**
     * @param string $dirName 目录地址
     * @param bool $isDelete    是否删除,若不删除则用空字符串替换文件
     * @param bool $needle   是否针对特殊文件名
     * @param bool $isAll 是否针对所有文件
     */
    function cleanDir(string $dirName,bool $isDelete=false,string $needle='',bool $isAll=false):void
    {
        $cleanFileList = [];
        if (is_dir($dirName)) {
            if ($handle = opendir($dirName)) {
                while (false !== ($file = readdir($handle))) {
                    if ("." === $file || ".." === $file) continue;//跳过.和..
                    if("" !== $needle) {
                        if (false !== strpos($file,$needle)) {
                            $cleanFileList[] = $file;
                        }
                    } else {
                        $cleanFileList[] = $file;
                    }
                }
                closedir($handle);
            }
        }
        if (!empty($cleanFileList)) {
            if (!$isAll) {
                if ($isDelete) {
                    unlink($dirName.DIRECTORY_SEPARATOR.$cleanFileList[0]);
                } else {
                    file_put_contents($dirName.DIRECTORY_SEPARATOR.$cleanFileList[0],"");
                }
            }
            else {
                foreach ($cleanFileList as $file) {
                    if ($isDelete) {
                        unlink($dirName.DIRECTORY_SEPARATOR.$file);
                    } else {
                        file_put_contents($dirName.DIRECTORY_SEPARATOR.$file,"");
                    }

                }
            }
        }
    }
}

