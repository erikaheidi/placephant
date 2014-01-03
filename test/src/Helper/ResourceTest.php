<?php
namespace Helper;

use ReflectionObject;
use Symfony\Component\Finder\Finder;

class ResourceTest extends \PHPUnit_Framework_TestCase
{

    public function directory_provider()
    {
        $dirBase = str_replace('test/', '', __DIR__); 
        return array(
            array(null, $dirBase.'/../resources'),
            array('can be storaged', 'can be storaged'),
            array('//;sas/as', '//;sas/as')
        );
    }

    /**
     * @test
     */ 
	public function class_can_be_instaciate()
	{
		if (class_exists($className = __NAMESPACE__.'\Resource')) {
            $this->assertInstanceOf(
                $className,
                new Resource, 
                sprintf('Class %s cannot be instanciate', $className)
            );
        }
	}

    /**
     * @test
     * @dataProvider directory_provider
     * @depends class_can_be_instaciate
     */
    public function class_can_storage_resource_path_on_resources_dir_property($path, $expected)
    {
        $resource = new Resource($path);
        $reflection = new ReflectionObject($resource);

        $property = $reflection->getProperty('resources_dir');
        $property->setAccessible(true);
        $value = $property->getValue($resource);

        $this->assertEquals($expected, $value);
    }

}