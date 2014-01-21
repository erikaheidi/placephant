<?php
namespace Placephant;

use ReflectionObject;
use Symfony\Component\Finder\Finder;

class ResourceHelperTest extends \PHPUnit_Framework_TestCase
{
    public function directory_provider()
    {
        $dirBase = str_replace('test/', '', __DIR__);
        return array(
            array(null, $dirBase.'/Resources/images'),
            array('can be storaged', 'can be storaged'),
            array('//;sas/as', '//;sas/as')
        );
    }

    /**
     * @test
     */
    public function class_can_be_instantiated()
    {
        if (class_exists($className = __NAMESPACE__.'\ResourceHelper')) {
            $this->assertInstanceOf(
                $className,
                new ResourceHelper,
                sprintf('Class %s cannot be instantiated', $className)
            );
        }
    }

    /**
     * @test
     * @dataProvider directory_provider
     * @depends class_can_be_instantiated
     */
    public function it_can_storage_resource_path_on_resources_dir_property($path, $expected)
    {
        $resource = new ResourceHelper($path);
        $reflection = new ReflectionObject($resource);

        $property = $reflection->getProperty('resources_dir');
        $property->setAccessible(true);
        $value = $property->getValue($resource);

        $this->assertEquals($expected, $value);
    }
}
