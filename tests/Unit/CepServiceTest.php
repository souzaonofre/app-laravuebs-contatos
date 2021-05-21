<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;

use App\Services\CepService;

class CepServiceTest extends TestCase
{
    /**
     * A basic fucntion test.
     *
     * @return void
     */
    public function test_getAddressByCep()
    {
        $cep = '31070-010';
        
        $service = new CepService();
        
        $this->assertTrue(is_object($service));
        
        $data = $service->getAddressByCep($cep);

        $this->assertTrue(count($data) > 0);
        
        $this->assertArrayHasKey('cep', $data);
        
        $this->assertArrayHasKey('address', $data); 
    }
}
