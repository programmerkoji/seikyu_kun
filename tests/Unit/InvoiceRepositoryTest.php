<?php

namespace Tests\Unit;

use App\Repositories\InvoiceRepository;
use App\Models\Company;
use App\Models\Invoice;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class InvoiceRepositoryTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function test_example()
    {
        $this->assertTrue(true);
    }

    public function test_get_all_with_company_relation()
    {

        $company = Company::factory()->create(['name' => 'Test Company']);
        $invoice = Invoice::factory()->create(['company_id' => $company->id]);

        $repository = new InvoiceRepository(new Invoice());
        $results = $repository->getAll(['company'])->get();

        $this->assertCount(1, $results);
        $this->assertEquals('Test Company', $results->first()->company->name);
    }
}
