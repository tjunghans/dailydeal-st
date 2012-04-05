<?php
require_once(dirname(__FILE__) . '/../../test/simpletest/autorun.php');
require_once(dirname(__FILE__) . '/../../application/libs/FormHelper.php');

class TestOfFormHelper extends UnitTestCase {
    function testIsValidVoucherCode() {
        $this->assertTrue(FormHelper::isValidVoucherCode('10-18267-RNT'));
        $this->assertTrue(FormHelper::isValidVoucherCode('17-18267-TCN'));
        $this->assertTrue(FormHelper::isValidVoucherCode('6-18267-BWY'));
        $this->assertTrue(FormHelper::isValidVoucherCode('123-456-789-1234'));
        $this->assertFalse(FormHelper::isValidVoucherCode('123-456-789-12345'));
        $this->assertFalse(FormHelper::isValidVoucherCode('123-'));
        $this->assertFalse(FormHelper::isValidVoucherCode('6#18267%&BWY'));
        $this->assertTrue(FormHelper::isValidVoucherCode('6-1ö267-ÄWY'));
        $this->assertFalse(FormHelper::isValidVoucherCode('6-1ö267.ÄWY'));
    }
}
?>