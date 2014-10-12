<?php
/**
 * 
 * 
 * 
 * 
 */

namespace Cotya\ComposerMagentoPlugin\Tests\FullStack;


use Cotya\ComposerTestFramework;

class MagentoPlainTest extends ComposerTestFramework\PHPUnit\FullStackTestCase
{


    protected function tempdir()
    {
        $tempfile = tempnam(sys_get_temp_dir(), '');
        if (file_exists($tempfile)) {
            unlink($tempfile);
        }
        mkdir($tempfile);
        if (is_dir($tempfile)) {
            return $tempfile;
        }
    }
    
    public function testInstall()
    {
        $composer = new ComposerTestFramework\Composer\Wrapper();
        
        $artifactDirectory = new \SplFileInfo($this->tempdir());
        $pluginDirectory   = new \SplFileInfo(realpath(__DIR__.'/../../'));
        $projectDirectory  = new \SplFileInfo($this->tempdir());
        //var_dump($pluginDirectory, $artifactDirectory, $projectDirectory);
        
        $composer->archive($pluginDirectory, $artifactDirectory);
        
        $composerJson = new  \SplTempFileObject();
        $composerJsonContent = <<<composerJson
{
    "repositories": [
        {
            "type": "artifact",
            "url": "$artifactDirectory/"
        },
        {
            "type": "composer",
            "url": "http://packages.firegento.com"
        }
    ],
    "require": {
        "cotya/composer-magento-plugin": "dev-master@dev",
        "firegento/psr0autoloader": "dev-master"
    }
}
composerJson;
        
        $composerJson->fwrite($composerJsonContent);
        
        $composer->install($projectDirectory, $composerJson);
        
        $this->assertFileNotExists(
            $projectDirectory.'/vendor/magento-hackathon/magento-composer-installer/composer.json'
        );
    }
}
