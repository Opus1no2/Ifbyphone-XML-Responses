<?php
require_once 'src/Ifbyphone/Route.php';

class RouteTest extends PHPUnit_Framework_TestCase
{
    private $_route;
    
    public function setup()
    {
        $this->_route = new Route();
    }
    
    public function testTransfer()
    {
        $xml = $this->_route->transfer(1112223333);
        $expected = '<?xml version="1.0" encoding="utf-8"?>
<action><app>transfer</app><parameters><destination>1112223333</destination></parameters></action>';
        $this->assertEquals($expected, trim($xml));
    }
        
    public function testSurvo()
    {
        $xml = $this->_route->survo(1234, array('foo'=>'bar'), 'some data');
        $expected = '<?xml version="1.0" encoding="utf-8"?>
<action><app>survo</app><parameters><id>1234</id><user_parameters><foo>bar</foo></user_parameters><p_t>some data</p_t></parameters></action>';    
        $this->assertEquals($expected, trim($xml));
    }
    
    public function testFindme()
    {
        $xml = $this->_route->findme(1234);
        $expected = '<?xml version="1.0" encoding="utf-8"?>
<action><app>findme</app><parameters><id>1234</id></parameters></action>';
        $this->assertEquals($expected, trim($xml));
    }
    
    public function testFindmeList()
    {
        $xml = $this->_route->findmeList(array(1112223333), array('nextactionitem'=>7));
        $expected = '<?xml version="1.0" encoding="utf-8"?>
<action><app>findme</app><parameters><phone_list>1112223333</phone_list><nextactionitem>7</nextactionitem></parameters></action>';
        $this->assertEquals($expected, trim($xml));
    }
    
    public function testVirtualReceptionist()
    {
        $xml = $this->_route->virtualReceptionist(1234);
        $expected = '<?xml version="1.0" encoding="utf-8"?>
<action><app>vr</app><parameters><id>1234</id></parameters></action>';
        $this->assertEquals($expected, trim($xml));
    }
    
    public function testVoicemail()
    {
        $xml = $this->_route->voicemail(1234);
        $expected = '<?xml version="1.0" encoding="utf-8"?>
<action><app>voicemail</app><parameters><id>1234</id></parameters></action>';
        $this->assertEquals($expected, trim($xml));
    }
    
    public function testHangup()
    {
        $xml = $this->_route->hangup();
        $this->assertEquals('<?xml version="1.0" encoding="utf-8"?>
<action><app>hangup</app></action>', trim($xml));
    }
    
    public function tearDown()
    {
        $this->_route = null;
    }
}