<?php
namespace TweeXhprof\View\Helper;
use PHPUnit_Framework_TestCase;

class XhprofTest extends PHPUnit_Framework_TestCase
{
    public function testInvoke()
    {
        $stack = array(
            'Zend\EventManager\SharedEventManager::attach==>array_key_exists' => array('ct' => 1, 'wt' => 1),
            'Zend\EventManager\EventManager::setIdentifiers==>is_array' => array('ct' => 2, 'wt' => 2),
            'Zend\EventManager\EventManager::__construct==>Zend\EventManager\EventManager::setIdentifiers' => array('ct' => 3, 'wt' => 3),
        );

        $service = new Xhprof();
        $content = $service->__invoke($stack);
        foreach ($stack as $key => $data) {
            $this->assertContains($key, $content);
        }
    }
}