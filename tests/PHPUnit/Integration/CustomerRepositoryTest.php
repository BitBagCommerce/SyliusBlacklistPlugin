<?php

/*
 * This file has been created by developers from BitBag.
 * Feel free to contact us once you face any issues or want to start
 * You can find more information about us on https://bitbag.io and write us
 * an email on hello@bitbag.io.
 */

declare(strict_types=1);

namespace Tests\BitBag\SyliusBlacklistPlugin\PHPUnit\Integration;

use Tests\BitBag\SyliusBlacklistPlugin\Repository\CustomerRepository;

class CustomerRepositoryTest extends IntegrationTestCase
{
    private CustomerRepository $customerRepository;

    protected function setUp(): void
    {
        parent::setUp();

        $this->customerRepository = self::getContainer()->get('sylius.repository.customer');
    }

    public function tearDown(): void
    {
        parent::tearDown();
        self::ensureKernelShutdown();
    }
    public function test_find_customer_by_email_prefix(): void
    {
        $this->loadFixturesFromFiles(['test_find_customer_by_email_part.yaml']);

        $customers = $this->customerRepository->findByEmailPart('cust');

        $this->assertNotEmpty($customers);
        $this->assertCount(1, $customers);
    }

    public function test_find_customer_by_email_sufix(): void
    {
        $this->loadFixturesFromFiles(['test_find_customer_by_email_part.yaml']);

        $customers = $this->customerRepository->findByEmailPart('com');

        $this->assertNotEmpty($customers);
        $this->assertCount(1, $customers);
    }

    public function test_find_customer_by_email_part(): void
    {
        $this->loadFixturesFromFiles(['test_find_customer_by_email_part.yaml']);

        $customers = $this->customerRepository->findByEmailPart('1@');

        $this->assertNotEmpty($customers);
        $this->assertCount(1, $customers);
    }

    public function test_find_customer_by_email_not_found(): void
    {
        $this->loadFixturesFromFiles(['test_find_customer_by_email_part.yaml']);

        $customers = $this->customerRepository->findByEmailPart('cstomer');

        $this->assertEmpty($customers);
        $this->assertCount(0, $customers);
    }
}
