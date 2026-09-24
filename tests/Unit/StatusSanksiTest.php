<?php

namespace Tests\Unit;

use App\Models\PoinMahasiswa;
use PHPUnit\Framework\TestCase;

class StatusSanksiTest extends TestCase
{
    public function test_batas_setara_aturan_lama_dengan_poin_awal_65(): void
    {
        $level = fn (float $pel, float $peng = 0) =>
            PoinMahasiswa::getStatusSanksi(PoinMahasiswa::hitungPoinTotal($pel, $peng))['level'];

        // Tanpa penghargaan: hasil sama dengan aturan lama (50 / 75 / 100 pelanggaran)
        $this->assertSame('aman', $level(0));
        $this->assertSame('aman', $level(49));
        $this->assertSame('sp1', $level(50));
        $this->assertSame('sp1', $level(74));
        $this->assertSame('sp2', $level(75));
        $this->assertSame('sp2', $level(99));
        $this->assertSame('sp3', $level(100));

        // Penghargaan menaikkan poin total
        $this->assertSame('aman', $level(50, 20));
        $this->assertSame(65.0, PoinMahasiswa::hitungPoinTotal(0, 0));
    }
}
