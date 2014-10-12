<?php
/**
 * 
 * 
 * 
 * 
 */

namespace Cotya\ComposerMagentoPlugin\Tests\FullStack;

use Cotya\ComposerTestFramework;

class HelloWorldTest extends ComposerTestFramework\PHPUnit\FullStackTestCase
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
    
    
    public function testExample()
    {
        $this->assertTrue(true);
        //var_dump(self::getTempComposerProjectPath());
    }
    
    public function testComposerWrapperArchive()
    {
        $composer = new ComposerTestFramework\Composer\Wrapper();

        $artifactDirectory = new \SplFileInfo($this->tempdir());
        
        $packagesPath    = __DIR__ .'/../../tests/res/packages';
        $directory = new \DirectoryIterator($packagesPath);
        /** @var \DirectoryIterator $file */
        foreach ($directory as $file) {
            if (!$file->isDot() && $file->isDir()) {
                $composer->archive(
                    $file,
                    $artifactDirectory
                );
            }
        }
        
        $this->assertFileExists(
            $artifactDirectory->getPathname().'/magento-hackathon-magento-composer-installer-test-wildcard-1.0.0.zip'
        );
        $this->assertFileExists(
            $artifactDirectory->getPathname().'/magento-hackathon-magento-composer-installer-test-wildcard2-1.0.0.zip'
        );
        $this->assertFileExists(
            $artifactDirectory->getPathname().'/magento-hackathon-magento-composer-installer-test-library-1.0.0.zip'
        );
    }
}
