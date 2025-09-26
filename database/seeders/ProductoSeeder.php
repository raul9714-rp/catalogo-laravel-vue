<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Producto;

class ProductoSeeder extends Seeder
{
    public function run(): void
    {
        Producto::create([
            'codigo' => 'LAPTOPGAMER001',
            'nombre' => 'Laptop Gamer',
            'descripcion' => 'Laptop gamer con RTX 4070, 16GB RAM y SSD 1TB',
            'precio' => 2200.00,
            'stock' => 5,
            'fotografia' => 'productos/laptop-gamer.jpg',
            'fecha_ingreso' => '2025-09-01',
            'fecha_vencimiento' => '2027-09-01',
        ]);

        Producto::create([
            'codigo' => 'MOUSEGAMER002',
            'nombre' => 'Mouse Gamer',
            'descripcion' => 'Mouse gamer RGB con 25K DPI',
            'precio' => 75.00,
            'stock' => 20,
            'fotografia' => 'productos/mouse-gamer.jpg',
            'fecha_ingreso' => '2025-09-02',
            'fecha_vencimiento' => '2028-09-02',
        ]);

        Producto::create([
            'codigo' => 'TECLADOGAMER003',
            'nombre' => 'Teclado Mecánico',
            'descripcion' => 'Teclado gamer RGB switches Cherry MX',
            'precio' => 150.00,
            'stock' => 15,
            'fotografia' => 'productos/teclado-gamer.jpg',
            'fecha_ingreso' => '2025-09-03',
            'fecha_vencimiento' => '2028-09-03',
        ]);

        Producto::create([
            'codigo' => 'HEADSETGAMER004',
            'nombre' => 'Headset HyperX',
            'descripcion' => 'Audífonos gamer con sonido envolvente',
            'precio' => 99.00,
            'stock' => 25,
            'fotografia' => 'productos/headset-gamer.jpg',
            'fecha_ingreso' => '2025-09-04',
            'fecha_vencimiento' => '2028-09-04',
        ]);

        Producto::create([
            'codigo' => 'SILLAGAMER005',
            'nombre' => 'Silla Gamer',
            'descripcion' => 'Silla ergonómica gamer con soporte lumbar',
            'precio' => 350.00,
            'stock' => 8,
            'fotografia' => 'productos/silla-gamer.jpg',
            'fecha_ingreso' => '2025-09-05',
            'fecha_vencimiento' => '2030-09-05',
        ]);
    }
}
