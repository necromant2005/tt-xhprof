<?php
namespace TweeXhprof\View\Helper;
use PHPUnit_Framework_TestCase;

class XhprofTest extends PHPUnit_Framework_TestCase
{
    public function testInvoke()
    {
        $service = new Xhprof();
        $content = $service->__invoke();
        $this->assertEquals($service, $content);
        $this->assertEquals('', $content->__toString());
    }

    public function testRenderSimple()
    {
        $stack = array(
            'Zend\EventManager\SharedEventManager::attach==>array_key_exists' => array('ct' => 1, 'wt' => 1),
            'Zend\EventManager\EventManager::setIdentifiers==>is_array' => array('ct' => 2, 'wt' => 2),
            'Zend\EventManager\EventManager::__construct==>Zend\EventManager\EventManager::setIdentifiers' => array('ct' => 3, 'wt' => 3),
        );

        $service = new Xhprof();
        $content = $service->render($stack);
        foreach ($stack as $key => $data) {
            $this->assertContains($key, $content);
        }
    }

    public function testRenderGroup()
    {
        $stack = array(
            'Zend\EventManager\SharedEventManager::attach==>array_key_exists' => array('ct' => 1, 'wt' => 1),
            'Zend\EventManager\EventManager::setIdentifiers==>is_array' => array('ct' => 2, 'wt' => 2),
            'Zend\EventManager\EventManager::__construct==>Zend\EventManager\EventManager::setIdentifiers' => array('ct' => 3, 'wt' => 3),
            'Zend\EventManager\EventManager::setIdentifiers==>XXX' => array('ct' => 2, 'wt' => 2),
            'Zend\EventManager\EventManager::__construct==>ZZZ::setIdentifiers' => array('ct' => 3, 'wt' => 3),
        );

        $match = array(
            'Zend\EventManager\SharedEventManager',
            'Zend\EventManager\EventManager::setIdentifiers',
            'Zend\EventManager\EventManager::__construct',
        );

        $service = new Xhprof();
        $content = $service->renderGroup($stack);
        $this->assertCount(5, explode('</tr>', $content));
        foreach ($match as $key) {
            $this->assertContains($key, $content);
        }
    }
}