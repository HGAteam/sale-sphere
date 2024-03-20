<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use App\Models\StockTransfer;
use App\Models\Product;

class ValidateTransferQuantity implements Rule
{
    protected $fromWarehouseId;
    protected $productId;

    public function __construct($fromWarehouseId, $productId)
    {
        $this->fromWarehouseId = $fromWarehouseId;
        $this->productId = $productId;
    }

    public function passes($attribute, $value)
    {
        // Lógica para verificar la cantidad en StockTransfer
        $totalStockTransferQuantity = StockTransfer::where('from_warehouse_id', $this->fromWarehouseId)
            ->where('product_id', $this->productId)
            ->where('status', 'In Progress')
            ->sum('quantity');

        $currentProductQuantity = Product::find($this->productId)->quantity;

        // Resta la cantidad actual del producto en StockTransfer
        $availableQuantity = $currentProductQuantity - $totalStockTransferQuantity;

        // Verifica si la cantidad solicitada es mayor a la cantidad disponible
        if ($value > $availableQuantity) {
            $this->message = 'La cantidad solicitada es mayor a la disponible. Puedes transferir un máximo de ' . $availableQuantity . ' productos.';
            return false;
        }

        return true;
    }

    public function message()
    {
        return $this->message ?? 'La cantidad solicitada no es válida.';
    }
}
